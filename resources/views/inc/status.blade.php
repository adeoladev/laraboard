@if (session('status'))
<div id='status'>
        {{ session('status') }}
</div>
@endif
@if ($errors->any())
<div id='status'>
<p>Error:</p>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
</div>
@endif

