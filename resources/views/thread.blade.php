@extends('header',['page'=>'thread','thread'=>$mainmsg->thread_id,'tag'=>$tag,'name'=>$name])
<title>/{{$tag}}/ - {{$mainmsg->message}}</title>
@section('content')

<br>

<div class='flexcenter'>
<div style='width: 80%;'>

<div class='flexwrap'>            
<div class='postcontainer' style='width:100%;'>
        <div class='threadHead'> 
                <span class='title'></span> <span class='name'>{{$mainmsg->name}}</span> <span class='date'>{{$mainmsg->created_at->format('F dS Y g:mA')}}</span> <span class='replies'>No.{{$mainmsg->thread_id}}</span> 
                @if($mainmsg->reply_from) 
                @foreach(json_decode($mainmsg->reply_from) as $mreplies)
                <span class='replies'>>>{{$mreplies}}</span><br>
                @endforeach
                @endif
        </div>
        <br>
        <div style='display:flex;'>
                <img  class='replyimg' src="{{asset($mainmsg->thumbnail)}}">
                <p>{{$mainmsg->message}}</p>
        </div>
</div>      
</div>

<br>

@foreach($replies as $reply)
<div class='flexwrap'>
<div class='postcontainer'>
        <div class='threadHead'>
                <span class='name'>{{$reply->name}}</span> <span class='date'>{{$reply->created_at->format('F dS Y g:mA')}}</span> <span class='replies'>No.{{$reply->reply_id}}</span>
                @if($reply->reply_from) 
                @foreach(json_decode($reply->reply_from) as $replies)
                <span class='replies'>>>{{$replies}}</span><br>
                @endforeach
                @endif
        </div> 
        <br>
        <div style='display:flex;'>
                @if($reply->image)<img class='replyimg' src="{{asset($reply->thumbnail)}}" style="max-height:200px;max-width:200px;">@endif 
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
