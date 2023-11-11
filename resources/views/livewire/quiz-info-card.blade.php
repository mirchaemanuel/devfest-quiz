<div class="group m-2 p-2 w-[200px] h-[250px] rounded border border-gray-400 hover:bg-gray-100">
    <div class="h-full flex flex-col gap-2 justify-between items-stretch">
        <h4 class="font-bold text-lg text-center text-gray-900">{{ $quiz->title }}</h4>
        <div class="flex flex-col justify-end items-stretch">
            <div class="font-bold">
                <span>{{ __('Questions') }}:</span> <span class="font-medium">{{ $quiz->questions->count() }}</span>
            </div>
            <div class="font-bold">
                <span>{{ __('Max score') }}:</span> <span class="font-medium">{{ $quiz->questions->sum('score') }}</span>
            </div>
            <div class="w-full text-right">
                <a class="font-extrabold text-xl text-gray-700 hover:underline text-right cursor-pointer"
                   href="{{ route('pages.members.quiz.show', $quiz) }}" wire:navigate>
                    >{{ __('Play quiz') }}
                </a>
            </div>
        </div>
    </div>
</div>
