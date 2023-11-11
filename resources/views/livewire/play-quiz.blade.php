<div
    class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <div class="mb-8">
        <button wire:click="startQuiz" @if($started)disabled @endif
                class="bg-blue-500 hover:bg-blue-700 disabled:bg-gray-300 text-white font-bold py-2 px-4 rounded">
            {{ __('Start quiz') }}
        </button>
    </div>
    <section id="questions">
        <table class="min-w-full divide-y divide-gray-300">
            <thead>
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-base font-semibold text-gray-900 sm:pl-3">Question</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3">True</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3">False</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            @foreach($questions as $question)
                <tr class="even:bg-gray-50">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-base font-medium text-gray-900 sm:pl-3">{{ $question->question }}</td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-3">
                        <button wire:click="markTrue({{ $question->id }})" @if(!$started)disabled @endif
                                class="bg-green-500 hover:bg-green-700 disabled:bg-gray-300 text-white font-bold py-2 px-4 rounded">
                            {{ __('True') }}
                        </button>
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-center text-sm font-medium sm:pr-3">
                        <button wire:click="markFalse({{ $question->id }})" @if(!$started)disabled @endif
                                class="bg-red-500 hover:bg-red-700 disabled:bg-gray-300 text-white font-bold py-2 px-4 rounded">
                            {{ __('False') }}
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
</div>
