<head>
  @php
    $analytics = $GLOBALS['options']['analytics'];
    $gtm = $GLOBALS['options']['gtm'];
  @endphp

  @if ($gtm)
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtm }}');</script>
    <!-- End Google Tag Manager -->
  @endif

  @if ($analytics)
    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', '{{$analytics}}', 'auto');
      ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->
  @endif

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" X-Content-Type-Options="nosniff">
  <link rel="icon" type="image/x-icon" href="@asset('images/favicons/favicon.ico')">
  <link rel="icon" type="image/png" sizes="16x16" href="@asset('images/favicons/favicon-16x16.png')">
  <link rel="icon" type="image/png" sizes="32x32" href="@asset('images/favicons/favicon-32x32.png')">
  <link rel="icon" type="image/png" sizes="48x48" href="@asset('images/favicons/favicon-48x48.png')">
  <link rel="manifest" href="@asset('images/favicons/manifest.webmanifest')">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="theme-color" content="#fff">
  <link rel="apple-touch-icon" sizes="57x57" href="@asset('images/favicons/apple-touch-icon-57x57.png')">
  <link rel="apple-touch-icon" sizes="60x60" href="@asset('images/favicons/apple-touch-icon-60x60.png')">
  <link rel="apple-touch-icon" sizes="72x72" href="@asset('images/favicons/apple-touch-icon-72x72.png')">
  <link rel="apple-touch-icon" sizes="76x76" href="@asset('images/favicons/apple-touch-icon-76x76.png')">
  <link rel="apple-touch-icon" sizes="114x114" href="@asset('images/favicons/apple-touch-icon-114x114.png')">
  <link rel="apple-touch-icon" sizes="120x120" href="@asset('images/favicons/apple-touch-icon-120x120.png')">
  <link rel="apple-touch-icon" sizes="144x144" href="@asset('images/favicons/apple-touch-icon-144x144.png')">
  <link rel="apple-touch-icon" sizes="152x152" href="@asset('images/favicons/apple-touch-icon-152x152.png')">
  <link rel="apple-touch-icon" sizes="167x167" href="@asset('images/favicons/apple-touch-icon-167x167.png')">
  <link rel="apple-touch-icon" sizes="180x180" href="@asset('images/favicons/apple-touch-icon-180x180.png')">
  <link rel="apple-touch-icon" sizes="1024x1024" href="@asset('images/favicons/apple-touch-icon-1024x1024.png')">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title">
  <meta name="msapplication-TileColor" content="#fff">
  <meta name="msapplication-TileImage" content="@asset('images/favicons/mstile-144x144.png')">
  <meta name="msapplication-config" content="@asset('images/favicons/browserconfig.xml')">
  <script>window.App = {!! json_encode($GLOBALS['App']) !!}</script>
  <script>
    if ('serviceWorker' in navigator) navigator.serviceWorker.register('{{ get_home_url() }}/wp-content/themes/studioseven/service-worker.js');
  </script>

  @php wp_head() @endphp

  @if ($gtm)
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtm }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
  @endif
</head>
