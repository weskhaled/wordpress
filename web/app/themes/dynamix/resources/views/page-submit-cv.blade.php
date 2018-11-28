{{--
  Template Name: Submit CV Template
--}}

@extends('layouts.landing')
@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')  
    <!-- @include('partials.content-page') -->
    @if($submit_cv)
    <h1>OK</h1>
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

    @else
    <section class="section section-bg-13 section-cover pt-10 pb-19"> 

        <div class="container">
          <div class="row">
            <div class="col-lg-5"></div>
            <div class="col-lg-7">
              <h3 class="mt-5 mb-4 text-dark">Submit your resume online and let us help you find your next job opportunity.</h3>
                <form action="{{ the_permalink() }}" id="submitcv" method="post" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">First Name</label>
                      <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">Last Name</label>
                      <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
                  </div>
                  <div class="form-group">
                    <label for="inputAddress">E-mail</label>
                    <input type="text" class="form-control" name="mail" id="mail" placeholder="Phone">
                  </div>
                  <div class="form-group">
                  <div class="form-group">
                    <label for="exampleFormControlFile1">Resume</label>
                    <input type="file" class="form-control-file" name="resumefile" id="exampleFormControlFile1">
                  </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Message</label>
                    <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
                  </div>
                  <input type="hidden" name="submitted" id="submitted" value="true" />
                  <button type="submit" class="btn btn-primary">Submit Your Resume</button>
                </form>
              <div class="mb-5"></div>
            </div>
          </div>
        </div>

    </section>
    @endif
  @endwhile
@endsection
