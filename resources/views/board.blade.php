@extends('header',['page'=>'board','tag'=>$thisBoard->tag,'name'=>$thisBoard->name])
<title>/{{$thisBoard->tag}}/ - {{$thisBoard->name}}</title>
@section('content')

<br>

<div class='flexcenter'>
<div style='width: 80%;'>

<div class='flexwrap' style='justify-content: center;'>     
@foreach($threads as $thread)
    <ol>
        <li>
        <div class='postcontainer' style='width:160px;max-height: 292px;'>
            <div>
            <a href="{{route('thread',['board' =>$thisBoard->tag,'id'=>$thread->thread_id])}}"><div class='homeimg' style="background-image:url('{{asset($thread->thumbnail)}}')"></div></a>
                <br>
                <strong class='title'>{{$thread->title}}</strong>
                <p>{{$thread->message}}</p>
            </div>
        </div>
        <p style="margin-top: 10px;font-size: 13px;">{{$thread->replies}} Replies {{$thread->images}} Files</p>
        </li>
        <br>
    </ol>
@endforeach
</div>

</div>
</div>

@endsection
