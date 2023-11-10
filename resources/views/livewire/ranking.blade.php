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
            @foreach($results as $result)
                <tr>
                    <td>{{ $result->name }}</td>
                    <td>{{ $result->total_score }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
