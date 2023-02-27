@extends('header',['page'=>'index','thread'=>null,'tag'=>null])
<title>{{ config('app.name') }}</title>
@section('content')

<br>

<div class='flexcenter'><p class='name'>Boards</p></div><br>
<div class='flexcenter'>
<div class='postcontainer'>  
        <div class='flexwrap'>    
        @foreach($categories as $category)
        <div style='padding:10px'>
        <strong class='name'>{{$category->name}}</strong>@if($category->content == 'nsfw') <strong style='color:red;font-size: smaller;'>(nsfw)</strong> @endif<br>
        @foreach(\App\Models\Board::where('category',$category->id)->get() as $board)
        <a href="{{route('board',['category'=>$category->id,'board'=>$board->tag])}}">{{$board->name}}</a><br>
        @endforeach
        </div>
        @endforeach
</div>
</div>
</div>

<br><br>

<div class='flexcenter'>
<p class='name'>Popular Threads</p></div><br>
<div class='flexcenter'>
<div class='postcontainer threads'>
<div class='flexbox-threads'>  
        @foreach($popularThreads as $thread)
        <div class="popularThread">
        <div class='threadHead'>
        <strong class='title'>{{$thread->board_name[0]->name}}</strong>
        </div>
        <br>
        <div>
        <a href="{{route('thread',['board'=>$thread->board,'id'=>$thread->thread_id])}}"><div class='threadimg' style="height:150px;background-image:url('{{asset($thread->thumbnail)}}')"></div></a>
        <br>
        <p>{{$thread->message}}</p>
        </div>
        </div>
        <br>
        @endforeach
</div>
</div>
</div>


@endsection

