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
          ESTHÉTIQUE EN TUNISIE
        </h1>
      </div>
      <div class="col-sm-8">
        <div class="space30px"></div>
        <p class="text-dark">
          @if (get_theme_mod( 'index_about_section' ) && get_theme_mod( 'index_about_section' ) != '')
          {{ (get_theme_mod( 'index_about_section' )) }}
          @else
            La chirurgie esthétique en Tunisie aussi appelée « tourisme médical en Tunisie » n’a cessé d’intéresser les médias depuis plus que de 10 ans maintenant. Cet acharnement et continuité médiatiques ne sont certainement pas le fruit du hasard. Il est évident que les compétences médicales, le plateau technique et l’infrastructure ici en Tunisie ont largement fait leurs preuves et comptent parmi les meilleurs au monde.
          @endif
        </p>
        @if (get_theme_mod( 'about_btn_link' ) && get_theme_mod( 'about_btn_link' ) != '')
        <a href="{{ get_page_link(get_theme_mod( 'about_btn_link' )) }}" class="btn btn-primary black btn-sm float-sm-right">Read
          More <i class="feathericon feathericon-arrow-right right"></i></a>
        @endif
      </div>
    </div>
  </div>
</section>
<section class="expertise" id="app-imgbeforeandafter">
  <div class="container container-inner">
    <div class="section-title text-center">
      <h3 class="big w100 shadow-white text-uppercase">INTERVENTIONS</h3>
      <div class="seperator"></div>
    </div>
    <div class="row justify-content-center">
      <div class="col-10">
        <p class="text-center text-dark">
          Chacune des interventions est traitée avec une approche personnalisée, incluant une gamme complète de services de qualité, adaptée à chaque cas. La qualité du service et des soins esthétique est primordiale, c’est ce qui fait la différence et participe à la garantie de la réussite.
        </p>
      </div>
    </div>
    <div class="row" id="app-imgbeforeandafter">
      <!-- <div class="col-sm-6">
        <div class="img-compare">
          <image-compare :before="before" :after="after"/>
          <div class="info text-uppercase text-center">
            <h4>Expertise</h4>
          </div>
        </div>
      </div> -->
    </div>
  </div>
  <div class="">
      <image-compare before="https://wordpress.test/app/uploads/2018/09/home_beauty2_highlight1-1024x652.jpg" after="https://wordpress.test/app/uploads/2018/09/home_beauty2_highlight1-1024x652.jpg" :padding="{ left: 0, right: 0 }">
          <i class="fa fa-angle-left" aria-hidden="true" slot="icon-left"></i>
          <i class="fa fa-angle-right" aria-hidden="true" slot="icon-right"></i>
      </image-compare>
  </div>
</section>
<section class="expertise">
  <div class="container container-inner">
    <div class="section-title text-center">
      <h4 class="big w100 shadow-white text-uppercase text-center">DERNIÉRES ACTUALITÉS</h4>
      <div class="seperator"></div>
    </div>
    <div class="row justify-content-center">
      <div class="col-10">
        <p class="text-center text-dark">
            Docteur Samia Aoun vous accueille dans le cadre privilégié de ses interventions de chirurgie esthétique et plastique, afin de répondre à vos désirs de beauté.
            <br>
            Le Docteur Samia Aoun possède une grande expérience de la chirurgie et de la médecine esthétique du visage, de la silhouette, des injections et de la chirurgie intime.
            Pour tout connaître sur la chirurgie avec le Docteur Samia Aoun chirurgien esthétique en Tunisie depuis 20 ans, prenez contact.
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
            <h4>Trust</h4>
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
      <h4 class="big w100 shadow-white text-uppercase text-center">Nos Clients</h4>
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