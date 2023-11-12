<div
    class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <div id="quiz-summary" class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        @if($started && !$completed)
            <button wire:click="terminateQuiz"
                    wire:confirm="{{ __('Are you sure you want to terminate the quiz?') }}"
                    class="bg-red-500 hover:bg-red-700 disabled:bg-gray-300 text-white font-bold py-2 px-4 rounded">
                {{ __('Terminate quiz') }}
            </button>
        @endif
        @if(!$started && !$completed)
            <button wire:click="startQuiz"
                    class="bg-blue-500 hover:bg-blue-700 disabled:bg-gray-300 text-white font-bold py-2 px-4 rounded">
                {{ __('Start quiz') }}
            </button>
        @endif
        @if($started && $completed)
            <a href="{{ route('pages.members.dashboard') }}" wire:navigate
               class="bg-blue-500 hover:bg-blue-700 disabled:bg-gray-300 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to dashboard') }}
            </a>
        @endif
        <div class="font-bold text-base md:text-2xl">
            <span>{{ __('Score') }}:</span><span>{{ $score }}</span>
        </div>
        <div class="font-bold">
            <span>{{ __('Answers') }}:</span><span>{{ $totalAnswers }}</span>
        </div>
    </div>
    <section id="questions">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-base font-semibold text-gray-900 sm:pl-3">
                    {{ __('Question') }}
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3">{{ __('True') }}</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3">{{ __('False') }}</th>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-base font-semibold text-gray-900 sm:pl-3">
                    {{ __('Result') }}
                </th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($questions as $question)
                <tr id="question-{{ $question->id }}" class="even:bg-gray-50">
                    <td class="py-4 pl-4 pr-3 text-base font-medium text-gray-900 sm:pl-3">{{ $question->question }}</td>
                    <td id="answer-true-{{ $question->id }}" class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-3">
                        <button wire:click="markTrue({{ $question->id }})"
                                @if(!$started || $completed || array_key_exists($question->id, $answers))disabled="disabled" @endif
                                class="bg-green-500 hover:bg-green-700 disabled:bg-gray-300 text-white font-bold py-2 px-4 rounded">
                            {{ __('True') }}
                        </button>
                    </td>
                    <td id="answer-false-{{ $question->id }}" class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-3">
                        <button wire:click="markFalse({{ $question->id }})"
                                @if(!$started || $completed || array_key_exists($question->id, $answers))disabled="disabled" @endif
                                class="bg-red-500 hover:bg-red-700 disabled:bg-gray-300 text-white font-bold py-2 px-4 rounded">
                            {{ __('False') }}
                        </button>
                    </td>
                    <td id="result-{{ $question->id }}"
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-base font-medium text-gray-900 sm:pl-3">
                        @if(array_key_exists($question->id, $answers))
                            @if($answers[$question->id] === $question->solution)
                                <span class="text-green-500">{{ __('Correct') }}</span>
                                <span>{{ $question->solution ? __('True') : __('False') }}</span>
                            @else
                                <span class="text-red-500">{{ __('Incorrect') }}</span>
                                <span>{{ $question->solution ? __('True') : __('False') }}</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
</div>
