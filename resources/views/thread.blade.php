@extends('header',['page'=>'thread','thread'=>$mainmsg->thread_id,'tag'=>$tag,'name'=>$name])
<title>{{$mainmsg->message}}</title>
@section('content')

<br>

<div id='mainarea'>
<div id='mainarea2'>

<div id='msg'>            
<div class='indiv' style='width:100%;'>
        <div id='top'> 
                <strong class='title'></strong> <strong class='name'>{{$mainmsg->name}}</strong> <span class='date'>{{$mainmsg->created_at->format('F dS Y')}}</span> <span class='replies'>No.{{$mainmsg->thread_id}}</span> 
                @if($mainmsg->reply_from) 
                @php $wow = explode('|',$mainmsg->reply_from); $x=0; while($x<count($wow)) { echo " <span class='replies'>".$wow[$x].'</span>'; $x++;} @endphp 
                @endif
        </div>
        <br>
        <div style='display:flex;'>
                @if($mainmsg->image)<img  class='replyimg' src="{{asset($mainmsg->image)}}">@endif 
                <p>{{$mainmsg->message}}</p>
        </div>
</div>      
</div>

<br>

@foreach($replies as $reply)
<div id='msg'>
<div class='indiv'>
        <div id='top'>
                <strong class='name'>{{$reply->name}}</strong> <span class='date'>{{$reply->created_at->format('F dS Y')}}</span> <span class='replies'>No.{{$reply->reply_id}}</span>
                @if($reply->reply_from) 
                @php $wow = explode('|',$reply->reply_from); $x=0; while($x<count($wow)) { echo " <span class='replies'>".$wow[$x].'</span>'; $x++;} @endphp
                @endif
        </div> 
        <br>
        <div style='display:flex;'>
                @if($reply->image)<img class='replyimg2' src="{{asset($reply->image)}}">@endif 
                <div>
                @if($reply->reply_to)
                @php $wow2 = explode('|',$reply->reply_to); $i=0; while($i<count($wow2)) { echo " <span class='replies'>".$wow2[$i].'</span>'; $i++;} @endphp
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
