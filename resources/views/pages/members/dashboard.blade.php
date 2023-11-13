<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-1 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <section id="user-statistics"
                         class="p-2 sm:p-4 md:p-6 lg:p-8  bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <h1 class="mt-2 text-2xl font-medium text-gray-900 dark:text-white">
                        {{ __('Your statistics') }}
                    </h1>
                    <div class="mt-6 text-gray-500 dark:text-gray-800 leading-relaxed">
                        <h2 class="text-xl font-medium text-gray-900 mb-2">{{ auth()->user()->name  }}</h2>
                        <ul class="list-disc ml-8 text-lg">
                            <li>{{ __('Quiz attempts: :count', ['count' => $totalCompletedQuizzes]) }}</li>
                            <li>{{ __('Last quiz attempt: :date', ['date' => $lastQuizAttemptDate]) }}</li>
                            <li>{{ __('Total score: :score', ['score' => $totalScore]) }}</li>
                        </ul>
                    </div>
                </section>
            </div>
            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <section id="quizzes"
                         class="p-2 sm:p-4 md:p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <h1 class="mt-2 text-2xl font-medium text-gray-900 dark:text-white">
                        {{ __('Quizzes') }}
                    </h1>
                    <div class="mt-6 text-gray-500 dark:text-gray-800 leading-relaxed flex flex-wrap justify-center gap-2">
                        @foreach($quizzes as $quiz)
                            <livewire:quiz-info-card :quiz="$quiz" />
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
