<?php
    if( isset( $enable_404message ) && ( $enable_404message == 1 || $enable_404message == true )  ) {
        $class = $notfound_style;
        $class .= ( isset( $notfound_darkbg ) && ( $notfound_darkbg == 1 ) ) ? " wdt-dark-bg" :"";
    ?>
    <div class="wrapper <?php echo esc_attr( $class );?>">
        <div class="container">
            <div class="center-content-wrapper">
                <div class="center-content">
                    <div class="error-box square">
                        <div class="error-box-inner">
                            <h2><?php esc_html_e("404", 'livi'); ?></h2>
                            <h3><?php esc_html_e("Oops ! The Page Not Found.", 'livi'); ?></h3>
                        </div>
                    </div>
                    <div class="wdt-hr-invisible-xsmall"></div>
                    <p><?php esc_html_e("Nulla euismod congue semper Cras id nisi egestas tellus, Nunc eu urna vestibulum viverra Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed facilisis faucibus neque, eget vulputate quam commodo.", 'livi'); ?></p>
                    <div class="wdt-hr-invisible-xsmall"></div>
                    <a class="wdt-button filled small" target="_self" href="<?php echo esc_url(home_url('/'));?>"><?php esc_html_e("Back to Home",'livi');?></a>
                </div>
            </div>
        </div>
    </div><?php
}?>