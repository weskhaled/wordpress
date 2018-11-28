<header class="default-header {{ (get_theme_mod( 'header_fixed' ) == true) ? 'fixed-top' : '' }}">
    <div class="subnav" style="{{ (get_theme_mod( 'subnav_color' )) ? 'background-color:'.get_theme_mod( 'subnav_color' ).';' : '' }}">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="text-right">
                        <div class="subnavinfo row justify-content-end">
                            <div class="col">
                                <span class=""><i class="fa fa-phone"></i> {{ (get_theme_mod( 'subnav_color' )) ? get_theme_mod( 'subnav_phonenumber' ) : '+216 24 838 161' }} </span>
                                <span class=""><i class="fa fa-envelope"></i> {{ (get_theme_mod( 'subnav_color' )) ? get_theme_mod( 'subnav_email' ) : 'contact@dynamix-it.be' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="<?php echo esc_url( get_theme_mod( 'upload_logo' ) ); ?>" width="150" height="35" alt="">
                <!-- <img src="@asset('images/logo.png')" width="150" height="35" alt=""> -->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                @if (has_nav_menu('primary_navigation'))
                {!! 
                    wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'navbar-nav ml-auto nav'])
                !!}
                @endif
                @if (get_theme_mod( 'submit_btn_link' ))  
                <ul class="mr-0 nav">
                    <li class="nav-item">
                        <a href="{{ get_page_link(get_theme_mod( 'submit_btn_link' )) }}" class="btn btn-fill black btn-sm p-1">
                            Submit CV
                        </a>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </nav>
</header>