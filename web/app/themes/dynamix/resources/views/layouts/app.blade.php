<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    <div class="page-content {{ (get_theme_mod( 'header_fixed' ) == true) ? 'header-fixed' : '' }}">
      @php do_action('get_header') @endphp
      @include('partials.header')
      <div></div>
      <section>
        <div class="wrap container" role="document">
          <div class="content container-inner">
            <main class="main">
              @yield('content')
            </main>
            @if (App\display_sidebar())
              <aside class="sidebar">
                @include('partials.sidebar')
              </aside>
            @endif
          </div>
        </div>
      </section>
      @php do_action('get_footer') @endphp
      @include('partials.footer')
      @php wp_footer() @endphp 
    </div>
  </body>
</html>
