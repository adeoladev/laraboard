@extends('header',['page'=>'board','tag'=>$tag,'name'=>$name])
<title>/{{$tag}}/ - {{$name}}</title>
@section('content')

<br>

<div id='mainarea'>
<div id='mainarea2'>

<div id='msgs'>     

@foreach($threads as $thread)
    <ol>
        <li>
        <div class='indiv' style='width:200px'>
            <div id='top'>
            <p><strong class='title'>{{$thread->title}}</strong> <strong class='name'>{{$thread->name}}</strong></p><p class='date'>{{$thread->created_at->format('F dS Y')}}</p>
            </div>
            <br>
            <div>
            <a href="{{route('thread',['board' =>$tag,'id'=>$thread->thread_id])}}"><img class='homeimg' src={{asset($thread->image)}}></a>
                <br>
                <p>{{$thread->message}}</p>
            </div>
        </div>
        <p class='stats'>{{$thread->replies}} Replies {{$thread->images}} Images</p>
        </li>
        <br>
    </ol>
@endforeach

</div>
</div>
</div>

@endsection
