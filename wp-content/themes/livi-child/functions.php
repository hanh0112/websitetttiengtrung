<?php
/**
 * Livi Child Theme Functions
 * Tối ưu hóa toàn diện cho Trung Tâm Tiếng Trung Mỹ Đức
 * Chuẩn mực PM 10 năm kinh nghiệm: UX/UI, Typography Chuẩn Tiếng Việt, CRO, Local SEO
 */

// 1. Google Fonts Preconnect Tối Ưu Tốc Độ Tải Trang (Core Web Vitals)
add_action( 'wp_head', 'myduc_google_fonts_preconnect', 1 );
function myduc_google_fonts_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

// 2. Tải Stylesheet & Google Fonts "Be Vietnam Pro" Chuẩn 100% Tiếng Việt
add_action( 'wp_enqueue_scripts', 'myduc_enqueue_styles_and_fonts', 100 );
function myduc_enqueue_styles_and_fonts() {
    // Tải Google Font Be Vietnam Pro chuyên biệt cho tiếng Việt với đầy đủ bộ dấu
    wp_enqueue_style(
        'myduc-google-font-bevietnam',
        'https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800&family=Manrope:wght@400;500;600;700;800&family=Urbanist:wght@400;500;600;700;800;900&display=swap&subset=vietnamese,latin-ext',
        array(),
        null
    );

    // Tải CSS Theme Cha & Theme Con
    wp_enqueue_style( 'livi-parent', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'livi-child', get_stylesheet_directory_uri() . '/style.css', array('livi-parent', 'myduc-google-font-bevietnam'), '2.2.0' );
}

// 3. Khắc phục bộ subset & danh sách font của Theme Livi
add_filter( 'livi_google_font_supsets', function( $subset ) {
    return 'vietnamese,latin-ext';
});

add_filter( 'livi_google_fonts_list', function( $fonts ) {
    return array(
        'Be+Vietnam+Pro:300,400,500,600,700,800,900,300italic,400italic,500italic,600italic,700italic,800italic',
        'Urbanist:400,500,600,700,800,900',
        'Manrope:400,500,600,700,800'
    );
});

// Ghi đè Font-Family trong các biến CSS gốc của theme Livi
function myduc_set_vietnam_typography_fallback( $typo ) {
    if ( is_array( $typo ) ) {
        $typo['font-family'] = 'Be Vietnam Pro';
        $typo['font-fallback'] = "'Be Vietnam Pro', 'PingFang SC', 'Microsoft YaHei', 'Noto Sans SC', sans-serif";
    }
    return $typo;
}
add_filter( 'livi_body_typo_customizer_update', 'myduc_set_vietnam_typography_fallback', 99 );
add_filter( 'livi_h1_typo_customizer_update', 'myduc_set_vietnam_typography_fallback', 99 );
add_filter( 'livi_h2_typo_customizer_update', 'myduc_set_vietnam_typography_fallback', 99 );
add_filter( 'livi_h3_typo_customizer_update', 'myduc_set_vietnam_typography_fallback', 99 );
add_filter( 'livi_h4_typo_customizer_update', 'myduc_set_vietnam_typography_fallback', 99 );
add_filter( 'livi_h5_typo_customizer_update', 'myduc_set_vietnam_typography_fallback', 99 );
add_filter( 'livi_h6_typo_customizer_update', 'myduc_set_vietnam_typography_fallback', 99 );

// Thay thế Dancing Script (vốn lỗi font tiếng Việt) bằng Be Vietnam Pro
add_filter( 'livi_typo_font_family_css_var', function() {
    return "--wdtFontTypo_Ext: 'Be Vietnam Pro', 'PingFang SC', 'Microsoft YaHei', 'Noto Sans SC', sans-serif;";
}, 99 );

// 4. Thêm Nút Kêu Gọi Hành Động (CTA Button) vào cuối Thanh Menu
add_filter( 'wp_nav_menu_items', 'myduc_append_header_cta_button', 10, 2 );
function myduc_append_header_cta_button( $items, $args ) {
    // Chỉ thêm vào Menu chính trên Header
    $cta = '<li class="menu-item menu-item-cta"><a href="' . esc_url(home_url('/lien-he/')) . '" class="myduc-header-cta-btn"><span>Tư Vấn Ngay</span></a></li>';
    $items .= $cta;
    return $items;
}

