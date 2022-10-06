@extends('master')


@section('title', 'Larachannel')

@section('content')

<br>
<div id='mainarea'>
<div id='mainarea2'>


<div id='msg'>            
        @foreach($onemsg as $msg)
<div class='indiv2' style='width:100%;'><div id='top'><p><strong>{{$msg->name}}</strong> {{$msg->date}} <span>No.{{$msg->thread_id}}</span> @php $wow = explode('|',$msg->reply_from); $x=0; while($x<count($wow)) { echo ' <span>'.$wow[$x].'</span>'; $x++;} @endphp </p></div><br><div id='stuff'>@if ($msg->image)<img  class='replyimg' src="../{{$msg->image}}"> @else {{""}} @endif <p>{{$msg->message}}</p></div></div><br>
        @endforeach
<form id='replyform' action='{{route('newreply',$msg->thread_id)}}' method='post' enctype="multipart/form-data">
                @csrf
                <input type='text' name='name' placeholder='name (optional)'><br>
                <textarea type='text' name='message' rows="7" cols="60" style='width:300px;max-height:220px;max-width:300px;min-width:300px;' required></textarea><br>
                <input type='file' name='upload'><br><br>
                <button type='submit'>SUBMIT</button>
        </form>
</div><br>


@foreach($onereply as $reply)
<div id='msg'>
<div class='indiv3'><div id='top'><p><strong>{{$reply->name}}</strong> {{$reply->date}}  <span>No.{{$reply->reply_id}}</span> @php $wow = explode('|',$reply->reply_from); $x=0; while($x<count($wow)) { echo ' <span>'.$wow[$x].'</span>'; $x++;} @endphp </p></div><br><div id='stuff'><div>@if ($reply->image)<img class='replyimg2' src="../{{$reply->image}}"> @else {{""}} @endif </div><div><div {{$reply->reply_to ?? "display:none;"}}>@php $wow2 = explode('|',$reply->reply_to); $i=0; while($i<count($wow2)) { echo ' <span>'.$wow2[$i].'</span>'."<br>"; $i++;} @endphp</div><p>{{$reply->message}}</p></div></div></div>
</div><br>
@endforeach


<br>

</div>
</div>
@endsection
