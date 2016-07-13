<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>XML Parser Demo</title>

		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">

				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a href="{{ url('/') }}">Home</a>
							<a href="{{ url('/scan') }}">Scan</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>

		<form method="post" action="/">
			<input type="text" name="search" placeholder="enter author or title..."/>
			<input type="submit" value="Search"/>
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		</form>
		
		<div class="container">
			@if (Session::has('message'))
			<div class="flash alert-info">
				<p class="panel-body">
					{{ Session::get('message') }}
				</p>
			</div>
			@endif
			@if ($errors->any())
			<div class='flash alert-danger'>
				<ul class="panel-body">
					@foreach ( $errors->all() as $error )
					<li>
						{{ $error }}
					</li>
					@endforeach
				</ul>
			</div>
			@endif
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2>@yield('title')</h2>
							@yield('title-meta')
						</div>
						<div class="panel-body">
							@yield('content')
						</div>
					</div>
				</div>
			</div>
		</div>

	</body>
</html>