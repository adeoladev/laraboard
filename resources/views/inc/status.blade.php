@if (session('status'))
        {{ session('status') }}
@endif
@if ($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
@endif