@extends('header',['page'=>'index'])
<title>{{ config('app.name') }}</title>
@section('content')

<br>

<div id='mainarea'>
<div class='indiv' style='width: 80%;display: flex;justify-content: center;'>
      
        @foreach($categories as $category)
        <div style='padding:10px'>
        <strong class='name'>{{$category->name}}</strong><br>
        @foreach(\App\Models\Board::where('category',$category->id)->get() as $board)
        <a href={{route('board',['category'=>$category->id,'board'=>$board->tag])}}>{{$board->name}}</a><br>
        @endforeach
        </div>
        @endforeach

<div id='app'>
        <example-component></example-component>
</div>

</div>
</div>

@endsection