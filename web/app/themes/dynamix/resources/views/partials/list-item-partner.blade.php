@php
$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
$w = $image[1];
$h = $image[2];
$class = ($h / $w) > 0.5 ? 'portrait' : '';
$featured_image = get_the_post_thumbnail(get_the_id(), 'medium', array('class' => $class));
@endphp

@if(has_post_thumbnail())
    <!--item-partner-->
    <div class="swiper-slide">
        <img src="{!! $image[0] !!}" alt="">
    </div>
@endif()