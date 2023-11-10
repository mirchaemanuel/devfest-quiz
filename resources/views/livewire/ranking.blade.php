<div>
    <div>
        <table>
            <thead>
            <tr>
                <th>{{ __('User') }}</th>
                <th>{{ __('Score') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($scoredUsers as $scoreUser)
                <tr>
                    <td>{{ $scoredUsers->name }}</td>
                    <td>{{ $scoredUsers->score }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
