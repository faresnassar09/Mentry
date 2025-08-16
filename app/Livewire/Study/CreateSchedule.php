<?php

namespace App\Livewire\Study;

use App\Service\Web\Logging\LoggingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $this->addError('subjectMinutes', __('notifications.schedule_time_excede_limit'));
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
        $this->subjects = array_values($this->subjects); 
    }


    public function save()
    {
        if (empty($this->subjects)) {
            $this->addError('subjects',__('notifications.schedule_min_subjects'));
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

            return to_route('users.study.schedules.index')->with('success',__('notifications.schedule_created_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();

            app(LoggingService::class)->failedLogger('Study Schedule','creating',[

                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed', __('notifications.schedule_create_failed'));
        }
    }

    public function render()
    {
        return view('livewire.study.create-schedule');
    }
}
