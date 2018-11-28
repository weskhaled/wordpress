@php
$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
$w = $image[1];
$h = $image[2];
$class = ($h / $w) > 0.5 ? 'portrait' : '';
$featured_image = get_the_post_thumbnail(get_the_id(), 'medium', array('class' => $class));
$label = get_post_meta(get_the_id(), 'label', false)[0];
@endphp

@if(has_post_thumbnail())
<!--item-quote-->
<div class="swiper-slide quote">
<div class="client-image">
    <img src="{!! $image[0] !!}" alt="">
</div>
<h4 class="live-font text-capitalize">{{ get_the_title() }}</h4>
    <blockquote>
     {{ the_content() }}
    </blockquote>
<div class="client-info">
    <span class="badge badge-dark">{!! $label !!}</span>
</div>
</div>
@endif()