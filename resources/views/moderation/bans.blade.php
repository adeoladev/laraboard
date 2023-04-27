@extends('header',['page'=>'moderation','thread'=>null,'tag'=>null])
<title>{{ config('app.name') }} - Moderation</title>
@section('content')

<br>

<div class='flexcenter'><p class='name'>Moderation</p></div><br>

<div class='flexcenter'>
<div class='width-80'>

        <x-navigation></x-navigation>
        
        <br>

        <div style='display:flex'>
            <form method='post' action="{{route('moderation.ban.process')}}">
                @csrf
                <input type='text' name='ip_address' placeholder='IP Address' @if(session()->has('ip')) style='border:2px solid #E8392C' value='{{session()->get('ip')}}' @endif required>
                <select name='expiration'>
                <option selected disabled>Expiration Date</option>
                <option value="day">1 day</option>
                <option value="week">1 week</option>
                <option value="month">1 month</option>
                <option value="forever">Forever</option>
                </select>
                <button>Ban</button>
                </form>
        </div>

        <br>
        
        <table>
            <tr>
              <th>IP Address</th>
              <th>Banned</th>
              <th>Expiration Date</th>
              <th>Action</th>
            </tr>
            @foreach($bans as $ban)
            <tr>
              <td>{{$ban->ip_address}}</td>
              <td>{{$ban->created_at}}</td>
              <td>{{(isset($ban->expiration_date)) ? $ban->expiration_date->diffForHumans() : 'never'}}</td>
            <td>
              <img onclick="window.location='{{route('moderation.unban',$ban->ip_address)}}';" class='icons' title='Unban' src="{{asset('files/system/delete.png')}}">
            </td>
            </tr>
            @endforeach
        </table>

          {{$bans->links()}}
</div>
</div>

@endsection
