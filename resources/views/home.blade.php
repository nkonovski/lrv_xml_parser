@extends('app')

@section('title')
{{$title}}
@endsection

@section('content')

@if ( !$books->count() )
There is no books till now.
@else
<div class="">
	@foreach( $books as $book )
	<div class="list-group">
		<div class="list-group-item">
			<h3>{{ $book->title }}</h3>
			<p>Author: {{ $book->author}}</p>
			<p>Last update at: {{ $book->updated_at->format('M d,Y \a\t h:i a') }}</p>
			<p>Created at: {{ $book->created_at->format('M d,Y \a\t h:i a') }}</p>

		</div>
	</div>
	@endforeach
	{!! $books->render() !!}
</div>
@endif

@endsection