// 5. Chức năng Chat Trực Tuyến & Mạng Xã Hội Đa Kênh (Mục 5 Hợp đồng)
add_action('wp_footer', 'myduc_render_omnichannel_floating_widget');
function myduc_render_omnichannel_floating_widget() {
    ?>
    <!-- Bộ Nút Liên Hệ Đa Kênh & Mạng Xã Hội (Mục 5 Hợp đồng) -->
    <div class="myduc-omnichannel-widget" id="myducOmniWidget">
        <!-- Nút Gọi Hotline (Hiệu ứng sóng xung kích) -->
        <a href="tel:0399535981" class="omni-btn omni-phone" title="Gọi Hotline: 0399.535.981" rel="nofollow">
            <span class="omni-pulse"></span>
            <svg viewBox="0 0 24 24"><path fill="#fff" d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
            <span class="omni-tooltip">Hotline: 0399.535.981</span>
        </a>

        <!-- Nút Chat Zalo -->
        <a href="https://zalo.me/0399535981" target="_blank" class="omni-btn omni-zalo" title="Chat Zalo cùng Cô Mỹ Đức" rel="noopener noreferrer nofollow">
            <span class="omni-badge">Zalo</span>
            <svg viewBox="0 0 48 48">
                <path fill="#fff" d="M24 4C12.95 4 4 12.95 4 24c0 4.09 1.25 7.89 3.39 11.04L4.5 43.5l8.84-2.82C16.32 42.71 19.99 44 24 44c11.05 0 20-8.95 20-20S35.05 4 24 4zm10.78 26.38c-.45 1.26-2.23 2.31-3.66 2.61-.98.2-2.26.36-6.55-1.42-5.49-2.28-9.03-7.85-9.3-8.21-.27-.37-2.23-2.97-2.23-5.66s1.41-4.01 1.91-4.56c.5-.55 1.09-.69 1.45-.69.36 0 .73.01 1.04.02.33.02.78-.13 1.22.93.45 1.09 1.54 3.77 1.68 4.05.14.27.23.59.05.95-.18.37-.27.59-.54.91-.27.32-.57.71-.81.96-.27.27-.55.57-.24 1.1.32.55 1.41 2.33 3.03 3.77 2.08 1.85 3.84 2.42 4.39 2.69.55.27.86.23 1.18-.14.32-.37 1.36-1.59 1.73-2.14.36-.55.73-.45 1.22-.27.5.18 3.18 1.5 3.73 1.77.55.27.91.41 1.05.64.13.23.13 1.32-.32 2.58z"/>
            </svg>
            <span class="omni-tooltip">Tư vấn qua Zalo</span>
        </a>

        <!-- Nút Facebook Messenger -->
        <a href="https://m.me/tiengtrungcomyduc" target="_blank" class="omni-btn omni-messenger" title="Nhắn tin Facebook Messenger" rel="noopener noreferrer nofollow">
            <svg viewBox="0 0 24 24"><path fill="#fff" d="M12 2C6.36 2 2 6.13 2 11.23c0 2.91 1.41 5.51 3.63 7.22V22l3.41-1.87c.94.26 1.94.4 2.96.4 5.64 0 10-4.13 10-9.23S17.64 2 12 2zm1.06 12.44l-2.73-2.91-5.33 2.91 5.86-6.22 2.8 2.91 5.26-2.91-5.86 6.22z"/></svg>
            <span class="omni-tooltip">Facebook Messenger</span>
        </a>

        <!-- Menu Mạng Xã Hội Mở Rộng -->
        <div class="omni-social-bar">
            <!-- Facebook Fanpage -->
            <a href="https://www.facebook.com/tiengtrungcomyduc/" target="_blank" class="omni-sub-btn omni-fb" title="Fanpage Facebook (21.000+ Followers)" rel="noopener noreferrer">
                <svg viewBox="0 0 24 24"><path fill="#fff" d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95C18.05 21.45 22 17.19 22 12z"/></svg>
            </a>
            <!-- TikTok -->
            <a href="https://www.tiktok.com/@tiengtrungmyduc" target="_blank" class="omni-sub-btn omni-tiktok" title="Kênh TikTok Học Tiếng Trung" rel="noopener noreferrer">
                <svg viewBox="0 0 24 24"><path fill="#fff" d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64c.29 0 .58.04.86.13V9.4a6.33 6.33 0 00-6.62 6.32 6.34 6.34 0 0010.82 4.48c1.38-1.28 2.25-3.13 2.25-5.18V8.71a8.18 8.18 0 004.8 1.54V6.8a4.85 4.85 0 01-2-.11z"/></svg>
            </a>
            <!-- YouTube -->
            <a href="https://www.youtube.com/@tiengtrungmyduc" target="_blank" class="omni-sub-btn omni-youtube" title="Kênh YouTube Bài Giảng Tiếng Trung" rel="noopener noreferrer">
                <svg viewBox="0 0 24 24"><path fill="#fff" d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
            <!-- Email -->
            <a href="mailto:tiengtrungcomyduc@gmail.com" class="omni-sub-btn omni-email" title="Gửi Email cho Mỹ Đức">
                <svg viewBox="0 0 24 24"><path fill="#fff" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            </a>
        </div>
    </div>
    <?php
}

