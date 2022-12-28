<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css" >
<script src="../resources/js/app.js"></script>
</head>

<div id='header'>
    <a href="{{route('home')}}"><p class='name'>{{ config('app.name') }}</p></a>
@if(isset($tag))
<p class='name'><a href="{{route('board',$tag)}}">/{{$tag}}/ - {{$name}}</a></p>
@endif


@if(isset($page) && $page == 'board')
<button class='postButton' id='postThread'>NEW THREAD</button>
<form action="{{route('newthread', $tag)}}" class='form' method='post' enctype="multipart/form-data">
    @csrf
    <input type='text' name='name' placeholder='name (optional)'>
    <input type='text' name='title' placeholder='title (optional)' maxlength="48">
    <br>
    <textarea type='text' name='message' required></textarea><br>
    <div style="display:flex;justify-content:space-between">
    <input type='file' name='upload'><button style="height:fit-content">Choose Link</button>
    </div>
    <input type='text' name='linkupload' placeholder='Enter a URL'><br>
    <button type='submit'>SUBMIT</button>
    @include('inc.status')
</form>

@elseif(isset($page) && $page == 'thread')
<button class='postButton' id='postReply'>NEW REPLY</button>
<form action="{{route('newreply', $thread)}}" class='form' method='post' enctype="multipart/form-data">
    @csrf
    <input type='text' name='name' placeholder='name (optional)'>
    <input type='hidden' name='board' value='{{$tag}}'>
    <br>
    <textarea type='text' name='message' rows="7" cols="60" required></textarea><br>
    <div style="display:flex;justify-content:space-between">
    <input type='file' name='upload'><button style="height:fit-content">Choose Link</button>
    </div>
    <input type='text' name='linkupload' placeholder='Enter a URL'><br>
    <button type='submit'>SUBMIT</button>
    @include('inc.status')
</form>
@endif

</div>

@yield('content')

</html>