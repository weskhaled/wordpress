<footer>
    <div class="footer-container" style="{{  get_theme_mod( 'footer_bg_color' ) ? 'background-color: '.get_theme_mod( 'footer_bg_color' ).';' : '' }}{{ (get_theme_mod( 'subfooter_fixed' ) == true) ? 'margin-bottom: 60px;' : '' }}">
        <div class="container container-inner">
            <div class="row">
                <div class="col-sm-3">
                    <section class="widget text-4 widget_text">
                            @php dynamic_sidebar('sidebar-footer-col-1') @endphp
                    </section> <!-- /.widget -->
                </div>
                <div class="col-sm-3">
                    <section class="widget">
                            @php dynamic_sidebar('sidebar-footer-col-2') @endphp
                    </section>
                </div>
                <div class="col-sm-3">
                    <section class="widget text-2 widget_text">
                        <div class="textwidget">
                            @php dynamic_sidebar('sidebar-footer-col-3') @endphp
                            <!-- /.widget -->
                        </div>
                    </section>
                </div>
                <div class="col-sm-3">
                    <section class="widget tag_cloud">
                        @php dynamic_sidebar('sidebar-footer-col-4') @endphp
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights {{ (get_theme_mod( 'subfooter_fixed' ) == true) ? ' fixed-bottom' : '' }}" style="{{  get_theme_mod( 'sub_footer_bg_color' ) ? 'background-color: '.get_theme_mod( 'sub_footer_bg_color' ).';' : '' }}">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    @php dynamic_sidebar('sub-footer-text') @endphp
                </div>
                <div class="col-sm-6">
                    <div class="social-icons text-right clearfix">
                        <a href="<?php echo get_theme_mod( 'facebook' ); ?>" target="_blank" class="social-icon si-small si-facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="<?php echo get_theme_mod( 'twitter' ); ?>" target="_blank" class="social-icon si-small si-twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="<?php echo get_theme_mod( 'linkedin' ); ?>" target="_blank" class="social-icon si-small si-linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>