<a class="m-2 rounded-lg border-2 border-gray-400 p-2 text-gray-900 shadow-lg group w-[350px] h-[250px]
            hover:bg-gray-100 dark:text-white md:w-[400px] dark:hover:bg-gray-900 group"
   href="{{ route('pages.members.quiz.show', $quiz) }}" wire:navigate>
    <div class="flex h-full flex-col items-stretch justify-between gap-2">
        <h4 class="text-center text-2xl font-bold">{{ $quiz->title }}</h4>
        <div class="flex items-center justify-center">
            <img src="{{ Vite::asset('resources/assets/images/quizfest.png') }}" class="h-8 w-8" alt="image logo"
                 title="LOGO"/>
        </div>
        <div class="flex flex-col items-stretch justify-end">
            <div class="grid grid-cols-2">
                <div class="font-bold">
                    <span>{{__('Attempts')}}:</span>
                    <span id="quiz-{){ $quiz->id  }}-attempts" class="font-medium">{{ $totalCompletedAttempts  }}</span>
                </div>
                <div class="font-bold">
                    <span>{{ __('Questions') }}:</span>
                    <span class="font-medium">{{ $quiz->questions->count() }}</span>
                </div>
                <div class="font-bold">
                    <span>{{__('Actual score')}}:</span>
                    <span id="quiz-{{ $quiz->id  }}-score" class="font-medium">{{ $totalScore  }}</span>
                </div>
                <div class="font-bold">
                    <span>{{ __('Max score') }}:</span>
                    <span class="font-medium">{{ $quiz->questions->sum('score') }}</span>
                </div>
            </div>

            <div class="w-full text-right">
                <div
                    class="cursor-pointer text-right text-2xl font-extrabold text-blue-600 group-hover:underline dark:text-blue-200">
                    {{ __('Play quiz') }}
                </div>
            </div>
        </div>
    </div>
</a>

