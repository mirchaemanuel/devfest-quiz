<div class="group m-2 p-2 w-[200px] rounded border border-gray-400 hover:bg-gray-100">
    <div class="h-full flex flex-col gap-2 justify-between items-start">
        <h4>{{ $quiz->title }}</h4>
        <div class="flex flex-col justify-end items-start">
            <div class="font-semibold">
                <span>{{ __('Questions') }}:</span> <span>{{ $quiz->questions->count() }}</span>
            </div>
            <div class="font-semibold">
                <span>{{ __('Max score') }}:</span> <span>{{ $quiz->questions->sum('score') }}</span>
            </div>
        </div>
    </div>
</div>
