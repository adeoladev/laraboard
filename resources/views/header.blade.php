<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css" >
<script src="../resources/js/app.js"></script>
</head>

<div id='header'><a href="{{route('home')}}"><p>{{ config('app.name') }}</p></a>

@if(isset($tag))
<p><a href="{{route('board',$tag)}}">/{{$tag}}/ - {{$name}}</a></p>
@endif

@if($page == 'board')
<button class='postButton' id='postThread'>NEW THREAD</button>
<form action="{{route('newthread', $tag)}}" class='form' method='post' enctype="multipart/form-data">
    @csrf
    <input type='text' name='name' placeholder='name (optional)'>
    <input type='text' name='title' placeholder='title (optional)' maxlength="48">
    <br>
    <textarea type='text' name='message' rows="7" cols="60" required></textarea><br>
    <input type='file' name='upload' required><br><br>
    <button type='submit'>SUBMIT</button>
</form>
@elseif($page == 'thread')
<button class='postButton' id='postReply'>NEW REPLY</button>
<form action="{{route('newreply', $thread)}}" class='form' method='post' enctype="multipart/form-data">
    @csrf
    <input type='text' name='name' placeholder='name (optional)'>
    <br>
    <textarea type='text' name='message' rows="7" cols="60" required></textarea><br>
    <input type='file' name='upload'><br><br>
    <button type='submit'>SUBMIT</button>
</form>
@endif
  


</div>


@yield('content')

</html>