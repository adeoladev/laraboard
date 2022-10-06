<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
</head>
<link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css" >
<script src="{{ asset('../resources/js/script.js')}}"></script>
<div id='header'><a href='{{route("home")}}'><p>LARABOARD</p></a>

<button id='postButton'>NEW POST</button>
  
</div>


<body>

 
@yield('content')


</body>

</html>