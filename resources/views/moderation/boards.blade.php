@extends('header')
<title>{{ config('app.name') }} - Moderation</title>
@section('content')

<br>

<div class='flexcenter'><p class='name'>Moderation</p></div><br>

<div class='flexcenter'>
<div class='width-80'>

        <div class='tabs'>
        <a href='{{route('moderation.threads')}}'><p class='date'>Threads</p></a>
        <p class='title'>Boards</p>
        <a href='{{route('moderation.categories')}}'><p class='date'>Categories</p></a>
        <a href="{{route('moderation.users')}}"><p class='date'>Users</p></a>
        <a href="{{route('moderation.files')}}"><p class='date'>Files</p></a>
        <a href="{{route('moderation.archives')}}"><p class='date'>Archives</p></a>
        <a href="{{route('moderation.pins')}}"><p class='date'>Pins</p></a>
        </div>

        <br>

        <form method='get'>
        @csrf
        <input type='text' name='search' value='{{request()->search}}' placeholder='Name'>
        <button>search</button>
        </form>

        <form method='post' action="{{route('moderation.board.new')}}">
        @csrf
        <select name="category" required>
        <option selected disabled>Category</option>
        @foreach($categories as $category)
        <option value='{{$category->id}}'>{{$category->name}}</option>
        @endforeach
        </select>
        <input type='text' name='name' placeholder='Name' required>
        <input type='text' name='tag' placeholder='Tag' required>
        <button>Add New Board</button>
        </form>

        <form method='post' action="{{route('moderation.board.rename')}}">
        @csrf
        <select name="boards">
        <option selected disabled>Board</option>
        @foreach($boards as $board)
        <option value='{{$board->id}}'>{{$board->name}}</option>
        @endforeach
        </select>
        <input type='text' placeholder='New Name' name='name' required>
        <input type='text' name='tag' placeholder='New Tag (optional)'>
        <button>Rename Board</button>
        </form>

        <br>
        
        <table>
            <tr>
              <th>Name</th>
              <th>Tag</th>
              <th>Category</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
            @foreach($boards as $board)
            <tr>
              <td>{{$board->name}}</td>
              <td>{{$board->tag}}</td>
              <td>{{$board->Category->name}}</td>
              <td>{{$board->created_at->format('d M Y g:i a')}}</td>
            <td><img class='icons' onclick="window.location='{{route('moderation.board.delete',$board->id)}}'" title='Delete' src="{{asset('files/system/delete.png')}}"></td>
            </tr>
            @endforeach
        </table>

          {{$boards->links()}}
</div>
</div>

@endsection