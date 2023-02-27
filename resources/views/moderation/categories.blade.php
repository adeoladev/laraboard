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
        <input type='text' name='search' value='{{request()->search}}' placeholder='Name'>
        <button>search</button>
        </form>

        <form method='post' action="{{route('moderation.category.new')}}">
        @csrf
        <input type='text' name='name' placeholder='Name' required>
        <select name="content" required>
        <option selected disabled>Content</option>
        <option value='sfw'>SFW (Safe For Work)</option>
        <option value='nsfw'>NSFW (Not Safe For Work)</option>
        </select>
        <button>Add New category</button>
        </form>

        <form method='post' action="{{route('moderation.category.rename')}}">
        @csrf
        <select name="categories">
        <option selected disabled>category</option>
        @foreach($categories as $category)
        <option value='{{$category->id}}'>{{$category->name}}</option>
        @endforeach
        </select>
        <input type='text' placeholder='New Name' name='name' required>
        <select name="content">
        <option selected disabled>New Content (optional)</option>
        <option value='sfw'>SFW (Safe For Work)</option>
        <option value='nsfw'>NSFW (Not Safe For Work)</option>
        </select>
        <button>Rename category</button>
        </form>

        <br>
        
        <table>
            <tr>
              <th>Name</th>
              <th>Content</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
            @foreach($categories as $category)
            <tr>
              <td>{{$category->name}}</td>
              <td>{{$category->content}}</td>
              <td>{{$category->created_at->format('d M Y g:i a')}}</td>
            <td><img class='icons' onclick="window.location='{{route('moderation.category.delete',$category->id)}}'" title='Delete' src="{{asset('files/system/delete.png')}}"></td>
            </tr>
            @endforeach
        </table>

          {{$categories->links()}}
</div>
</div>

@endsection