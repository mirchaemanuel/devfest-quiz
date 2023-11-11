<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quiz: :quiz-title', ['quiz-title' => $quiz->title] ) }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{--   instructions   --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <section id="instructions"
                         class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                    <h1 class="mt-2 text-2xl font-medium text-gray-900 dark:text-white">
                        {{ __('Instructions') }}
                    </h1>
                    <div class="mt-6 text-gray-500 dark:text-gray-800 leading-relaxed">
                        Lorem ipsum dolor sit amet
                    </div>
                </section>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                {{--  play quiz component  --}}
                <livewire:play-quiz :user="auth()->user()" :quiz="$quiz"/>
            </div>
        </div>
    </div>
</x-app-layout>
