<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<title>{{__('404')}}</title>

<link rel="stylesheet" href="{{ asset('css/500.css') }}">
</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>{{__('404')}}</h1>
				<h2>{{__('Page not found')}}</h2>
			</div>
			<a href="{{route('home')}}">{{__('Homepage')}}</a>
		</div>
	</div>

</body>

</html>
