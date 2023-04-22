@extends('header',['page'=>'board','tag'=>$thisBoard->tag,'name'=>$thisBoard->name,'thread'=>null])
<title>/{{$thisBoard->tag}}/ - {{$thisBoard->name}}</title>
@section('content')

<br>

<div class='flexcenter'>
<div class='boards-width'>

<div class='flexwrap justify-content'>  
    @foreach($pinnedThreads as $pinnedThread)
    <ol>
    <li>
        <div class='postcontainer boards-thread-width' style='max-height: 292px;'>
            <div>
            <a href="{{route('thread',['board' =>$thisBoard->tag,'id'=>$pinnedThread->thread_id])}}"><div class='threadimg' style="background-image:url('{{asset($pinnedThread->thumbnail)}}')"></div></a>
            <img class='icons' title='Pinned' src="{{asset('files/system/pushpin.png')}}">  
            @if($pinnedThread->archived) <img class='icons' title='Pinned' src="{{asset('files/system/archive.png')}}">@endif
            <br>
            <strong class='title'>{{$pinnedThread->title}}</strong>
            <p>{{$pinnedThread->message}}</p>
            </div>
        </div>
        <p style="margin-top: 10px;font-size: 13px;">{{$pinnedThread->replies}} Replies {{$pinnedThread->files}} Files  
            @if(isset(auth()->user()->username)) <img class='icons' title='Pin/Un-Pin' onclick="window.location='{{route('moderation.pin',$pinnedThread->thread_id)}}';" src="{{asset('files/system/pushpin.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.archive',$pinnedThread->thread_id)}}';" title='Archive/Un-Archive' src="{{asset('files/system/archive.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.thread.delete',$pinnedThread->id)}}';" title='Delete' src="{{asset('files/system/delete.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.thread.ban',$pinnedThread->id)}}';" title='Delete & Ban IP' src="{{asset('files/system/ban.png')}}">@endif 
        </p>
    </li>
    <br>
    </ol>
    @endforeach   
    @foreach($threads as $thread)
    <ol>
    <li>
        <div class='postcontainer boards-thread-width' style='max-height: 292px;'>
            <div>
            <a href="{{route('thread',['board' =>$thisBoard->tag,'id'=>$thread->thread_id])}}"><div class='threadimg' style="background-image:url('{{asset($thread->thumbnail)}}')"></div></a>
            @if($thread->archived) <img class='icons' title='Archived' src="{{asset('files/system/archive.png')}}"> @endif  
            <br>
            <strong class='title'>{{$thread->title}}</strong>
            <p>{{$thread->message}}</p>
            </div>
        </div>
        <p style="margin-top: 10px;font-size: 13px;">{{$thread->replies}} Replies {{$thread->files}} Files  
            @if(isset(auth()->user()->username)) <img class='icons' title='Pin/Un-Pin' onclick="window.location='{{route('moderation.pin',$thread->thread_id)}}';" src="{{asset('files/system/pushpin.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.archive',$thread->thread_id)}}';" title='Archive/Un-Archive' src="{{asset('files/system/archive.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.thread.delete',$thread->thread_id)}}';" title='Delete' src="{{asset('files/system/delete.png')}}"> <img class='icons' onclick="window.location='{{route('moderation.thread.ban',$thread->thread_id)}}';" title='Delete & Ban IP' src="{{asset('files/system/ban.png')}}">@endif 
        </p>
    </li>
    <br>
    </ol>
    @endforeach
</div>

</div>
</div>

<x-footer :boards="$boards"></x-footer>
@endsection
