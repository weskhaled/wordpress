@php
$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
$w = $image[1];
$h = $image[2];
$class = ($h / $w) > 0.5 ? 'portrait' : '';
$featured_image = get_the_post_thumbnail(get_the_id(), 'medium', array('class' => $class));
@endphp

@if(has_post_thumbnail())
<article class="swiper-slide" data-hash="slide1" data-title="{{ get_the_title() }}" data-thumb-url="{!! $image[0] !!}">
    <header>
        <div class="pattern pattern-1"></div>
        <!--<div class="pattern back-35-g"></div>-->
        <div class="header-image" style="background-image: url({!! $image[0] !!};"></div>

        <div class="container container-inner" data-swiper-parallax-x="-30%">
            {{ the_content() }}
        </div>
    </header>
</article>
@endif()