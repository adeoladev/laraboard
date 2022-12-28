@extends('header')
<title>{{ config('app.name') }} - Moderation</title>
@section('content')

<br>

<div class='flexcenter'><p class='name'>Moderation</p></div><br>

<div class='flexcenter'>
<div class='width-80'>

        <div class='tabs'>
        <a href="{{route('moderation.threads')}}"><p class='date'>Threads</p></a>
        <a href="{{route('moderation.boards')}}"><p class='date'>Boards</p></a>
        <a href="{{route('moderation.categories')}}"><p class='date'>Categories</p></a>
        <a href="{{route('moderation.users')}}"><p class='date'>Users</p></a>
        <a href="{{route('moderation.files')}}"><p class='date'>Files</p></a>
        <p class='title'>Archives</p>
        <a href="{{route('moderation.pins')}}"><p class='date'>Pins</p></a>
        </div>
        
        <br>

        <div style='display:flex'>
        <form method='get'>
        @csrf
        <input type='text' name='search' value='{{request()->search}}' placeholder='Message'>
        <select name="boards">
        <option selected value=''>All Boards</option>
        @foreach($boards as $board)
        <option @if(request()->boards == $board->tag) selected @endif value='{{$board->tag}}'>{{$board->name}}</option>
        @endforeach
        </select>
        <button>search</button>
        </form>
        </div>

      @include('inc.status')
        <br>
        
        <table>
            <tr>
              <th>Title</th>
              <th>File</th>
              <th>Message</th>
              <th>Files</th>
              <th>Replies</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
            @foreach($threads as $thread)
            <tr>
              <td>{{$thread->title ?? '-'}}</td>
              <td onclick="window.open('{{asset($thread->file)}}')" style='width:50px;height:50px;background-image:url({{asset($thread->thumbnail)}})'></td>
              <td>{{$thread->message}}</td>
              <td>{{$thread->files}}</td>
              <td>{{$thread->replies}}</td>
              <td>{{$thread->created_at->format('d M Y g:i a')}}</td>
              <td><img class='icons' title='Mark as spoiler' onclick="window.location='{{route('moderation.files.spoiler',['reply'=>$thread->thread_id,'thread'=>$thread->thread_id] )}}';" src="{{asset('files/system/spoiler.png')}}"> <img class='icons' title='Pin/Un-Pin' onclick="window.location='{{route('moderation.pin',$thread->thread_id)}}';" src="{{asset('files/system/pushpin.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.archive',$thread->thread_id)}}';" title='Archive/Un-Archive' onclick="window.location='{{route('moderation.archive',$thread->thread_id)}}';" src="{{asset('files/system/archive.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.thread.delete',$thread->thread_id)}}';" title='Delete' src="{{asset('files/system/delete.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.thread.ban',$thread->thread_id)}}';" title='Delete & Ban IP' src="{{asset('files/system/ban.png')}}"></td>
            </tr>
            @endforeach
        </table>

          {{$threads->links()}}
</div>
</div>

@endsection
