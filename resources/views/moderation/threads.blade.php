@extends('header',['page'=>'moderation','thread'=>null,'tag'=>null])
<title>{{ config('app.name') }} - Moderation</title>
@section('content')

<br>

<div class='flexcenter'><p class='name'>Moderation</p></div><br>

<div class='flexcenter'>
<div class='width-80'>

        <x-navigation></x-navigation>
        
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
              <td class='tmsg'>{{$thread->message}}</td>
              <td>{{$thread->files}}</td>
              <td>{{$thread->replies}}</td>
              <td>{{$thread->created_at->format('d M Y g:i a')}}</td>
              <td>
                <img class='icons' onclick="window.location='{{route('thread',['board' =>$thread->board,'id'=>$thread->thread_id])}}';" title='View' src="{{asset('files/system/go.png')}}"> 
                <img class='icons' title='Pin/Un-Pin' onclick="window.location='{{route('moderation.pin',$thread->thread_id)}}';" src="{{asset('files/system/pushpin.png')}}"> 
                <img class='icons' onclick="window.location='{{route('moderation.archive',$thread->thread_id)}}';" title='Archive/Un-Archive' onclick="window.location='{{route('moderation.archive',$thread->thread_id)}}';" src="{{asset('files/system/archive.png')}}"> 
                <img class='icons' onclick="window.location='{{route('moderation.thread.delete',$thread->thread_id)}}';" title='Delete' src="{{asset('files/system/delete.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.ban.redirect',$thread->ip_address)}}';" title='Delete & Ban IP' src="{{asset('files/system/ban.png')}}">
              </td>
            </tr>
            @endforeach
        </table>

        {{$threads->withQueryString()->links()}}
</div>
</div>

@endsection
