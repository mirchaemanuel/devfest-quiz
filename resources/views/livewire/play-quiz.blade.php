<div
    class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <section id="questions">
        <table>
            <thead>
            <tr>
                <th>Question</th>
                <th>True</th>
                <th>False</th>
            </tr>
            </thead>
            <tbody>
            @foreach($quiz->questions()->inRandomOrder(microtime())->get() as $question)
                <tr>
                    <td>{{ $question->question }}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
</div>
