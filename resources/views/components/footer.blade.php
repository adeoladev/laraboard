<div id='footer'>

<div id='footerBoards'>
@foreach($boards as $board)
<a href="{{route('board',$board->tag)}}"><p class='replies'>/{{$board->tag}}/</p></a>
@endforeach
</div>

<p style='font-size:10px;color:#566775'>All trademarks and copyrights on this page are owned by their respective parties. Images uploaded are the responsibility of the Poster. Comments are owned by the Poster.</p>

</div>