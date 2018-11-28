@extends('layouts.landing')
@section('content')
<!-- BEGIN FullScreen SLIDER -->
  @if($get_sliders)
          <div class="home-slider">
            <!-- Strat Slider -->
            <div id="home-slider" class="swiper-container">
                <nav class="nav-slit">
                    <a class="prev" href="javascript:void(0)">
                        <span class="icon-wrap"><i class="icon fa fa-angle-left"></i></span>
                        <div>
                            <h3 id="title-prev">Title prev</h3>
                            <img id="thumb-prev" src="http://placehold.it/960x640" alt="Previous thumb">
                        </div>
                    </a>
                    <a class="next" href="javascript:void(0)">
                        <span class="icon-wrap"><i class="icon fa fa-angle-right"></i></span>
                        <div>
                            <h3 id="title-next">Title next</h3>
                            <img id="thumb-next" src="http://placehold.it/960x640" alt="Next thumb">
                        </div>
                    </a>
                </nav>
                <div class="swiper-pagination"></div>
                <div class="swiper-wrapper">
                    @foreach($get_sliders->posts as $post)  
                        @php(setup_postdata($GLOBALS['post'] = $post)) 
                      
                        @include('partials.list-item-'.get_post_type())
                        
                        @php(wp_reset_postdata())
                    @endforeach
                </div>
            </div>
            <!-- End Slider -->
        </div>
        @endif
<section class="about-us bg-light">
  <div class="container container-inner">
    <div class="row">
      <div class="col-sm-4">
        <h5 class="light mines-left text-uppercase">About us</h5>
        <h1 class="w700 text-uppercase">
          About Dynamix s.a
        </h1>
      </div>
      <div class="col-sm-8">
        <div class="space30px"></div>
        <p class="text-dark">
        @if (get_theme_mod( 'index_about_section' ) && get_theme_mod( 'index_about_section' ) != '')
          {{ (get_theme_mod( 'index_about_section' )) }}
        @else
          Dynamix s.a is a management company of Java consultants. We are specialized in Java web
          development, the Java consulting
          team at Dynamix s.a is proficient and experienced to create and manage applications aptly
          and
          accordingly adapt with the fast changing technological advancements. They are equipped to
          work
          on existing applications and transform them to meet your future business objectives and
          expectations…
        @endif  
        </p>
        @if (get_theme_mod( 'about_btn_link' ) && get_theme_mod( 'about_btn_link' ) != '')
        <a href="{{ get_page_link(get_theme_mod( 'about_btn_link' )) }}" class="btn btn-primary black btn-sm float-sm-right">Read More <i class="feathericon feathericon-arrow-right right"></i></a>
        @endif
      </div>
    </div>
  </div>
</section>
<section class="expertise">
  <div class="container container-inner">
    <div class="section-title text-center">
      <h3 class="big w100 shadow-white text-uppercase">Expertise</h3>
      <div class="seperator"></div>
    </div>
    <div class="row justify-content-center">
      <div class="col-10">
        <p class="text-center text-dark">
          Because expertise is a prerequisite, the consultant Dynamix SA shares a vision where the
          ability to do and say the right
          thing in any social situation. He is also a creator of performance. Adaptive capacity and
          understanding
          of issues are key to the success of our mission Holding people accountable is a fundamental
          premise
          of good management. Aware of the issues, often strategic, in the missions entrusted to him,
          the
          Dynamix consultant acts loyally and ethically
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="icon-info">
          <div class="icon">
            <i class="icon-lightbulb"></i>
          </div>
          <div class="info text-uppercase">
            <h4>Expertise</h4>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="icon-info">
          <div class="icon">
            <i class="icon-key"></i>
          </div>
          <div class="info text-uppercase">
            <h4>Accountability and trust</h4>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="icon-info">
          <div class="icon">
            <i class="icon-clipboard"></i>
          </div>
          <div class="info text-uppercase">
            <h4>Responsibility</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@if($get_quotes)
<section id="testimonials" class="inner-shadow pattern-faces">
  <!-- <div class="pattern pattern-1"></div> -->
  <div class="pattern back-35-g"></div>
  <div class="container container-inner text-center">
    <div class="space30px"></div>
    <div class="space30px"></div>
    <div class="row">
      <div id="quote-clients" class="swiper-container">
        <div class="swiper-wrapper text-center color-white">
            @foreach($get_quotes->posts as $post)  
                        @php(setup_postdata($GLOBALS['post'] = $post)) 
                      
                        @include('partials.list-item-'.get_post_type())
                        
                        @php(wp_reset_postdata())
            @endforeach
        </div>
        <div class="space30px"></div>
        <div class="space30px"></div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</section>
@endif

@if($get_partners)
<section id="partners">
  <div class="container container-inner">
    <div class="section-title text-center">
      <h3 class="big w100 shadow-white text-uppercase">Our partners</h3>
      <div class="seperator"></div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12">
        <div id="partners-slider" class="partners swiper-container">
          <div class="swiper-wrapper">
            @foreach($get_partners->posts as $post)  
                @php(setup_postdata($GLOBALS['post'] = $post)) 
              
                @include('partials.list-item-'.get_post_type())
                
                @php(wp_reset_postdata())
            @endforeach
          </div>
          <!-- Add Scrollbar -->
          <!-- <div class="swiper-scrollbar"></div> -->
        </div>
      </div>
    </div>
  </div>
</section>
@endif
@include('partials.contact')
@endsection