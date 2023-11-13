<div class="group m-2 p-2 w-[350px] md:w-[400px] h-[250px] rounded border border-gray-400 hover:bg-gray-100 shadow-lg">
    <div class="h-full flex flex-col gap-2 justify-between items-stretch">
        <h4 class="font-bold text-xl text-center text-gray-900">{{ $quiz->title }}</h4>
        <div class="flex items-center justify-center">
            <img src="{{ Vite::asset('resources/assets/images/quizfest.png') }}" class="w-8 h-8" alt="image logo" title="LOGO" />
        </div>
        <div class="flex flex-col justify-end items-stretch">
            <div class="font-bold">
                <span>{{ __('Questions') }}:</span> <span class="font-medium">{{ $quiz->questions->count() }}</span>
            </div>
            <div class="font-bold">
                <span>{{ __('Max score') }}:</span> <span class="font-medium">{{ $quiz->questions->sum('score') }}</span>
            </div>
            <div class="w-full text-right">
                <a class="font-extrabold text-2xl hover:underline text-right cursor-pointer text-blue-600"
                   href="{{ route('pages.members.quiz.show', $quiz) }}" wire:navigate>
                    >{{ __('Play quiz') }}
                </a>
            </div>
        </div>
    </div>
</div>