// 6. Chức Năng Chia Sẻ Bài Viết Qua Mạng Xã Hội (Mục 6 Hợp đồng)
add_filter('the_content', 'myduc_add_social_share_buttons');
function myduc_add_social_share_buttons($content) {
    if (is_singular('post') || is_page()) {
        $url = urlencode(get_permalink());
        $title = urlencode(get_the_title());
        
        $share_html = '
        <div class="myduc-social-share-box">
            <span class="share-title">Chia sẻ trang này:</span>
            <div class="share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u='.$url.'" target="_blank" class="share-btn share-fb" title="Chia sẻ lên Facebook" rel="noopener noreferrer nofollow">
                    <svg viewBox="0 0 24 24"><path fill="#fff" d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95C18.05 21.45 22 17.19 22 12z"/></svg>
                    <span>Facebook</span>
                </a>
                <a href="https://zalo.me/share?url='.$url.'" target="_blank" class="share-btn share-zalo" title="Chia sẻ qua Zalo" rel="noopener noreferrer nofollow">
                    <span>Zalo</span>
                </a>
                <button type="button" class="share-btn share-copy" onclick="navigator.clipboard.writeText(window.location.href); alert(\'Đã sao chép liên kết vào bộ nhớ tạm!\');" title="Sao chép liên kết">
                    <svg viewBox="0 0 24 24"><path fill="#fff" d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>
                    <span>Sao chép Link</span>
                </button>
            </div>
        </div>';
        
        return $content . $share_html;
    }
    return $content;
}

// 7. Rank Math SEO Schema Markup (Mục 8 Hợp đồng)
add_filter('rank_math/json_ld', function( $data, $jsonld ) {
    if ( is_front_page() ) {
        $data['Organization'] = [
            '@context'      => 'https://schema.org',
            '@type'         => 'EducationalOrganization',
            'name'          => 'Trung Tâm Tiếng Trung Mỹ Đức',
            'alternateName' => 'Tiếng Trung Cô Mỹ Đức Huế',
            'url'           => home_url('/'),
            'logo'          => home_url('/wp-content/uploads/logo-my-duc.jpg'),
            'telephone'     => '+84399535981',
            'email'         => 'tiengtrungcomyduc@gmail.com',
            'sameAs'        => [
                'https://www.facebook.com/tiengtrungcomyduc/',
                'https://www.tiktok.com/@tiengtrungmyduc',
                'https://www.youtube.com/@tiengtrungmyduc'
            ]
        ];
    }
    return $data;
}, 99, 2);

// 8. Loại bỏ hoàn toàn banner Breadcrumb nhân bản (Do xung đột hook LiviPlusBCRankMath)
add_action( 'wp', 'myduc_remove_duplicate_breadcrumb_banner', 1 );
function myduc_remove_duplicate_breadcrumb_banner() {
    if ( class_exists( 'LiviPlusBCRankMath' ) ) {
        remove_filter( 'livi_breadcrumb_get_template_part', array( LiviPlusBCRankMath::instance(), 'register_template' ), 10 );
    }
}

// 9. Việt hóa đường dẫn Breadcrumb: 'Home' -> 'Trang Chủ'
add_filter( 'livi_breadcrumb_params', function( $params ) {
    $params['home'] = 'Trang Chủ';
    return $params;
}, 99 );

add_filter( 'livi_breadcrumbs', function( $breadcrumbs ) {
    return str_replace( '>Home<', '>Trang Chủ<', $breadcrumbs );
}, 99 );

// 10. Việt hóa các chuỗi hiển thị của thanh tìm kiếm khóa học và hệ thống LMS
add_filter( 'gettext', 'myduc_translate_core_strings', 20, 3 );
function myduc_translate_core_strings( $translated_text, $text, $domain ) {
    if ( $text === 'What do you need to Learn ?' ) {
        return 'Bạn đang tìm khóa học tiếng Trung nào?';
    }
    if ( $text === 'Search' && $domain === 'dtlms' ) {
        return 'Tìm Kiếm';
    }
    return $translated_text;
}

