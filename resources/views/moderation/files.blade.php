@extends('header',['page'=>'moderation','thread'=>null,'tag'=>null])
<title>{{ config('app.name') }} - Moderation</title>
@section('content')

<br>

<div class='flexcenter'><p class='name'>Moderation</p></div><br>

<div class='flexcenter'>
<div class='width-80'>

        <x-navigation></x-navigation>

        <br>

        <form method='get'>
        @csrf
        <select name="boards">
        <option selected value=''>All Boards</option>
        @foreach($boards as $board)
        <option @if(request()->boards == $board->tag) selected @endif value='{{$board->tag}}'>{{$board->name}}</option>
        @endforeach
        </select>
        <button>search</button>
        </form>

        <div class="grid-container">
        @foreach($files as $file)
        <div>
          <img onclick="window.open('{{asset($file->file)}}')" src="{{asset($file->thumbnail)}}"><br>
          <img onclick="window.location='{{route('moderation.files.delete',['reply'=>$file->reply_id,'thread'=>$file->thread_id] )}}';" class='icons' title='Delete file only' src="{{asset('files/system/delete-image.png')}}">
          <img onclick="window.location='{{route('moderation.files.delete.post',['reply'=>$file->reply_id,'thread'=>$file->thread_id] )}}'" class='icons' title='Delete file and post' src="{{asset('files/system/delete.png')}}">
          <img onclick="window.location='{{route('moderation.files.delete.ban',['reply'=>$file->reply_id,'thread'=>$file->thread_id] )}}'" class='icons' title='Delete and Ban IP' src="{{asset('files/system/ban.png')}}">
        </div>
        @endforeach
        </div>

        <br>

          {{$files->links()}}
</div>
</div>

@endsection

<style>
    .grid-container {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    }
    .grid-container img{
        max-width:100px;
        max-height:200px;
    }
    .grid-item {
      height:50px;
      background-size:cover;
      background-position:center;
      background-repeat:no-repeat;
      border: 1px solid rgba(0, 0, 0, 0.8);
      padding: 20px;
      font-size: 30px;
      text-align: center;
    }
</style>