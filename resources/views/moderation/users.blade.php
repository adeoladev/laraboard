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
        
        <form method='post' action="{{route('moderation.users.password')}}">
        @csrf
        <input type='text' name='password' placeholder='New Password' required>
        <button>Change Your Password</button>
        </form>

        <form method='post' action="{{route('moderation.users.invite')}}">
        @csrf
        <input type='text' name='email' placeholder='Email' required>
        <select name='rank' required>
        <option selected disabled>Rank</option>
        <option value='admin'>Admin</option>
        <option value='moderator'>Moderator</option>
        </select>
        <button>Invite New User</button>
        </form>

        <br>
        
        <table>
            <tr>
              <th>Username</th>
              <th>Email</th>
              <th>Rank</th>
              <th>IP Address</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
            @foreach($users as $user)
            <tr>
              <td>{{$user->username}}</td>
              <td>{{$user->email}}</td>
              <td>{{$user->rank}}</td>
              <td>{{$user->ip_address}}</td>
              <td>{{$user->created_at->format('d M Y g:i a')}}</td>
            <td>
              <img class='icons' onclick="window.location='{{route('moderation.users.delete',$user->id)}}'" title='Delete' src="{{asset('files/system/delete.png')}}">
              <img class='icons' onclick="window.location='{{route('moderation.ban.redirect',$user->ip_address)}}'" title='Ban' src="{{asset('files/system/ban.png')}}">
            </td>
            </tr>
            @endforeach
        </table>

        {{$users->withQueryString()->links()}}
</div>
</div>

@endsection