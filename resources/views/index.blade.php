@extends('master')


@section('title', 'Laraboard')


@section('content')



<br>
<link rel="stylesheet" href="{{ mix('css/app.css') }}" />
<script defer src="{{ mix('js/app.js') }}"></script>
<form action='{{route("newthread")}}' id='replyform' method='post' enctype="multipart/form-data">
    @csrf
    <input type='text' name='name' placeholder='name (optional)'><br>
    <textarea type='text' name='message' rows="7" cols="60" style='width:300px;max-height:220px;max-width:300px;min-width:300px;' required></textarea><br>
    <input type='file' name='upload'><br><br>
    <button type='submit'>SUBMIT</button>
</form>
<div id='mainarea'>
<div id='mainarea2'>

<div id='msgs'>     

@foreach($messages as $msg)
    <ol>
        <li>
        <div class='indiv'><div id='top'><p><strong>{{$msg->name}}</strong><a href='thread/{{$msg->thread_id}}'>Reply</a></p><p class='date'>{{$msg->date}}</p> </div><br><div style='max-height: 345px;overflow: hidden;'>@if ($msg->image)<a href='thread/{{$msg->thread_id}}'><img class='homeimg' src={{$msg->image}}></a> <br>@else {{""}} @endif<p>{{$msg->message}}</p></div></div>
        <p class='stats'>{{$msg->replies}} Replies</p>
        </li>
        <br>
    </ol>

@endforeach

</div>
</div>
</div>

<div id='app'>
    <example-component></example-component>
</div>


@endsection
