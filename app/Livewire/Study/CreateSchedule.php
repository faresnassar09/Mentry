<?php

namespace App\Livewire\Study;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;


class CreateSchedule extends Component
{
    public $totalMinutes = null;
    public $subjects = [];

    public $subjectName = '';
    public $subjectMinutes = '';

    public function addSubject()
    {
        $this->validate([
            'subjectName' => 'required|string|max:255',
            'subjectMinutes' => 'required|integer|min:1',
        ]);

        $usedMinutes = collect($this->subjects)->sum('minutes');

        if (($usedMinutes + $this->subjectMinutes) > $this->totalMinutes) {
            $this->addError('subjectMinutes', 'المدة تتجاوز الوقت الكلي المتاح.');
            return;
        }

        $this->subjects[] = [
            'name' => $this->subjectName,
            'minutes' => $this->subjectMinutes,
        ];

        $this->reset(['subjectName', 'subjectMinutes']);
    }

    public function removeSubject($index)
    {
        unset($this->subjects[$index]);
        $this->subjects = array_values($this->subjects); // إعادة ترتيب الفهارس
    }


    public function save()
    {
        if (empty($this->subjects)) {
            $this->addError('subjects', 'يجب إضافة مادة واحدة على الأقل.');
            return;
        }

        try {
            DB::beginTransaction();

            $schedule = Auth::user()->studySchedules()->create([
                'ends_at' => now()->addMinutes(intval($this->totalMinutes)),
            ]);

            foreach ($this->subjects as $subject) {
                if (trim($subject['name']) === '' || intval($subject['minutes']) <= 0) continue;

                $schedule->items()->create([
                    'task' => $subject['name'],
                    'ends_at' => now()->addMinutes(intval($subject['minutes'])),
                ]);
            }

            DB::commit();

            return redirect()->route('users.study.schedules.index')->with('success','تم حفظ الجدول بنجاح.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('user')->error('error occurred while saving study schedule', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            session()->flash('failed', 'حدث خطأ أثناء حفظ الجدول.');
        }
    }

    public function render()
    {
        return view('livewire.study.create-schedule');
    }
}
