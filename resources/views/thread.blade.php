@extends('header',['page'=>'thread','thread'=>$mainmsg->thread_id,'tag'=>$tag,'name'=>$name,'archived'=>$mainmsg->thread->archived])
<title>/{{$tag}}/ - {{$mainmsg->message}}</title>
@section('content')
<script> var domain="{{Request::root()}}"; </script>

<br>

<div id='file_container' style='position:absolute;'>
<img id='main_image' src='{{asset('files/system/nothing.png')}}' style='border-radius:10px;position: absolute;max-height:inherit'/>
<video id='main_video' src='//:0' style='border-radius:10px;max-height:inherit' loop></video>
</div>

<div class='flexcenter' style='margin:10px;'>
<div class='threads-width'>

<div class='flexwrap'>
<div id='container-{{$mainmsg->reply_id}}' class='scrollTo' style='min-width:100%;'>            
<div id='{{$mainmsg->reply_id}}' class='postcontainer'>
        <div class='threadHead'> 
                @if(isset(auth()->user()->username))
                <img class='icons' title='Archive' onclick="window.location='{{route('moderation.archive',$mainmsg->reply_id)}}';" src="{{asset('files/system/archive.png')}}"> <img class='icons' title='Delete' onclick="window.location='{{route('moderation.thread.delete', $mainmsg->reply_id)}}';"src="{{asset('files/system/delete.png')}}"> <img class='icons' title='Delete & Ban IP' onclick="window.location='{{route('moderation.ban.redirect', $mainmsg->ip_address)}}';" src="{{asset('files/system/ban.png')}}">
                @endif
                <span class='title'></span> <span class='name'>{{$mainmsg->name}}</span> <span class='title'>{{$mainmsg->Thread->title}}</span> <span class='date'>{{$mainmsg->created_at->format('F dS Y g:mA')}}</span> <span class='replies'>No.</span><span class='replies reply_id'>{{$mainmsg->thread_id}}</span> 
                @if($mainmsg->Thread->pinned == true)<img class='icons' title='Pinned' src="{{asset('files/system/pushpin.png')}}">@endif
                @if($mainmsg->Thread->archived == true)<img class='icons' title='Archived' src="{{asset('files/system/archive.png')}}">@endif
                @if($mainmsg->reply_from) 
                @foreach(json_decode($mainmsg->reply_from) as $mreplies)
                <span class='replies other_reply scrollFrom'>>>{{$mreplies}}</span>
                @endforeach
                @endif
        </div>
        <br>
        <div style='display:flex;'>
                <a class='file' media='{{$mainmsg->file_type}}' href='{{asset($mainmsg->file)}}' target='blank_'><img class='replyimg' src="{{asset($mainmsg->thumbnail)}}"></a>
                <p>{{$mainmsg->message}}</p>
        </div>
        </div>
</div>      
</div>

<br>

@foreach($replies as $reply)
<div class='flexwrap'>
<div id='container-{{$reply->reply_id}}' class='scrollTo'>
        <div id='{{$reply->reply_id}}' class='postcontainer reply-width'>
        <div class='threadHead'>
                @if(isset(auth()->user()->username))
                <img class='icons' title='Delete' onclick="window.location='{{route('moderation.reply.delete', $reply->reply_id)}}';"src="{{asset('files/system/delete.png')}}"> <img class='icons' title='Delete & Ban IP' onclick="window.location='{{route('moderation.ban.redirect', $reply->ip_address)}}';" src="{{asset('files/system/ban.png')}}">
                @endif
                <span class='name'>{{$reply->name}}</span> <span class='date'>{{$reply->created_at->format('F dS Y g:mA')}}</span> <span class='replies'>No.</span><span class='replies reply_id'>{{$reply->reply_id}}</span>
                @if($reply->reply_from) 
                @foreach(json_decode($reply->reply_from) as $replies)
                <span class='replies other_reply scrollFrom'>>>{{$replies}}</span>
                @endforeach
                @endif
        </div> 
        <br>
        <div style='display:flex;'>
                @if($reply->file)<a class='file' media='{{$reply->file_type}}' href='{{asset($reply->file)}}' target='blank_'><img class='replyimg' src="{{asset($reply->thumbnail)}}" style="max-height:200px;max-width:200px;"></a>@endif 
                <div>
                @if($reply->reply_to)
                @foreach(json_decode($reply->reply_to) as $replied)
                <span class='replies other_reply scrollFrom'>>>{{$replied}}</span><br>
                @endforeach
                <br>
                @endif 
                <p>{{$reply->message}}</p>
                </div>
        </div>
        </div>
</div>
</div>

<br>
@endforeach

</div>
</div>

<x-footer :boards="$boards"></x-footer>
@endsection
