<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js oldie lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js oldie lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js oldie lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js oldie ie9"> <![endif]-->
<!--[if gt IE 9]>
<!--> 
<html class="no-js loading">
<!--<![endif]-->

	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta charset="utf-8">
		<title>{{$meta['meta_title'] or ''}}</title>
		<meta name="title" content="{{$meta['meta_title'] or ''}}">
		<meta name="description" content="{{$meta['meta_description'] or ''}}">
		<meta name="keywords" content="{{$meta['meta_keywords'] or ''}}">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- <meta name="csrf_token" content="{{ csrf_token() }}"> -->

		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />

		<!-- <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"> -->
		<!-- <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32"> -->
		<!-- <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16"> -->
		<!-- <link rel="manifest" href="/manifest.json"> -->
		<!-- <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5"> -->
		<!-- <meta name="theme-color" content="#ffffff"> -->

		<meta name="fragment" content="!">

        <!-- Open graph tags -->
        <meta property="og:title" content="{{$meta['og_title'] or ''}}"/>
        <meta property="og:description" content="{{$meta['og_description'] or ''}}">
        <meta property="og:type" content="{{$meta['og_type'] or ''}}" />
        <meta property="og:site_name" content="{{$meta['og_site_name'] or ''}}"/>
        <meta property="og:url" content="{{$meta['og_url'] or ''}}" />
        <meta property="og:image" content="{{$meta['og_image'] or ''}}">
        <meta property="og:locale" content="{{$meta['og_locale'] or ''}}" />

		<script>
	    	var absurl = '{{ url() }}',
	            locale = '{{ App::getLocale() }}',
	            ie8 = false,
                ie9 = false,
                ie = false;
		</script>

		<!--[if IE]>
			<script> var ie = true; </script>
		<![endif]-->
		<!--[if lte IE 9]>
			<script> var ie9 = true; </script>
		<![endif]-->
		<!--[if lt IE 9]>
			<script> var ie8 = true; </script>
		<![endif]-->

        @yield('header')
    </head>

    <body>
        @yield('content')


        @yield('footer')
    </body>

</html>