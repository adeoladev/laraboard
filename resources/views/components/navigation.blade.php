<div class='tabs'>
<a href="{{route('moderation.threads')}}"><p @if(request()->routeIs('moderation.threads')) class='title' @else class='date' @endif>Threads</p></a>
@if(auth()->user()->rank == 'admin')
<a href="{{route('moderation.boards')}}"><p @if(request()->routeIs('moderation.boards')) class='title' @else class='date' @endif>Boards</p></a>
<a href="{{route('moderation.categories')}}"><p @if(request()->routeIs('moderation.categories')) class='title' @else class='date' @endif>Categories</p></a>
<a href="{{route('moderation.users')}}"><p @if(request()->routeIs('moderation.users')) class='title' @else class='date' @endif>Users</p></a>
@endif
<a href="{{route('moderation.files')}}"><p @if(request()->routeIs('moderation.files')) class='title' @else class='date' @endif>Files</p></a>
<a href="{{route('moderation.archives')}}"><p @if(request()->routeIs('moderation.archives')) class='title' @else class='date' @endif>Archives</p></a>
<a href="{{route('moderation.pins')}}"><p @if(request()->routeIs('moderation.pins')) class='title' @else class='date' @endif>Pins</p></a>
</div>