@extends('header')
<title>{{ config('app.name') }} - Moderation</title>
@section('content')

<br>

<div class='flexcenter'><p class='name'>Moderation</p></div><br>

    <div class='flexcenter'>
        <div style='padding:10px'>
        <form method='post' action="{{route('login')}}">
        @csrf
        <input type='text' name='username' placeholder='username'>
        <input type='password' name='password' placeholder='password'>
        <button>Login</button>
        </form>
        @include('inc.status')
        </div>
    </div>

