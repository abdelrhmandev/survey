<!DOCTYPE html>
<html direction="ltr" dir="ltr" style="direction: ltr" lang="{{ app()->getLocale() }}">
	<head>
		<title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="GSK" />
		<meta name="keywords" content="GSK" />
		<meta name="viewport" content="GSK" />
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="GSK" />
		<meta property="og:url" content="https://game.invent.solutions" />
		<meta property="og:site_name" content="GSK" />
		<link rel="canonical" href="https://game.invent.solutions" />
		<link rel="shortcut icon" href="{{ asset('assets/backend/media/logos/favicon.png')}}" />
		@yield('style')
		<script>
			window.Laravel = {!! json_encode([
				'csrfToken' => csrf_token(),
			]) !!};
		</script>		

		<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">
		<link href="{{ asset('assets/backend/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/backend/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/backend/css/custom.css') }}" rel="stylesheet" type="text/css" />

	</head>
	<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		<div class="d-flex flex-column flex-root">						
			@yield('content')
		</div>
		<script src="{{ asset('assets/backend/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{ asset('assets/backend/js/scripts.bundle.js')}}"></script> 
		@yield('scripts')
	</body>
</html>