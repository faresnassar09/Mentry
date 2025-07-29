<div class="max-w-2xl mx-auto space-y-6">

    <div>
        <label class="block text-sm font-bold mb-1 text-gray-700">{{ __('messages.schedule_duration_label') }}</label>
        <input
            type="number"
            wire:model.live="totalMinutes"
            class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div class="flex gap-4">
        <div class="w-2/3">
            <input type="text" wire:model.defer="subjectName" placeholder="{{ __('messages.subject_name_placeholder') }}" class="w-full border rounded px-3 py-2 text-sm">
            @error('subjectName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="w-1/3">
            <input type="number" wire:model.defer="subjectMinutes" placeholder="{{ __('messages.duration_minutes_placeholder') }}" class="w-full border rounded px-3 py-2 text-sm">
            @error('subjectMinutes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <button wire:click="addSubject" type="button"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + {{ __('messages.add_button_short') }}
        </button>
    </div>

    <div class="border rounded p-4">
        <h3 class="font-bold text-gray-700 mb-2 text-sm">{{ __('messages.added_subjects_heading') }}:</h3>
        <ul class="space-y-2 text-sm">
            @foreach($subjects as $index => $subject)
                <li class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded">
                    <div>{{ $subject['name'] }} - {{ $subject['minutes'] }} {{ __('messages.minutes_unit') }}</div>
                    <button wire:click="removeSubject({{ $index }})" class="text-red-600 text-xs hover:underline">{{ __('messages.delete_button_short') }}</button>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="text-sm text-gray-600">
        <div>{{ __('messages.total_allowed_time') }}: <strong>{{ $totalMinutes ?? 0 }}</strong> {{ __('messages.minutes_unit') }}</div>
        <div>{{ __('messages.used_time') }}: <strong>{{ collect($subjects)->sum('minutes') ?? 0 }}</strong> {{ __('messages.minutes_unit') }}</div>
        <div>{{ __('messages.remaining_time') }}:
            <strong class="{{ ($totalMinutes - collect($subjects)->sum('minutes')) < 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ $totalMinutes - collect($subjects)->sum('minutes') ?? 0 }}
            </strong> {{ __('messages.minutes_unit') }}
        </div>
    </div>

    <div class="pt-4 text-end">
        <button wire:click="save"
            class="bg-green-500 hover:bg-green-500 text-white px-6 py-2 rounded text-sm shadow">
            💾 {{ __('messages.save_schedule_button') }}
        </button>
    </div>

</div>