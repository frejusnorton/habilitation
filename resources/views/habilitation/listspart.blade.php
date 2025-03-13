        @foreach ($results as $result)
            <option value="{{ $result->age }}">
                {{ $result->lib }}
        @endforeach
