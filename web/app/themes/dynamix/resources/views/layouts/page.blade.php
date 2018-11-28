<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    <div class="page-content {{ (get_theme_mod( 'header_fixed' ) == true) ? 'header-fixed' : '' }}">
      @php do_action('get_header') @endphp
      @include('partials.header')
      @yield('content')
      @php do_action('get_footer') @endphp
      @include('partials.footer')
      @php wp_footer() @endphp 
    </div>
  </body>
</html>
