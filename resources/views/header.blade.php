<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css" >
    <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
    @vite('resources/js/app.js')
</head>

<div id='app'>

<div id='statusContainer'>
    @include('inc.status')
</div>

<header-component 
board="{{$name ?? null}}" 
tag="{{$tag ?? null}}" 
current_page={{ $page ?? 'x' }} 
thread_path={{ route('newreply', $thread.','.$tag) }} 
board_path={{ route('newthread', $tag ?? 'x') }} 
csrf="{{csrf_token()}}" 
app_name="{{config('app.name')}}"
main_board_path="{{route('board',$tag ?? 'x')}}"
archived="{{$archived ?? null}}"
captcha_url="{{ route('captcha') }}">
</header-component>
</div>

@yield('content')

</html>