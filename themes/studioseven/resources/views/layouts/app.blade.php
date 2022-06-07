<!doctype html>
<html @php language_attributes() @endphp>
  @include('partials.head')

  <body @php body_class(App::formSubmit()) @endphp>
    @if (get_field('google_tag_manager', 'options'))
      <span id="gtag-el" style="display:none" data-gtag="{{ get_field('google_tag_manager', 'options') }}"></span>
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ get_field('google_tag_manager', 'options') }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <div class="app js-scroll">
      @php do_action('get_header') @endphp

      @include('partials.header')

      @if ($GLOBALS['options']['debug'])
        @include('partials.grid')
      @endif

      <div class="content" data-router-wrapper role="document">
        @yield('content')
      </div>

      <div class="panel"></div>

      @php do_action('get_footer') @endphp
      @include('partials.footer')

      @php wp_footer() @endphp
    </div>
  </body>
</html>
