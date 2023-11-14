<div class="">
    <h3 class="font-bold text-xl text-center mb-4 text-gray-900 dark:text-gray-100">{{ __('Best 10 players') }}</h3>

    <div class="-mx-4 mt-2 mb-2 ring-1 ring-gray-300 dark:ring-gray-800 sm:mx-0  bg-gray-100 dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700 ">
            <thead>
            <tr class="bg-gray-200 dark:bg-gray-600 ">
                <th scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-base font-semibold text-gray-900 dark:text-gray-100 sm:pl-6">{{ __('User') }}</th>
                <th scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-base font-semibold text-gray-900 dark:text-gray-100 sm:pl-6 ">{{ __('Score') }}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
            @foreach($results as $result)
                <tr>
                    <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6">{{ $result->name }}</td>
                    <td class="relative py-4 pl-4 pr-3 text-base sm:pl-6 font-bold">{{ $result->total_score }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
