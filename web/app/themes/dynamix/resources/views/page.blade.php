@extends('layouts.page')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    <section>
    <div class="container container-inner text-dark">    
      @include('partials.content-page')</div>
    </section>
  @endwhile
  @include('partials.contact')
@endsection
