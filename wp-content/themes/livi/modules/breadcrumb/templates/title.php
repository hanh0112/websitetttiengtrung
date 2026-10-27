<?php
echo apply_filters( 'livi_breadcrumb_get_template_part', livi_get_template_part( 'breadcrumb', 'templates/title-content', '',livi_breadcrumb_params() ), livi_get_page_id() ); ?>