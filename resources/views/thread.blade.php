@extends('header',['page'=>'thread','thread'=>$mainmsg->thread_id,'tag'=>$tag,'name'=>$name])
<title>/{{$tag}}/ - {{$mainmsg->message}}</title>
@section('content')

<br>

<div class='flexcenter'>
<div class='threads-width'>

<div class='flexwrap'>            
<div class='postcontainer' style='width:100%'>
        <div class='threadHead'> 
                @if(isset(auth()->user()->username))
                <img class='icons' title='Archive' src="{{asset('files/system/archive.png')}}"> <img class='icons' title='Mark as spoiler' onclick="window.location='{{route('moderation.files.spoiler',['reply'=>$mainmsg->reply_id,'thread'=>$mainmsg->reply_id] )}}';" src="{{asset('files/system/spoiler.png')}}"> <img class='icons' title='Delete' onclick="window.location='{{route('moderation.thread.delete', $mainmsg->reply_id)}}';"src="{{asset('files/system/delete.png')}}"> <img class='icons' title='Delete & Ban IP' onclick="window.location='{{route('moderation.thread.ban', $mainmsg->reply_id)}}';" src="{{asset('files/system/ban.png')}}">
                @endif
        <span class='title'></span> <span class='name'>{{$mainmsg->name}}</span> <span class='title'>{{$mainmsg->Thread->title}}</span> <span class='date'>{{$mainmsg->created_at->format('F dS Y g:mA')}}</span> <span class='replies'>No.{{$mainmsg->thread_id}}</span> 
                @if($mainmsg->Thread->pinned == true)<img class='icons' title='Pinned' src="{{asset('files/system/pushpin.png')}}">@endif
                @if($mainmsg->Thread->archived == true)<img class='icons' title='Archived' src="{{asset('files/system/archive.png')}}">@endif
                @if($mainmsg->reply_from) 
                @foreach(json_decode($mainmsg->reply_from) as $mreplies)
                <span class='replies'>>>{{$mreplies}}</span><br>
                @endforeach
                @endif
        </div>
        <br>
        <div style='display:flex;'>
                <img class='replyimg' src="{{asset($mainmsg->thumbnail)}}">
                <p>{{$mainmsg->message}}</p>
        </div>
</div>      
</div>

<br>

@foreach($replies as $reply)
<div class='flexwrap'>
<div class='postcontainer reply-width'>
        <div class='threadHead'>
                @if(isset(auth()->user()->username))
                <img class='icons' title='Mark as spoiler' onclick="window.location='{{route('moderation.files.spoiler',['reply'=>$reply->reply_id,'thread'=>$reply->reply_id] )}}';" src="{{asset('files/system/spoiler.png')}}"> <img class='icons' title='Delete' onclick="window.location='{{route('moderation.reply.delete', $reply->reply_id)}}';"src="{{asset('files/system/delete.png')}}"> <img class='icons' title='Delete & Ban IP' onclick="window.location='{{route('moderation.reply.ban', $reply->reply_id)}}';" src="{{asset('files/system/ban.png')}}">
                @endif
                <span class='name'>{{$reply->name}}</span> <span class='date'>{{$reply->created_at->format('F dS Y g:mA')}}</span> <span class='replies'>No.{{$reply->reply_id}}</span>
                @if($reply->reply_from) 
                @foreach(json_decode($reply->reply_from) as $replies)
                <span class='replies'>>>{{$replies}}</span><br>
                @endforeach
                @endif
        </div> 
        <br>
        <div style='display:flex;'>
                @if($reply->file)<img class='replyimg' src="{{asset($reply->thumbnail)}}" style="max-height:200px;max-width:200px;">@endif 
                <div>
                @if($reply->reply_to)
                @foreach(json_decode($reply->reply_to) as $replied)
                <span class='replies'>>>{{$replied}}</span><br>
                @endforeach
                <br>
                @endif 
                <p>{{$reply->message}}</p>
                </div>
        </div>
</div>
</div>

<br>
@endforeach

</div>
</div>

@endsection
