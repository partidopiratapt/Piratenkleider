<?php
/**
 * Piratenkleider Theme Optionen
 *
 * @source http://github.com/xwolfde/Piratenkleider
 * @creator xwolf
 * @version 2.21
 * @licence CC-BY-SA 3.0 
 */
// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain('piratenkleider', get_template_directory() . '/languages');
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if (is_readable($locale_file))
    require_once( $locale_file );
if ((isset($_GET['action']) && $_GET['action'] != 'logout') || (isset($_POST['login_location']) && !empty($_POST['login_location']))) {
    add_filter('login_redirect', 'my_login_redirect', 10, 3);

    function my_login_redirect() {
        $location = $_SERVER['HTTP_REFERER'];
        wp_safe_redirect($location);
        exit();
    }

}
require( get_template_directory() . '/inc/constants.php' );

function meses($str) {
    switch ($str) {
        case '01':
            return 'Janeiro';
            break;
        case '02':
            return 'Fevereiro';
            break;
        case '03':
            return 'Mar&ccedil;o';
            break;
        case '04':
            return 'Abril';
            break;
        case '05':
            return 'Maio';
            break;
        case '06':
            return 'Junho';
            break;
        case '07':
            return 'Julho';
            break;
        case '08':
            return 'Agosto';
            break;
        case '09':
            return 'Setembro';
            break;
        case '10':
            return 'Outubro';
            break;
        case '11':
            return 'Novembro';
            break;
        case '12':
            return 'Dezembro';
            break;
    }
}

$options = get_option('piratenkleider_theme_options');
$options = piratenkleider_compatibility($options);
// adjusts variables for downwards comptability
// ** bw 2012-08-12 wordpress reverse proxy x-forwarded-for ip fix ** //
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $xffaddrs = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $_SERVER['REMOTE_ADDR'] = $xffaddrs[0];
}
$_SERVER['REMOTE_ADDR'] = getAnonymIp($_SERVER['REMOTE_ADDR']);

if ($options['anonymize-user'] == 1) {
    /* IP-Adresse Ã¼berschreiben */
    $_SERVER["REMOTE_ADDR"] = "0.0.0.0";
    /* UA-String Ã¼berschreiben */
    $_SERVER["HTTP_USER_AGENT"] = "";
    update_option('require_name_email', 0);
}

function is_user_online($user_id, $time = 5) {
    global $wp, $wpdb;
    $user_login = $wpdb->get_var($wpdb->prepare("
        SELECT u.user_login FROM $wpdb->users u JOIN $wpdb->usermeta um ON um.user_id = u.ID 
        WHERE     u.ID = $user_id 
        AND um.meta_key = 'last_activity'
        AND DATE_ADD( um.meta_value, INTERVAL $time MINUTE ) >= UTC_TIMESTAMP()
        "
    ));
    if (isset($user_login) && $user_login != "") {
        return true;
    } else {
        return false;
    }
}

function update_online_users_status() {
    if (is_user_logged_in()) {
        if (($logged_in_users = get_transient('users_online')) === false)
            $logged_in_users = array();
        $current_user = wp_get_current_user();
        $current_user = $current_user->ID;
        $current_time = current_time('timestamp');
        if (!isset($logged_in_users[$current_user]) || ($logged_in_users[$current_user] < ($current_time - (15 * 60)))) {
            $logged_in_users[$current_user] = $current_time;
            set_transient('users_online', $logged_in_users, 30 * 60);
        }
    }
}

add_action('wp', 'update_online_users_status');
require_once ( get_template_directory() . '/theme-options.php' );

if (!function_exists('piratenkleider_setup')) {

    function piratenkleider_setup() {
        global $defaultoptions;
        global $options;


        if (!isset($content_width))
            $content_width = $defaultoptions['content-width'];
        // Load the AJAX functions for the theme
        require( get_template_directory() . '/inc/ajax.php' );
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();
        // This theme comes with all the BuddyPress goodies
        add_theme_support('buddypress');
        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');
        // Add responsive layout support to bp-default without forcing child
        // themes to inherit it if they don't want to
        add_theme_support('bp-default-responsive');

        $args = array(
            'width' => 0,
            'height' => 0,
            'default-image' => $defaultoptions['logo'],
            'uploads' => true,
            'random-default' => false,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => false,
            'suggested-height' => $defaultoptions['logo-height'],
            'suggested-width' => $defaultoptions['logo-width'],
            'max-width' => 350,
        );
        add_theme_support('custom-header', $args);

        $args = array(
            'default-color' => $defaultoptions['background-header-color'],
            'default-image' => $defaultoptions['background-header-image'],
            'background_repeat' => 'repeat-x',
            'background_position_x' => 'left',
            'background_position_y' => 'bottom',
            'wp-head-callback' => 'piratenkleider_custom_background_cb',
        );

        /**
         * piratenkleider custom background callback.
         *
         */
        function piratenkleider_custom_background_cb() {
            global $defaultoptions;
            global $options;
            // $background is the saved custom image, or the default image.
            $background = set_url_scheme(get_background_image());

            // $color is the saved custom color.
            // A default has to be specified in style.css. It will not be printed here.
            $color = get_theme_mod('background_color');

            if (!$background && !$color)
                return;


            $style = $color ? "background-color: #$color;" : '';

            if ($background) {
                $image = " background-image: url('$background');";

                if ($background == $defaultoptions['background-header-image']) {
                    $style .= $image;
                } else {
                    $repeat = get_theme_mod('background_repeat', 'repeat-x');
                    if (!in_array($repeat, array('no-repeat', 'repeat-x', 'repeat-y', 'repeat')))
                        $repeat = 'repeat-x';
                    $repeat = " background-repeat: $repeat;";

                    $positionx = get_theme_mod('background_position_x', 'left');
                    if (!in_array($positionx, array('center', 'right', 'left')))
                        $positionx = 'left';
                    $positiony = get_theme_mod('background_position_y', 'bottom');
                    if (!in_array($positiony, array('top', 'bottom')))
                        $positiony = 'bottom';

                    $position = " background-position: $positionx $positiony;";

                    $attachment = get_theme_mod('background_attachment', 'scroll');
                    if (!in_array($attachment, array('fixed', 'scroll')))
                        $attachment = 'scroll';
                    $attachment = " background-attachment: $attachment;";

                    $style .= $image . $repeat . $position . $attachment;
                }
            }


            echo '<style type="text/css" id="custom-background-css">';
            echo '.header { ' . trim($style) . ' } ';
            echo '</style>';
        }

        add_theme_support('custom-background', $args);

        if (function_exists('add_theme_support')) {
            add_theme_support('post-thumbnails');
            set_post_thumbnail_size(150, 150); // default Post Thumbnail dimensions   
        }

        if (function_exists('add_image_size')) {
            add_image_size('teaser-thumb', $options['teaser-thumbnail_width'], $options['teaser-thumbnail_height'], $options['teaser-thumbnail_crop']); //300 pixels wide (and unlimited height)
            if ($options['aktiv-linktipps']) {
                add_image_size('linktipp-thumb', $options['linktipp-thumbnail_width'], $options['linktipp-thumbnail_height'], $options['linktipp-thumbnail_crop']); //300 pixels wide (and unlimited height)
            }
        }



        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Hauptnavigation (Statische Seiten)', 'piratenkleider'),
            'top' => __('Linkmenu (Links zu Webportalen wie Wiki, Forum, etc)', 'piratenkleider'),
            'sub' => __('Technische Navigation (Kontakt, Impressum, etc)', 'piratenkleider'),
        ));


        if ($options['login_errors'] == 0) {
            /** Abschalten von Fehlermeldungen auf der Loginseite */
            add_filter('login_errors', create_function('$a', "return null;"));
        }
        /** Entfernen der Wordpressversionsnr im Header */
        remove_action('wp_head', 'wp_generator');

        /* Zulassen von Shortcodes in Widgets */
        add_filter('widget_text', 'do_shortcode');
        if (!is_admin() || ( defined('DOING_AJAX') && DOING_AJAX )) {
            // Register buttons for the relevant component templates
            // Friends button
            if (bp_is_active('friends'))
                add_action('bp_member_header_actions', 'bp_add_friend_button', 5);
            // Activity button
            if (bp_is_active('activity') && bp_activity_do_mentions())
                add_action('bp_member_header_actions', 'bp_send_public_message_button', 20);
            // Messages button
            if (bp_is_active('messages'))
                add_action('bp_member_header_actions', 'bp_send_private_message_button', 20);
            // Group buttons
            if (bp_is_active('groups')) {
                add_action('bp_group_header_actions', 'bp_group_join_button', 5);
                add_action('bp_group_header_actions', 'bp_group_new_topic_button', 20);
                add_action('bp_directory_groups_actions', 'bp_group_join_button');
            }
            // Blog button
            if (bp_is_active('blogs'))
                add_action('bp_directory_blogs_actions', 'bp_blogs_visit_blog_button');
        }
        if ($options['yt-alternativeembed']) {
            /* Filter fuer YouTube Embed mit nocookie: */
            #    wp_oembed_remove_provider( '#https://(www\.)?youtube.com/watch.*#i' );
            wp_embed_register_handler('ytnocookie', '#https?://www\.youtube\-nocookie\.com/embed/([a-z0-9\-_]+)#i', 'wp_embed_handler_ytnocookie');
            wp_embed_register_handler('ytnormal', '#https?://www\.youtube\.com/watch\?v=([a-z0-9\-_]+)#i', 'wp_embed_handler_ytnocookie');
            wp_embed_register_handler('ytnormal2', '#https?://www\.youtube\.com/watch\?feature=player_embedded&v=([a-z0-9\-_]+)#i', 'wp_embed_handler_ytnocookie');
        }

        function wp_embed_handler_ytnocookie($matches, $attr, $url, $rawattr) {
            global $defaultoptions;
            $relvideo = '';
            if ($defaultoptions['yt-norel'] == 1) {
                $relvideo = '?rel=0';
            }
            $embed = sprintf(
                    '<div class="embed-youtube"><p><img src="%1$s/images/social-media/youtube-24x24.png" width="24" height="24" alt="">YouTube-Video: <a href="https://www.youtube.com/watch?v=%2$s">https://www.youtube.com/watch?v=%2$s</a></p><iframe src="https://www.youtube-nocookie.com/embed/%2$s%5$s" width="%3$spx" height="%4$spx" frameborder="0" scrolling="no" marginwidth="0" marginheight="0"></iframe></div>', get_template_directory_uri(), esc_attr($matches[1]), $defaultoptions['yt-content-width'], $defaultoptions['yt-content-height'], $relvideo
            );

            return apply_filters('embed_ytnocookie', $embed, $matches, $attr, $url, $rawattr);
        }

        if ($options['aktiv-linktipps']) {
            require( get_template_directory() . '/inc/custom-posts.php' );
        }
    }

}
add_action('after_setup_theme', 'piratenkleider_setup');

require( get_template_directory() . '/inc/widgets.php' );

function piratenkleider_enqueue_scripts() {
    global $options;
    global $defaultoptions;

    wp_enqueue_script(
            'layoutjs', $defaultoptions['src-layoutjs'], array('jquery'), $defaultoptions['js-version']
    );

    if (is_singular() && ($options['aktiv-commentreplylink'] == 1) && get_option('thread_comments')) {
        wp_enqueue_script(
                'comment-reply', $defaultoptions['src-comment-reply'], false, $defaultoptions['js-version']
        );
    }


    if (is_singular() && ($options['aktiv-circleplayer'] == 1)) {
        wp_enqueue_script(
                'jplayer', $defaultoptions['src-jplayer'], array('jquery'), $defaultoptions['js-version']
        );
        wp_enqueue_script(
                'transform2d', $defaultoptions['src-transform2d'], array('jplayer'), $defaultoptions['js-version']
        );
        wp_enqueue_script(
                'grab', $defaultoptions['src-grab'], array('jplayer'), $defaultoptions['js-version']
        );
        wp_enqueue_script(
                'csstransforms', $defaultoptions['src-csstransforms'], array('jplayer'), $defaultoptions['js-version']
        );
        wp_enqueue_script(
                'circleplayer', $defaultoptions['src-circleplayer'], array('jplayer'), $defaultoptions['js-version']
        );
    }
    // Enqueue the global JS - Ajax will not work without it
    wp_enqueue_script('dtheme-ajax-js', get_template_directory_uri() . '/inc/global.js', array('jquery'), bp_get_version());
    // Add words that we need to use in JS to the end of the page so they can be translated and still used.
    $params = array(
        'my_favs' => __('My Favorites', 'buddypress'),
        'accepted' => __('Accepted', 'buddypress'),
        'rejected' => __('Rejected', 'buddypress'),
        'show_all_comments' => __('Show all comments for this thread', 'buddypress'),
        'show_x_comments' => __('Show all %d comments', 'buddypress'),
        'show_all' => __('Show all', 'buddypress'),
        'comments' => __('comments', 'buddypress'),
        'close' => __('Close', 'buddypress'),
        'view' => __('View', 'buddypress'),
        'mark_as_fav' => __('Favorite', 'buddypress'),
        'remove_fav' => __('Remove Favorite', 'buddypress'),
        'unsaved_changes' => __('Your profile has unsaved changes. If you leave the page, the changes will be lost.', 'buddypress'),
    );
    wp_localize_script('dtheme-ajax-js', 'BP_DTheme', $params);
    // Maybe enqueue comment reply JS
    if (is_singular() && bp_is_blog_page() && get_option('thread_comments'))
        wp_enqueue_script('comment-reply');
    wp_enqueue_script('sceditor', get_template_directory_uri() . '/js/jquery.sceditor.bbcode.js', array('jquery'));
    wp_enqueue_script('jqueryrotate', get_template_directory_uri() . '/js/jQueryRotate.js', array('jquery'));
    wp_enqueue_script('toggles', get_template_directory_uri() . '/js/toggles.js', array('jqueryrotate'));
}

add_action('wp_enqueue_scripts', 'piratenkleider_enqueue_scripts');

function piratenkleider_addmetatags() {
    global $defaultoptions;
    global $options;

    $output = "";
    $output .= "\t" . '<meta charset="' . get_bloginfo('charset') . '">' . "\n";
    $output .= "\t" . '<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=9"> <![endif]-->' . "\n";
    $output .= "\t" . '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";

    if ((isset($options['meta-description'])) && ( strlen(trim($options['meta-description'])) > 1 )) {
        $output .= "\t" . '<meta name="description" content="' . $options['meta-description'] . '">' . "\n";
    }
    if ((isset($options['meta-author'])) && ( strlen(trim($options['meta-author'])) > 1 )) {
        $output .= "\t" . '<meta name="author" content="' . $options['meta-author'] . '">' . "\n";
    }
    if ((isset($options['meta-verify-v1'])) && ( strlen(trim($options['meta-verify-v1'])) > 1 )) {
        $output .= "\t" . '<meta name="verify-v1" content="' . $options['meta-verify-v1'] . '">' . "\n";
    }

    $csv_tags = '';
    $tags = '';
    if ($options['aktiv-autokeywords']) {
        $posttags = get_tags(array('number' => $maxwords, 'orderby' => 'count', 'order' => 'DESC'));
        $tags = '';
        if (isset($posttags)) {
            foreach ($posttags as $tag) {
                $csv_tags .= $tag->name . ',';
            }
            $tags = substr($csv_tags, 0, -2);
        }
        if ((isset($options['meta-keywords'])) && (strlen(trim($options['meta-keywords'])) > 1 )) {
            $tags = $options['meta-keywords'] . ', ' . $tags;
        }
    } else {
        if ((isset($options['meta-keywords'])) && (strlen(trim($options['meta-keywords'])) > 1 )) {
            $tags = $options['meta-keywords'];
        }
    }
    if ((isset($tags)) && (strlen(trim($tags)) > 2 )) {
        if (strlen(trim($tags)) > $maxlength) {
            $tags = substr($tags, 0, strpos($tags, ",", $maxlength));
        }
        $output .= "\t" . '<meta name="keywords" content="' . $tags . '">' . "\n";
    }

    if ((isset($options['favicon-file'])) && ($options['favicon-file'] > 0 )) {
        $output .= "\t" . '<link rel="shortcut icon" href="' . wp_get_attachment_url($options['favicon-file']) . '">' . "\n";
    } else {
        $output .= "\t" . '<link rel="apple-touch-icon" href="' . get_template_directory_uri() . '/apple-touch-icon.png">' . "\n";
        $output .= "\t" . '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/favicon.ico">' . "\n";
    }
    echo $output;
}

add_action('wp_head', 'piratenkleider_addmetatags');



/* Anonymize IP */

function getAnonymIp($ip, $strongness = 2) {

    if ($strongness == 2) {
        /* Strong BSI Norm: last two oktetts to 0 */
        return preg_replace('/[0-9]+.[0-9]+\z/', '0.0', $ip);
    } elseif ($strongness == 1) {
        /* Weak BSI Norm: last two oktetts to 0 */
        return preg_replace('/[0-9]+\z/', '0', $ip);
    } elseif ($strongness == 0) {
        /* No anonymizing */
        return $ip;
    } else {
        /* Strong BSI Norm: last two oktetts to 0 */
        return preg_replace('/[0-9]+.[0-9]+\z/', '0.0', $ip);
    }
}

function feed_lifetime_cb() {
    global $options;
    return $options['feed_cache_lifetime'];
}

add_filter('wp_feed_cache_transient_lifetime', 'feed_lifetime_cb');

function piratenkleider_avatar($avatar_defaults) {
    global $defaultoptions;
    $myavatar = $defaultoptions['src-default-avatar'];
    $avatar_defaults[$myavatar] = "Piratenkleider";
    return $avatar_defaults;
}

add_filter('avatar_defaults', 'piratenkleider_avatar');

/* Refuse spam-comments on media */

function filter_media_comment_status($open, $post_id) {
    $post = get_post($post_id);
    if ($post->post_type == 'attachment') {
        return false;
    }
    return $open;
}

add_filter('comments_open', 'filter_media_comment_status', 10, 2);

/* Format list for Tagclouds also in widgets */

function edit_args_tag_cloud_widget($args) {
    $args = array('format' => 'list');
    return $args;
}

add_filter('widget_tag_cloud_args', 'edit_args_tag_cloud_widget');

function piratenkleider_url_spamcheck($approved, $commentdata) {
    return ( strlen($commentdata['comment_author_url']) > 50 ) ? 'spam' : $approved;
}

add_filter('pre_comment_approved', 'piratenkleider_url_spamcheck', 99, 2);
if (!function_exists('get_piratenkleider_options')) {
    /*
     * Erstes Bild aus einem Artikel auslesen, wenn dies vorhanden ist
     */

    function get_piratenkleider_options($field) {
        global $defaultoptions;
        if (!isset($field)) {
            $field = 'piratenkleider_theme_options';
        }
        $orig = get_option($field);
        if (!is_array($orig)) {
            $orig = array();
        }
        $alloptions = array_merge($defaultoptions, $orig);
        return $alloptions;
    }

}

function piratenkleider_get_cover($title, $id_page) {
    global $options;

    $image_url = '';
    $image_alt = '';
    if (has_post_thumbnail($id_page)) {
        $thumbid = get_post_thumbnail_id($id_page);
        $image_url_data = wp_get_attachment_image_src($thumbid, 'full');
        $image_url = $image_url_data[0];
        $image_alt = trim(strip_tags(get_post_meta($thumbid, '_wp_attachment_image_alt', true)));
    } else {
        if (($options['aktiv-defaultseitenbild'] == 1) && (isset($options['seiten-defaultbildsrc']))) {
            $image_url = $options['seiten-defaultbildsrc'];
        }
    }
    if (isset($image_url) && (strlen($image_url) > 4)) {
        echo '
                    <div class="content-header">
                        <h1 class="post-title"><span>' . $title . '</span></h1>
                        <div class="symbolbild"><img src="' . $image_url . '" alt="">';
        if (isset($image_alt) && (strlen($image_alt) > 1)) {
            echo '<div class="caption">' . $image_alt . '</div>';
        }
        echo '
                       </div>
                    </div>';
    }
    return $image_url;
}

function piratenkleider_compatibility($oldoptions) {
    global $defaultoptions;
    $doupdate = 0;

    $old_bilderarray = get_option('piratenkleider_theme_defaultbilder');

    if (!is_array($oldoptions)) {
        $oldoptions = array();
    }

    if (is_array($old_bilderarray)) {
        $newoptions = array_merge($defaultoptions, $old_bilderarray, $oldoptions);
        delete_option('piratenkleider_theme_defaultbilder');
        $doupdate = 1;
    } else {
        $newoptions = array_merge($defaultoptions, $oldoptions);
    }


    if ((isset($oldoptions['social_facebook'])) && (filter_var($oldoptions['social_facebook'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['facebook']['content'] = $oldoptions['social_facebook'];
        $newoptions['sm-list']['facebook']['active'] = 1;
    }
    if ((isset($oldoptions['social_twitter'])) && (filter_var($oldoptions['social_twitter'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['twitter']['content'] = $oldoptions['social_twitter'];
        $newoptions['sm-list']['twitter']['active'] = 1;
    }
    if ((isset($oldoptions['social_gplus'])) && (filter_var($oldoptions['social_gplus'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['gplus']['content'] = $oldoptions['social_gplus'];
        $newoptions['sm-list']['gplus']['active'] = 1;
    }
    if ((isset($oldoptions['social_diaspora'])) && (filter_var($oldoptions['social_diaspora'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['diaspora']['content'] = $oldoptions['social_diaspora'];
        $newoptions['sm-list']['diaspora']['active'] = 1;
    }
    if ((isset($oldoptions['social_identica'])) && (filter_var($oldoptions['social_identica'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['identica']['content'] = $oldoptions['social_identica'];
        $newoptions['sm-list']['identica']['active'] = 1;
    }
    if ((isset($oldoptions['social_youtube'])) && (filter_var($oldoptions['social_youtube'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['youtube']['content'] = $oldoptions['social_youtube'];
        $newoptions['sm-list']['youtube']['active'] = 1;
    }
    if ((isset($oldoptions['social_itunes'])) && (filter_var($oldoptions['social_itunes'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['itunes']['content'] = $oldoptions['social_itunes'];
        $newoptions['sm-list']['itunes']['active'] = 1;
    }
    if ((isset($oldoptions['social_flickr'])) && (filter_var($oldoptions['social_flickr'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['flickr']['content'] = $oldoptions['social_flickr'];
        $newoptions['sm-list']['flickr']['active'] = 1;
    }
    if ((isset($oldoptions['social_delicious'])) && (filter_var($oldoptions['social_delicious'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['delicious']['content'] = $oldoptions['social_delicious'];
        $newoptions['sm-list']['delicious']['active'] = 1;
    }
    if ((isset($oldoptions['social_flattr'])) && (filter_var($oldoptions['social_flattr'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['flattr']['content'] = $oldoptions['social_flattr'];
        $newoptions['sm-list']['flattr']['active'] = 1;
    }
    if ((isset($oldoptions['social_feed'])) && (filter_var($oldoptions['social_feed'], FILTER_VALIDATE_URL))) {
        $newoptions['sm-list']['feed']['content'] = $oldoptions['social_feed'];
        $newoptions['sm-list']['feed']['active'] = 1;
    }

    if ((isset($oldoptions['category-startpageview'])) && $oldoptions['category-startpageview'] == 1) {
        if ((!isset($oldoptions['category-num-article-fullwidth'])) && (isset($oldoptions['num-article-startpage-fullwidth']))) {
            $newoptions['category-num-article-fullwidth'] = $oldoptions['num-article-startpage-fullwidth'];
        }
        if ((!isset($oldoptions['category-num-article-halfwidth'])) && (isset($oldoptions['num-article-startpage-halfwidth']))) {
            $newoptions['category-num-article-halfwidth'] = $oldoptions['num-article-startpage-halfwidth'];
        }
        $newoptions['category-teaser'] = 1;
        $newoptions['category-startpageview'] = 0;
        $doupdate = 1;
    }

    if (!isset($newoptions['toplinkliste'])) {
        global $default_toplink_liste;
        $newoptions['toplinkliste'] = $default_toplink_liste;
        $doupdate = 1;
    }


    $olddesignopt = get_option('piratenkleider_theme_designspecials');
    if ((is_array($olddesignopt)) && (count($olddesignopt) > 0)) {
        $newoptions = array_merge($newoptions, $olddesignopt);
        delete_option('piratenkleider_theme_designspecials');
        $doupdate = 1;
    }
    $oldkontaktinfos = get_option('piratenkleider_theme_kontaktinfos');
    if ((is_array($oldkontaktinfos)) && (count($oldkontaktinfos) > 0)) {
        $newoptions = array_merge($newoptions, $oldkontaktinfos);
        delete_option('piratenkleider_theme_kontaktinfos');
        $doupdate = 1;
    }




    if ($doupdate == 1) {
        update_option('piratenkleider_theme_options', $newoptions);
    }

    return $newoptions;
}

/**
 * Get Image Attributes
 */
if (!function_exists('piratenkleider_get_image_attributs')) {

    function piratenkleider_get_image_attributs($id = 0) {
        $precopyright = __('Bild: ', 'piratenkleider');
        if ($id == 0) {
            return;
        }

        $meta = get_post_meta($id);
        if (!isset($meta)) {
            return;
        }
        $result = array();
        $result['alt'] = trim(strip_tags($meta['_wp_attachment_image_alt'][0]));

        if (isset($meta['_wp_attachment_metadata']) && is_array($meta['_wp_attachment_metadata'])) {
            $data = unserialize($meta['_wp_attachment_metadata'][0]);
            if (isset($data['image_meta']) && is_array($data['image_meta']) && isset($data['image_meta']['copyright'])) {
                $result['copyright'] = trim(strip_tags($data['image_meta']['copyright']));
            }
        }
        $attachment = get_post($id);
        if (isset($attachment)) {
            $result['beschriftung'] = trim(strip_tags($attachment->post_excerpt));
            $result['beschreibung'] = trim(strip_tags($attachment->post_content));
            $result['title'] = trim(strip_tags($attachment->post_title)); // Finally, use the title
        }

        $displayinfo = $result['beschriftung'];
        if (empty($displayinfo)) {
            $displayinfo = $result['beschreibung'];
        }
        if (empty($displayinfo) && !empty($result['copyright'])) {
            $displayinfo = $precopyright . $result['copyright'];
        }
        if (empty($displayinfo)) {
            $displayinfo = $result['alt'];
        }
        $result['credits'] = $displayinfo;
        return $result;
    }

}

if (!function_exists('piratenkleider_filter_wp_title')) {
    /*
     * Sets the title
     */

    function piratenkleider_filter_wp_title($title, $separator) {
        // Don't affect wp_title() calls in feeds.
        if (is_feed()) {
            return $title;
        }
        global $paged, $page;
        if (is_search()) {
            $title = sprintf(__('Suchergebnisse f&uuml;r %s', 'piratenkleider'), '"' . get_search_query() . '"');
            if ($paged >= 2) {
                $title .= " $separator " . sprintf(__('Seite %s', 'piratenkleider'), $paged);
            }
            $title .= " $separator " . get_bloginfo('name', 'display');
            return $title;
        }
        $title .= get_bloginfo('name', 'display');
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && ( is_home() || is_front_page() )) {
            $title .= " $separator " . $site_description;
        }
        if ($paged >= 2 || $page >= 2) {
            $title .= " $separator " . sprintf(__('Seite %s', 'piratenkleider'), max($paged, $page));
        }
        return $title;
    }

}
add_filter('wp_title', 'piratenkleider_filter_wp_title', 10, 2);

function piratenkleider_excerpt_length($length) {
    global $defaultoptions;
    return $defaultoptions['teaser_maxlength'];
}

add_filter('excerpt_length', 'piratenkleider_excerpt_length');

function piratenkleider_continue_reading_link() {
    return ' <a class="nobr" title="' . strip_tags(get_the_title()) . '" href="' . get_permalink() . '">' . __('Weiterlesen <span class="meta-nav">&rarr;</span>', 'piratenkleider') . '</a>';
}

function piratenkleider_auto_excerpt_more($more) {
    return ' &hellip;' . piratenkleider_continue_reading_link();
}

add_filter('excerpt_more', 'piratenkleider_auto_excerpt_more');

function piratenkleider_custom_excerpt_more($output) {
    if (has_excerpt() && !is_attachment()) {
        $output .= piratenkleider_continue_reading_link();
    }
    return $output;
}

add_filter('get_the_excerpt', 'piratenkleider_custom_excerpt_more');

function piratenkleider_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css);
}

add_filter('gallery_style', 'piratenkleider_remove_gallery_css');

function honor_ssl_for_attachments($url) {
    $http = site_url(FALSE, 'http');
    $https = site_url(FALSE, 'https');
    return is_ssl() ? str_replace($http, $https, $url) : $url;
}

add_filter('wp_get_attachment_url', 'honor_ssl_for_attachments');
if (!function_exists('piratenkleider_comment')) {

    /**
     * Template for comments and pingbacks.
     */
    function piratenkleider_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        global $defaultoptions;
        global $options;

        switch ($comment->comment_type) {
            case '' :
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <div id="comment-<?php comment_ID(); ?>">
                        <div class="comment-details">

                            <div class="comment-author vcard">
                                <?php
                                if ($options['aktiv-avatar'] == 1) {
                                    echo '<div class="avatar">';
                                    echo get_avatar($comment, 48, $defaultoptions['src-default-avatar']);
                                    echo '</div>';
                                }
                                printf(__('%s <span class="says">meinte am</span>', 'piratenkleider'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link()));
                                ?>
                            </div><!-- .comment-author .vcard -->
                            <?php
                            if ($comment->comment_approved == '0') {
                                ?>
                                <em><?php _e('Der Kommentar wartet auf die Freischaltung.', 'piratenkleider'); ?></em>
                                <br />
                                <?php
                            } //endif 
                            ?>

                            <div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                    <?php
                                    /* translators: 1: date, 2: time */
                                    printf(__('%1$s um %2$s', 'piratenkleider'), get_comment_date(), get_comment_time());
                                    ?></a> <?php _e('Folgendes', 'piratenkleider'); ?>:<?php edit_comment_link(__('(Edit)', 'piratenkleider'), ' ');
                                    ?>
                            </div><!-- .comment-meta .commentmetadata -->
                        </div>

                        <div class="comment-body"><?php comment_text(); ?></div>
                        <?php
                        if ($options['aktiv-commentreplylink']) {
                            ?>
                            <div class="reply">
                                <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>                       
                            </div> <!-- .reply -->
                            <?php
                        }
                        ?>
                    </div><!-- #comment-##  -->

                    <?php
                    break;
                case 'pingback' :
                case 'trackback' :
                    ?>
                <li class="post pingback">
                    <p><?php _e('Pingback:', 'piratenkleider'); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'piratenkleider'), ' '); ?></p>
                    <?php
                    break;
            }//endswitch;
        }

//end function piratenkleider_comment()
    }

    function piratenkleider_remove_recent_comments_style() {
        global $wp_widget_factory;
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }

    add_action('widgets_init', 'piratenkleider_remove_recent_comments_style');

    if (!function_exists('piratenkleider_post_teaser')) {

        /**
         * Erstellung eines Artikelteasers
         */
        function piratenkleider_post_teaser($titleup = 1, $showdatebox = 1, $showdateline = 0, $teaserlength = 200, $thumbfallback = 1, $usefloating = 0) {
            global $options;
            global $post;
            $post_id = $post->ID;
            $sizeclass = '';
            if ('linktipps' == get_post_type()) {
                $title = get_the_title();
                $linktipp_url = get_post_meta($post_id, 'linktipp_url', true);
                $linktipp_imgid = get_post_meta($post_id, 'linktipp_imgid', true);
                $linktipp_image = get_post_meta($post_id, 'linktipp_image', true);
                $linktipp_untertitel = get_post_meta($post_id, 'linktipp_untertitel', true);
                $linktipp_text = get_post_meta($post_id, 'linktipp_text', true);
                if (isset($linktipp_untertitel) && !isset($title)) {
                    $title = $linktipp_untertitel;
                    $linktipp_untertitel = '';
                }
                if (isset($title) && strlen(trim($title)) > 1 && isset($linktipp_url) && strlen(trim($linktipp_url)) > 1 && (isset($linktipp_imgid) || isset($linktipp_image) || isset($linktipp_text))) {

                    $sizeclass = 'ym-column post';
                    ?>
                    <section <?php post_class($sizeclass); ?> id="post-<?php the_ID(); ?>" >
                        <?php
                        if ($options['linktipps-titlepos'] != 1) {
                            echo '<header class="post-title ym-cbox">';
                            if (mb_strlen(trim($linktipp_untertitel)) > 1) {
                                echo '<hgroup>';
                            }
                            if (($options['linktipps-subtitlepos'] == 0) && (mb_strlen(trim($linktipp_untertitel)) > 1)) {
                                echo '<h3 class="subtitle">' . $linktipp_untertitel . '</h3>';
                            }

                            echo '<h2>';
                            if (($options['linktipps-linkpos'] == 0) || ($options['linktipps-linkpos'] == 3)) {
                                echo '<a href="' . $linktipp_url . '" rel="bookmark">';
                            }
                            echo trim($title);
                            if (($options['linktipps-linkpos'] == 0) || ($options['linktipps-linkpos'] == 3)) {
                                echo '</a>';
                            }
                            echo '</h2>';
                            if (($options['linktipps-subtitlepos'] == 1) && (mb_strlen(trim($linktipp_untertitel)) > 1)) {
                                echo '<h3 class="subtitle">' . $linktipp_untertitel . '</h3>';
                            }
                            if (mb_strlen(trim($linktipp_untertitel)) > 1) {
                                echo '</hgroup>';
                            }
                            echo '</header>';
                        }
                        echo '<div class="ym-column">';
                        echo '<article class="post-entry ym-cbox"><p>';
                        if ($options['linktipps-linkpos'] == 1) {
                            echo '<a href="' . $linktipp_url . '">';
                        }

                        if (isset($linktipp_imgid) && ($linktipp_imgid > 0)) {
                            $image_attributes = wp_get_attachment_image_src($linktipp_imgid, 'linktipp-thumb');
                            if (is_array($image_attributes)) {
                                echo '<img src="' . $image_attributes[0] . '" width="' . $image_attributes[1] . '" height="' . $image_attributes[2] . '" alt="' . $linktipp_text . '">';
                            }
                        } elseif (isset($linktipp_image)) {
                            echo '<img src="' . $linktipp_image . '" alt="">';
                        }
                        if ($options['linktipps-linkpos'] == 1) {
                            echo '</a>';
                        }
                        if (isset($linktipp_text)) {
                            echo $linktipp_text;
                        }
                        echo '</p></article>';

                        if ($options['linktipps-titlepos'] == 1) {
                            echo '<header class="post-title ym-cbox">';
                            if (str_len(trim($linktipp_untertitel)) > 1) {
                                echo '<hgroup>';
                            }
                            if (($options['linktipps-subtitlepos'] == 0) && (str_len(trim($linktipp_untertitel)) > 1)) {
                                echo '<h3 class="subtitle">' . $linktipp_untertitel . '</h3>';
                            }
                            echo '<h2>';
                            if (($options['linktipps-linkpos'] == 0) || ($options['linktipps-linkpos'] == 3)) {
                                echo '<a href="' . $linktipp_url . '" rel="bookmark">';
                            }
                            echo $title;
                            if (($options['linktipps-linkpos'] == 0) || ($options['linktipps-linkpos'] == 3)) {
                                echo '</a>';
                            }
                            echo '</h2>';
                            if (($options['linktipps-subtitlepos'] == 1) && (str_len(trim($linktipp_untertitel)) > 1)) {
                                echo '<h3 class="subtitle">' . $linktipp_untertitel . '</h3>';
                            }
                            if (str_len(trim($linktipp_untertitel)) > 1) {
                                echo '</hgroup>';
                            }
                            echo '</header>';
                        }
                        if (($options['linktipps-linkpos'] == 2) || ($options['linktipps-linkpos'] == 3)) {
                            echo '<footer class="linktipp-url"><a href="' . $linktipp_url . '">' . $linktipp_url . '</a></footer>';
                        }

                        echo '</div>';
                        echo '</section>';
                    }
                    return;
                }

                $leftbox = '';
                if (($showdatebox > 0) && ($showdatebox < 5)) {
                    $sizeclass = 'ym-column withthumb';
                    // Generate Thumb/Pic or Video first to find out which class we need

                    $leftbox .= '<div class="infoimage">';
                    $sizeclass = 'ym-column withthumb';
                    $thumbnailcode = '';
                    $firstpic = '';
                    $firstvideo = '';
                    if (has_post_thumbnail()) {
                        $thumbnailcode = get_the_post_thumbnail($post->ID, 'teaser-thumb');
                    }

                    $firstpic = get_piratenkleider_firstpicture();
                    $firstvideo = get_piratenkleider_firstvideo();
                    $fallbackimg = '<img src="' . $options['src-teaser-thumbnail_default'] . '" alt="">';
                    if ($showdatebox == 1) {
                        if (!isset($output)) {
                            $output = $thumbnailcode;
                        }
                        if (!isset($output)) {
                            $output = $firstpic;
                        }
                        if ((!isset($output)) && (isset($firstvideo))) {
                            $output = $firstvideo;
                            $sizeclass = 'ym-column withvideo';
                        }
                        if (!isset($output)) {
                            $output = $fallbackimg;
                        }
                        if ((isset($output)) && ( strlen(trim($output)) < 10 )) {
                            $output = $fallbackimg;
                        }
                    } elseif ($showdatebox == 2) {
                        if (!isset($output)) {
                            $output = $firstpic;
                        }
                        if (!isset($output)) {
                            $output = $thumbnailcode;
                        }
                        if ((!isset($output)) && (isset($firstvideo))) {
                            $output = $firstvideo;
                            $sizeclass = 'ym-column withvideo';
                        }
                        if (!isset($output)) {
                            $output = $fallbackimg;
                        }
                        if ((isset($output)) && ( strlen(trim($output)) < 10 )) {
                            $output = $fallbackimg;
                        }
                    } elseif ($showdatebox == 3) {
                        if ((!isset($output)) && (isset($firstvideo))) {
                            $output = $firstvideo;
                            $sizeclass = 'ym-column withvideo';
                        }
                        if (!isset($output)) {
                            $output = $thumbnailcode;
                        }
                        if (!isset($output)) {
                            $output = $firstpic;
                        }
                        if (!isset($output)) {
                            $output = $fallbackimg;
                        }
                        if ((isset($output)) && ( strlen(trim($output)) < 10 )) {
                            $output = $fallbackimg;
                        }
                    } elseif ($showdatebox == 4) {
                        if ((!isset($output)) && (isset($firstvideo))) {
                            $output = $firstvideo;
                            $sizeclass = 'ym-column withvideo';
                        }
                        if (!isset($output)) {
                            $output = $firstpic;
                        }
                        if (!isset($output)) {
                            $output = $thumbnailcode;
                        }
                        if (!isset($output)) {
                            $output = $fallbackimg;
                        }
                        if ((isset($output)) && ( strlen(trim($output)) < 10 )) {
                            $output = $fallbackimg;
                        }
                    } else {
                        $output = $fallbackimg;
                    }


                    $leftbox .= $output;
                    $leftbox .= '</div>';
                } else {
                    $sizeclass = 'ym-column';
                }
                if ($usefloating == 1) {
                    $sizeclass .= " usefloating";
                }
                ?> 
                <section <?php post_class($sizeclass); ?> id="post-<?php the_ID(); ?>" >
                    <?php
                    if ($titleup == 1) {
                        ?>
                        <header class="post-title ym-cbox"><h2>          
                                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2></header>       
                        <div class="ym-column"> 
                            <?php
                        }
                        /* 0 = Datebox, 
                         * 1 = Thumbnail (or: first picture, first video, fallback picture),
                         * 2 = First picture (or: thumbnail, first video, fallback picture),
                         * 3 = First video (or: thumbnail, first picture, fallback picture),
                         * 4 = First video (or: first picture, thumbnail, fallback picture),
                         * 5 = Nothing */

                        if ($showdatebox < 5) {
                            echo '<div class="post-info ym-col1"><div class="ym-cbox">';
                            if ($showdatebox == 0) {
                                $num_comments = get_comments_number();
                                if (($num_comments > 0) || ( $options['zeige_commentbubble_null'])) {
                                    echo '<div class="commentbubble">';
                                    if ($num_comments > 0) {
                                        comments_popup_link('0<span class="skip"> ' . __('Kommentare', 'piratenkleider') . '</span>', '1<span class="skip"> ' . __('Kommentar', 'piratenkleider') . '</span>', '%<span class="skip"> ' . __('Kommentare', 'piratenkleider') . '</span>', 'comments-link', '%<span class="skip"> ' . __('Kommentare', 'piratenkleider') . '</span>');
                                    } else {
                                        // Wenn der Zeitraum abgelaufen ist UND keine Kommentare gegeben waren, dann
                                        // liefert die Funktion keinen Link, sondern nur den Text . Daher dieser
                                        // Woraround:
                                        $link = get_comments_link();
                                        echo '<a href="' . $link . '">0<span class="skip"> ' . __('Kommentar', 'piratenkleider') . '</span></a>';
                                    }
                                    echo '</div>';
                                }
                                ?>
                                <div class="cal-icon">
                                    <span class="day"><?php the_time('j.'); ?></span>
                                    <span class="month"><?php the_time('m.'); ?></span>
                                    <span class="year"><?php the_time('Y'); ?></span>
                                </div>

                                <?php
                            } else {
                                echo $leftbox;
                            }
                            echo '</div></div>';
                            echo '<article class="post-entry ym-col3">';
                            echo '<div class="ym-cbox';
                            if ($usefloating == 0) {
                                echo ' ym-clearfix';
                            }
                            echo '">';
                        } else {
                            echo '<article class="post-entry ym-cbox">';
                        }
                        if ($titleup == 0) {
                            ?>       
                            <header class="post-title"><h2>          
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_title(); ?>
                                    </a>
                                </h2></header>
                            <?php
                        }

                        if (($showdatebox != 0) && ($showdateline == 1)) {
                            ?>
                            <p class="pubdateinfo"><?php piratenkleider_post_pubdateinfo(0); ?></p>	  	  
                            <?php
                        }

                        echo get_piratenkleider_custom_excerpt($teaserlength);
                        ?>     
                        <?php
                        if ($showdatebox < 5) {
                            ?>  
                        </div>    	
                        <div class="ym-ie-clearing">&nbsp;</div>	
                    <?php } ?>
                    </article>
                    <?php
                    if ($titleup == 1) {
                        echo '</div>';
                    }
                    echo '</section>';
                }

// endfunction
            } //endif function exists

            if (!function_exists('piratenkleider_post_datumsbox')) {

                /**
                 * Erstellung der Datumsbox
                 */
                function piratenkleider_post_datumsbox() {
                    global $options;
                    echo '<div class="post-info">';
                    $num_comments = get_comments_number();
                    if (($num_comments > 0) || ( $options['zeige_commentbubble_null'])) {
                        ?>
                        <div class="commentbubble"> 
                            <?php
                            if ($num_comments > 0) {
                                comments_popup_link('0<span class="skip"> ' . __('Kommentare', 'piratenkleider') . '</span>', '1<span class="skip"> ' . __('Kommentar', 'piratenkleider') . '</span>', '%<span class="skip"> ' . __('Kommentare', 'piratenkleider') . '</span>', 'comments-link', '%<span class="skip"> ' . __('Kommentare', 'piratenkleider') . '</span>');
                            } else {
                                // Wenn der Zeitraum abgelaufen ist UND keine Kommentare gegeben waren, dann
                                // liefert die Funktion keinen Link, sondern nur den Text . Daher dieser
                                // Woraround:
                                $link = get_comments_link();
                                echo '<a href="' . $link . '">0<span class="skip"> Kommentar</span></a>';
                            }
                            ?>
                        </div> 
                    <?php } ?>

                    <div class="cal-icon">
                        <span class="day"><?php the_time('j.'); ?></span>
                        <span class="month"><?php the_time('m.'); ?></span>
                        <span class="year"><?php the_time('Y'); ?></span>
                    </div>
                    <?php
                    echo '</div>';
                }

            }


            if (!function_exists('piratenkleider_post_pubdateinfo')) {

                /**
                 * Fusszeile unter Artikeln: Ver&ouml;ffentlichungsdatum
                 */
                function piratenkleider_post_pubdateinfo($withtext = 1) {
                    if ($withtext == 1) {
                        echo '<span class="meta-prep">';
                        echo __('Ver&ouml;ffentlicht am', 'piratenkleider');
                        echo '</span> ';
                    }
                    printf('%1$s', sprintf('<span class="entry-date">%1$s</span>', get_the_date()
                            )
                    );
                }

            }

            if (!function_exists('piratenkleider_post_autorinfo')) {

                /**
                 * Fusszeile unter Artikeln: Autorinfo
                 */
                function piratenkleider_post_autorinfo() {
                    printf(__(' <span class="meta-prep-author">von</span> %1$s ', 'piratenkleider'), sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span> ', get_author_posts_url(get_the_author_meta('ID')), sprintf(esc_attr__('Artikel von %s', 'piratenkleider'), get_the_author()), get_the_author()
                            )
                    );
                }

            }

            if (!function_exists('piratenkleider_post_taxonominfo')) {

                /**
                 * Fusszeile unter Artikeln: Taxonomie
                 */
                function piratenkleider_post_taxonominfo() {
                    $tag_list = get_the_tag_list('', ', ');
                    if ($tag_list) {
                        $posted_in = __('unter %1$s und tagged %2$s. <br>Hier der permanente <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Link</a> zu diesem Artikel.', 'piratenkleider');
                    } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
                        $posted_in = __('unter %1$s. <br><a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permanenter Link</a> zu diesem Artikel.', 'piratenkleider');
                    } else {
                        $posted_in = __('<a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permanenter Link</a> zu diesem Artikel.', 'piratenkleider');
                    }
                    // Prints the string, replacing the placeholders.
                    printf(
                            ' ' . $posted_in, get_the_category_list(', '), $tag_list, get_permalink(), the_title_attribute('echo=0')
                    );
                }

            }

// this function initializes the iframe elements 
// maybe wont work on multisite installations. please use plugins instead.
            function piratenkleider_change_mce_options($initArray) {
                $ext = 'iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';
                if (isset($initArray['extended_valid_elements'])) {
                    $initArray['extended_valid_elements'] .= ',' . $ext;
                } else {
                    $initArray['extended_valid_elements'] = $ext;
                }
                // maybe; set tiny paramter verify_html
                $initArray['verify_html'] = false;
                return $initArray;
            }

            add_filter('tiny_mce_before_init', 'piratenkleider_change_mce_options');

            class My_Walker_Nav_Menu extends Walker_Nav_Menu {

                public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
                    if ('-' === $item->title) {
                        $output .= '<li class="menu_separator"><hr>';
                    } else {
                        parent::start_el($output, $item, $depth, $args, $id);
                    }
                }

                public function display_element($el, &$children, $max_depth, $depth = 0, $args = array(), &$output) {
                    $id = $this->db_fields['id'];
                    if (isset($children[$el->$id]))
                        $el->classes[] = 'has_children';

                    parent::display_element($el, $children, $max_depth, $depth, $args, $output);
                }

            }

            if (!function_exists('get_piratenkleider_socialmediaicons')) {

                /**
                 * Displays Social Media Icons
                 */
                function get_piratenkleider_socialmediaicons($darstellung = 1) {
                    global $options;
                    global $default_socialmedia_liste;
                    $zeigeoption = $options['alle-socialmediabuttons'];

                    if ($darstellung == 0) {
                        /* Keine Links */
                        return;
                    }
                    if ($darstellung != $zeigeoption) {
                        /* Nichts anzeigen, da wir im falschen Modus sind */
                        return;
                    }

                    if ($zeigeoption == 2) {
                        /* Links an der Seite */
                        echo '<div id="socialmedia_iconbar">';
                    }

                    echo '<ul class="socialmedia">';
                    foreach ($default_socialmedia_liste as $entry => $listdata) {

                        $value = '';
                        $active = 0;
                        if (isset($options['sm-list'][$entry]['content'])) {
                            $value = $options['sm-list'][$entry]['content'];
                        } else {
                            $value = $default_socialmedia_liste[$entry]['content'];
                        }
                        if (isset($options['sm-list'][$entry]['active'])) {
                            $active = $options['sm-list'][$entry]['active'];
                        }
                        if (($active == 1) && ($value)) {
                            echo '<li><a class="icon_' . $entry . '" href="' . $value . '">';
                            echo $listdata['name'] . '</a></li>';
                        }
                    }
                    echo '</ul>';

                    if ($zeigeoption == 2) {
                        /* Links an der Seite */
                        echo '</div>';
                    }
                }

            }//endif;


            if (!function_exists('get_piratenkleider_seitenmenu')) {
                /*
                 * Anzeige des Sidebar-Menus
                 */

                function get_piratenkleider_seitenmenu($zeige_sidebarpagemenu = 1, $zeige_subpagesonly = 1, $seitenmenu_mode = 0) {
                    global $post;
                    $sidelinks = '';
                    if ($zeige_sidebarpagemenu == 1) {
                        if (($seitenmenu_mode == 1) || (!has_nav_menu('primary'))) {
                            if ($zeige_subpagesonly == 1) {
                                //if the post has a parent

                                if ($post->post_parent) {
                                    if ($post->ancestors) {
                                        $ancestors = end($post->ancestors);
                                        $sidelinks = wp_list_pages("title_li=&child_of=" . $ancestors . "&echo=0");
                                    } else {
                                        $sidelinks .= wp_list_pages("sort_column=menu_order&title_li=&echo=0&depth=5&child_of=" . $post->post_parent);
                                    }
                                } else {
                                    // display only main level and children
                                    $sidelinks .= wp_list_pages("sort_column=menu_order&title_li=&echo=0&depth=5&child_of=" . $post->ID);
                                }

                                if ($sidelinks) {
                                    echo '<ul class="menu">';
                                    echo $sidelinks;
                                    echo '</ul>';
                                }
                            } else {
                                echo '<ul class="menu">';
                                wp_page_menu();
                                echo '</ul>';
                            }
                        } else {
                            if ($zeige_subpagesonly == 1) {
                                wp_nav_menu(array('depth' => 0, 'container_class' => 'menu-header subpagesonly', 'theme_location' => 'primary', 'walker' => new My_Walker_Nav_Menu()));
                            } else {
                                wp_nav_menu(array('depth' => 0, 'container_class' => 'menu-header', 'theme_location' => 'primary', 'walker' => new My_Walker_Nav_Menu()));
                            }
                        }
                    }
                }

            }//endif;

            if (!function_exists('get_piratenkleider_firstpicture')) {
                /*
                 * Erstes Bild aus einem Artikel auslesen, wenn dies vorhanden ist
                 */

                function get_piratenkleider_firstpicture() {
                    global $post;
                    $first_img = '';
                    ob_start();
                    ob_end_clean();
                    $matches = array();
                    preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
                    if ((is_array($matches)) && (isset($matches[1]))) {
                        $first_img = $matches[1];
                        if (!empty($first_img)) {
                            $site_link = home_url();
                            $first_img = preg_replace("%$site_link%i", '', $first_img);
                            $imagehtml = '<img src="' . $first_img . '" alt="" >';
                            return $imagehtml;
                        }
                    }
                }

            }//endif;


            if (!function_exists('get_piratenkleider_firstvideo')) {
                /*
                 * Erstes Bild aus einem Artikel auslesen, wenn dies vorhanden ist
                 */

                function get_piratenkleider_firstvideo($width = 300, $height = 169, $nocookie = 1, $searchplain = 1) {
                    global $post;
                    ob_start();
                    ob_end_clean();
                    $matches = array();
                    preg_match('/src="([^\'"]*www\.youtube[^\'"]+)/i', $post->post_content, $matches);
                    if ((is_array($matches)) && (isset($matches[1]))) {
                        $entry = $matches[1];
                        if (!empty($entry)) {
                            if ($nocookie == 1) {
                                $entry = preg_replace('/feature=player_embedded&amp;/', '', $entry);
                                $entry = preg_replace('/feature=player_embedded&/', '', $entry);
                                $entry = preg_replace('/youtube.com\/watch\?v=/', 'youtube-nocookie.com/embed/', $entry);
                            }
                            $htmlout = '<iframe width="' . $width . '" height="' . $height . '" src="' . $entry . '" allowfullscreen="true"></iframe>';
                            return $htmlout;
                        }
                    }
                    // Schau noch nach YouTube-URLs die Plain im text sind. Hilfreich fuer
                    // Installationen auf Multisite ohne iFrame-UnterstÃ¼tzung
                    if ($searchplain == 1) {

                        preg_match('/\b(https?:\/\/www\.youtube[\-a-z]*\.com\/(watch|embed)[\/a-z0-9\.\-&;\?_=]+)/i', $post->post_content, $matches);
                        if ((is_array($matches)) && (isset($matches[1]))) {
                            $entry = $matches[1];
                            if (!empty($entry)) {
                                if ($nocookie == 1) {
                                    $entry = preg_replace('/feature=player_embedded&amp;/', '', $entry);
                                    $entry = preg_replace('/feature=player_embedded&/', '', $entry);
                                    $entry = preg_replace('/youtube.com\/watch\?v=/', 'youtube-nocookie.com/embed/', $entry);
                                }
                                $htmlout = '<iframe width="' . $width . '" height="' . $height . '" src="' . $entry . '" allowfullscreen></iframe>';
                                return $htmlout;
                            }
                        }
                    }
                }

            }//endif;



            if (!function_exists('get_piratenkleider_custom_excerpt')) {
                /*
                 * Erstellen des Extracts
                 */

                function get_piratenkleider_custom_excerpt($length = 0, $continuenextline = 1, $removeyoutube = 1, $alwayscontinuelink = 0) {
                    global $options;
                    global $post;
                    global $defaultoptions;

                    if (has_excerpt()) {
                        return get_the_excerpt();
                    } else {
                        $excerpt = get_the_content();
                        if (!isset($excerpt)) {
                            $excerpt = __('Kein Inhalt', 'piratenkleider');
                        }
                    }
                    if ($length == 0) {
                        $length = $options['teaser_maxlength'];
                        if ($length <= 0) {
                            $length = 100;
                        }
                    }
                    if ($removeyoutube == 1) {
                        $excerpt = preg_replace('/\s+(https?:\/\/www\.youtube[\/a-z0-9\.\-\?&;=_]+)/i', '', $excerpt);
                    }

                    $excerpt = strip_shortcodes($excerpt);
                    $excerpt = strip_tags($excerpt, $defaultoptions['excerpt_allowtags']);


                    if (mb_strlen($excerpt) < 5) {
                        $excerpt = '<!-- ' . __('Kein textueller Inhalt', 'piratenkleider') . ' -->';
                    }

                    $needcontinue = 0;
                    if (mb_strlen($excerpt) > $length) {
                        $the_str = mb_substr($excerpt, 0, $length);
                        $the_str .= "...";
                        $needcontinue = 1;
                    } else {
                        $the_str = $excerpt;
                    }
                    $the_str = '<p>' . $the_str;
                    if (isset($options['continuelink']) && ($options['continuelink'] != $alwayscontinuelink)) {
                        $alwayscontinuelink = $options['continuelink'];
                    }
                    if ($alwayscontinuelink < 2) {
                        if (($needcontinue == 1) || ($alwayscontinuelink == 1)) {
                            if ($continuenextline == 1) {
                                $the_str .= '<br>';
                            }
                            $the_str .= piratenkleider_continue_reading_link();
                        }
                    }
                    $the_str .= '</p>';
                    return $the_str;
                }

            }//endif;

            if (!function_exists('short_title')) {
                /*
                 * Erstellen des Kurztitels
                 */

                function short_title($after = '...', $length = 6, $textlen = 10) {
                    $thistitle = get_the_title();
                    $mytitle = explode(' ', get_the_title());
                    if ((count($mytitle) > $length) || (mb_strlen($thistitle) > $textlen)) {
                        while (((count($mytitle) > $length) || (mb_strlen($thistitle) > $textlen)) && (count($mytitle) > 1)) {
                            array_pop($mytitle);
                            $thistitle = implode(" ", $mytitle);
                        }
                        $morewords = 1;
                    } else {
                        $morewords = 0;
                    }
                    if (mb_strlen($thistitle) > $textlen) {
                        $thistitle = mb_substr($thistitle, 0, $textlen);
                        $morewords = 1;
                    }
                    if ($morewords == 1) {
                        $thistitle .= $after;
                    }
                    return $thistitle;
                }

            }//endif;

            if (!function_exists('piratenkleider_fetch_feed')) {
                /*
                 * Feet holen mit direkter Angabe der SimplePie-Parameter
                 */

                function piratenkleider_fetch_feed($url, $lifetime = 0) {
                    global $defaultoptions;
                    global $options;


                    if ($lifetime == 0) {
                        $lifetime = $options['feed_cache_lifetime'];
                    }
                    if ($lifetime < 600)
                        $lifetime = 1800;
                    // Das holen von feeds sollte auf keinen Fall haeufiger als alle 10 Minuten erfolgen

                    require_once (ABSPATH . WPINC . '/class-feed.php');

                    $feed = new SimplePie();
                    if ($defaultoptions['use_wp_feed_defaults']) {
                        $feed->set_cache_class('WP_Feed_Cache');
                        $feed->set_file_class('WP_SimplePie_File');
                    } else {
                        if ((isset($defaultoptions['dir_feed_cache'])) && (!empty($defaultoptions['dir_feed_cache']))) {
                            if (is_dir($defaultoptions['dir_feed_cache'])) {
                                $feed->set_cache_location($defaultoptions['dir_feed_cache']);
                            } else {
                                mkdir($defaultoptions['dir_feed_cache']);
                                if (!is_dir($defaultoptions['dir_feed_cache'])) {
                                    echo "Wasnt able to create Feed-Cache directory";
                                } else {
                                    $feed->set_cache_location($defaultoptions['dir_feed_cache']);
                                }
                            }
                        }
                    }
                    $feed->set_feed_url($url);
                    $feed->set_cache_duration($lifetime);

                    do_action_ref_array('wp_feed_options', array($feed, $url));
                    $feed->init();
                    $feed->handle_content_type();

                    if ($feed->error())
                        return new WP_Error('simplepie-error', $feed->error());

                    return $feed;
                }

            }//endif;

            function wpi_linkexternclass($content) {
                return preg_replace_callback('/<a[^>]+/', 'wpi_linkexternclass_callback', $content);
            }

            function wpi_linkexternclass_callback($matches) {
                $link = $matches[0];
                $site_link = home_url();
                if ((strpos($link, 'class') === false) && (strpos($link, 'mailto:') === false) && (strpos($link, 'http') > 0) && (strpos($link, $site_link) === false)) {
                    $link = preg_replace("%(href=\S(?!($site_link|#)))%i", 'class="extern" $1', $link);
                }
                return $link;
            }

            add_filter('the_content', 'wpi_linkexternclass');

            function wpi_relativeurl($content) {
                return preg_replace_callback('/<a[^>]+/', 'wpi_relativeurl_callback', $content);
            }

            function wpi_relativeurl_callback($matches) {
                $link = $matches[0];
                $site_link = wp_make_link_relative(home_url());
                $link = preg_replace("%href=\"$site_link%i", 'href="', $link);
                return $link;
            }

            add_filter('the_content', 'wpi_relativeurl');

            function piratenkleider_breadcrumb() {
                global $defaultoptions;

                $delimiter = $defaultoptions['breadcrumb_delimiter']; // = ' / ';
                $home = $defaultoptions['breadcrumb_homelinktext']; // __( 'Startseite', 'piratenkleider' ); // text for the 'Home' link
                $before = $defaultoptions['breadcrumb_beforehtml']; // '<span class="current">'; // tag before the current crumb
                $after = $defaultoptions['breadcrumb_afterhtml']; // '</span>'; // tag after the current crumb

                echo '<div id="crumbs">';
                if (!is_home() && !is_front_page() || is_paged()) {

                    global $post;

                    $homeLink = home_url('/');
                    echo '<a href="' . $homeLink . '">' . $home . '</a>' . $delimiter;

                    if (is_category()) {
                        global $wp_query;
                        $cat_obj = $wp_query->get_queried_object();
                        $thisCat = $cat_obj->term_id;
                        $thisCat = get_category($thisCat);
                        $parentCat = get_category($thisCat->parent);
                        if ($thisCat->parent != 0)
                            echo(get_category_parents($parentCat, TRUE, $delimiter));
                        echo $before . __('Artikel der Kategorie ', 'piratenkleider') . '"' . single_cat_title('', false) . '"' . $after;
                    } elseif (is_buddypress()) {
                        $parent_id = $post->post_parent;
                        $breadcrumbs = array();
                        while ($parent_id) {
                            $page = get_page($parent_id);
                            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                            $parent_id = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse($breadcrumbs);
                        foreach ($breadcrumbs as $crumb)
                            echo $crumb . $delimiter;
                        echo $before . get_the_title() . $after;
                    } elseif (is_bbpress()) {
                        echo '<a href="' . $homeLink . '/participa">Participa</a> ' . $delimiter;
                        echo '<a href="' . $homeLink . '/participa/discussao">Discuss&atilde;o</a> ' . $delimiter;
                        $defaults = array(
                            // HTML
                            'before' => '',
                            'after' => '',
                            'sep' => '/',
                            'pad_sep' => 1,
                            // Home
                            'include_home' => false,
                            'home_text' => '$pre_front_text',
                        );
                        bbp_breadcrumb($defaults);
                    } elseif (is_day()) {
                        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $delimiter;
                        echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $delimiter;
                        echo $before . get_the_time('d') . $after;
                    } elseif (is_month()) {
                        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $delimiter;
                        echo $before . get_the_time('F') . $after;
                    } elseif (is_year()) {
                        echo $before . get_the_time('Y') . $after;
                    } elseif (is_single() && !is_attachment()) {
                        if (get_post_type() != 'post') {
                            $post_type = get_post_type_object(get_post_type());
                            $slug = $post_type->rewrite;
                            echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>' . $delimiter;
                            echo $before . get_the_title() . $after;
                        } else {
                            echo $before . get_the_title() . $after;
                        }
                    } elseif (!is_single() && !is_page() && !is_search() && get_post_type() != 'post' && !is_404()) {
                        $post_type = get_post_type_object(get_post_type());
                        echo $before . $post_type->labels->singular_name . $after;
                    } elseif (is_attachment()) {
                        $parent = get_post($post->post_parent);
                        echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>' . $delimiter;
                        echo $before . get_the_title() . $after;
                    } elseif (is_page() && !$post->post_parent) {
                        echo $before . get_the_title() . $after;
                    } elseif (is_page() && $post->post_parent) {
                        $parent_id = $post->post_parent;
                        $breadcrumbs = array();
                        while ($parent_id) {
                            $page = get_page($parent_id);
                            $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                            $parent_id = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse($breadcrumbs);
                        foreach ($breadcrumbs as $crumb)
                            echo $crumb . $delimiter;
                        echo $before . get_the_title() . $after;
                    } elseif (is_search()) {
                        echo $before . __('Suche nach ', 'piratenkleider') . '"' . get_search_query() . '"' . $after;
                    } elseif (is_tag()) {
                        echo $before . __('Artikel mit Schlagwort ', 'piratenkleider') . '"' . single_tag_title('', false) . '"' . $after;
                    } elseif (is_author()) {
                        global $author;
                        $userdata = get_userdata($author);
                        echo $before . __('Artikel von ', 'piratenkleider') . $userdata->display_name . $after;
                    } elseif (is_404()) {
                        echo $before . '404' . $after;
                    }
                    /*
                      if ( get_query_var('paged') ) {
                      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                      echo __('Page', 'piratenkleider') . ' ' . get_query_var('paged');
                      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
                      }
                     */
                } elseif (is_front_page() && $defaultoptions['zeige_breadcrump_frontpages']) {
                    echo $before . $home . $after;
                } elseif (is_home() && $defaultoptions['zeige_breadcrump_frontpages']) {
                    echo $before . get_the_title(get_option('page_for_posts')) . $after;
                }
                echo '</div>';
            }

            function piratenkleider_enqueue_styles() {
                global $defaultoptions;
                global $options;
                // Register our main stylesheet
                wp_register_style('bp-default-main', get_template_directory_uri() . '/css/buddypress.css', array(), bp_get_version());
                // Enqueue the main stylesheet
                wp_enqueue_style('bp-default-main');
                // Responsive layout
                if (current_theme_supports('bp-default-responsive')) {
                    wp_enqueue_style('bp-default-responsive', get_template_directory_uri() . '/css/responsive.css', array('bp-default-main'), bp_get_version());
                }
                /*
                  'stylefile-position':
                  0 => __('Deaktiv (Nicht einbinden)', 'piratenkleider'),
                  1 => __('Vor Standard-CSS-Dateien des Grunddesigns', 'piratenkleider'),
                  2 => __('Nach Standard-CSS-Dateien des Grunddesigns', 'piratenkleider'),
                  3 => __('Semi-Exklusiv (kein Laden des Grunddesign-CSS, jedoch optionale CSS (Farben, Schriften, Icons, ...)', 'piratenkleider'),
                  4 => __('Exklusiv (kein Laden anderer CSS-Dateien)', 'piratenkleider'),

                 */
                $userstyle = 0;
                if (!is_admin()) {
                    $userstyle = 0;
                    if ((isset($options['aktiv-stylefile']) && ($options['aktiv-stylefile'] > 0) && (wp_get_attachment_url($options['aktiv-stylefile'])) ) && (isset($options['stylefile-position'])) && ($options['stylefile-position'] > 0)) {
                        $userstyle = 1;
                    }

                    if (($userstyle == 1) && ($options['stylefile-position'] == 1)) {
                        wp_enqueue_style('stylefile', wp_get_attachment_url($options['aktiv-stylefile']));
                    }

                    if (($userstyle == 0) || (($userstyle == 1) && ($options['stylefile-position'] < 3))) {
                        if ((isset($options['aktiv-alternativestyle'])) && ($options['aktiv-alternativestyle'] != 'style.css')) {
                            wp_enqueue_style('alternativestyle', get_template_directory_uri() . '/css/' . $options['aktiv-alternativestyle']);
                        } else {
                            $theme = wp_get_theme();
                            wp_register_style('piratenkleider', get_bloginfo('stylesheet_url'), false, $theme['Version']);
                            wp_enqueue_style('piratenkleider');
                        }
                    }
                    if (($userstyle == 1) && ($options['stylefile-position'] > 1)) {
                        wp_enqueue_style('stylefile', wp_get_attachment_url($options['aktiv-stylefile']));
                    }

                    if (($userstyle == 0) || (($userstyle == 1) && ($options['stylefile-position'] != 4))) {
                        if ((isset($options['css-colorfile'])) && (strlen(trim($options['css-colorfile'])) > 1)) {
                            wp_enqueue_style('color', get_template_directory_uri() . '/css/' . $options['css-colorfile']);
                        }

                        if (!isset($options['css-fontfile'])) {
                            $options['css-fontfile'] = $defaultoptions['default-fontset-file'];
                        }
                        if ((isset($options['css-fontfile'])) && (strlen(trim($options['css-fontfile'])) > 1)) {
                            wp_enqueue_style('font', get_template_directory_uri() . '/css/' . $options['css-fontfile'], array(), false, 'all and (min-width:500px)');
                        }

                        if (isset($options['aktiv-mediaqueries-allparts']) && ($options['aktiv-mediaqueries-allparts'] == 1)) {
                            wp_enqueue_style('basemod_mediaqueries_allparts', $defaultoptions['src-basemod_mediaqueries_allparts']);
                        }

                        if (isset($options['aktiv-mediaqueries-allparts']) && ($options['aktiv-mediaqueries-allparts'] == 1)) {
                            wp_enqueue_style('basemod_mediaqueries_allparts', $defaultoptions['src-basemod_mediaqueries_allparts']);
                        }
                        if ((isset($options['aktiv-linkicons'])) && ($options['aktiv-linkicons'] == 1)) {
                            wp_enqueue_style('basemod_linkicons', $defaultoptions['src-linkicons-css']);
                        }

                        if (is_singular()) {
                            if ($options['aktiv-circleplayer'] == 1) {
                                wp_enqueue_style('circleplayer', $defaultoptions['src-circleplayer_css']);
                            }

                            $nosidebar = get_post_meta(get_the_ID(), 'piratenkleider_nosidebar', true);
                            $custom_fields = get_post_custom();
                            if ((!empty($nosidebar) && $nosidebar == 1) || ((isset($custom_fields['fullsize'])) && ($custom_fields['fullsize'][0] == true))) {
                                wp_enqueue_style('basemod_sidebarbottom', $defaultoptions['src-basemod_sidebarbottom']);
                            }
                        }
                        if ((isset($options['position_sidebarbottom'])) && ($options['position_sidebarbottom'] == 1)) {
                            wp_enqueue_style('basemod_sidebarbottom', $defaultoptions['src-basemod_sidebarbottom']);
                        }

                        wp_enqueue_style('square', get_template_directory_uri() . '/css/square.css', array(), false, 'all');
                    }
                }
            }

            add_action('wp_enqueue_scripts', 'piratenkleider_enqueue_styles');

            function piratenkleider_header_style() {
                
            }

            function piratenkleider_admin_style() {
                wp_register_style('themeadminstyle', get_template_directory_uri() . '/css/admin.css');
                wp_enqueue_style('themeadminstyle');
                wp_enqueue_media();
                wp_register_script('themeadminscripts', get_template_directory_uri() . '/js/admin.js', array('jquery'));
                wp_enqueue_script('themeadminscripts');
            }

            add_action('admin_enqueue_scripts', 'piratenkleider_admin_style');

            function custom_login() {
                echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/custom-login.css" />';
            }

            add_action('login_head', 'custom_login');

            add_filter('upload_mimes', 'custom_upload_mimes');

            function custom_upload_mimes($existing_mimes = array()) {
                $existing_mimes['css'] = 'text/plain';
                $existing_mimes['ico'] = 'image/ico';
                return $existing_mimes;
            }

            /* Circleplayer-Import
             *    von Bejamin StÃ¶cker (@EinfachBen)
             */

            function get_post_audio_enclosure($information) {
                $custom_keys = get_post_custom_keys();
                // $allowed_output = array('mp3', 'oga', 'ogg', 'mp4','m4a','ogv','m4v');
                $allowed_output = array('mp3', 'oga', 'ogg');

                if (is_array($custom_keys) && in_array('enclosure', $custom_keys)) {
                    $custom_fields = get_post_custom();
                    $enclosures = $custom_fields['enclosure'];
                    if (!isset($enclosures))
                        $enclosures = $custom_fields['_encloseme'];;

                    foreach ($enclosures as $thatValue) {
                        $encdata = explode("\n", $thatValue);
                        $extension = pathinfo($encdata[0], PATHINFO_EXTENSION);
                        // $len = $encdata[1];
                        // $type = $encdata[2];						
                        if (in_array($extension, $allowed_output)) {
                            $information[$extension] = $encdata[0];
                        }
                        /* 			
                          if (strstr($thatValue, 'audio/ogg') != "") {
                          $ende = strpos($thatValue, ".ogg");
                          $url = substr($thatValue, 0, $ende + 4);
                          filter_var($url, FILTER_VALIDATE_URL);
                          $information['ogg'] = $url;
                          } else if (strstr($thatValue, 'audio/mpeg') != "") {
                          $ende = strpos($thatValue, ".mp3");
                          $url = substr($thatValue, 0, $ende + 4);
                          filter_var($url, FILTER_VALIDATE_URL);
                          $information['mp3'] = $url;
                          }
                         */
                    }
                }
                return $information;
            }

            function get_post_audio_fields($information) {
                $custom_fields = get_post_custom();
                if (isset($custom_fields['audio_disable']) && ($custom_fields['audio_disable'][0] == true)) {
                    $information["mp3"] = "";
                    $information["ogg"] = "";
                    $information["text"] = "";
                    return $information;
                } else {
                    if (isset($custom_fields['audio_mp3']) && (filter_var($custom_fields['audio_mp3'][0], FILTER_VALIDATE_URL)))
                        $information["mp3"] = $custom_fields['audio_mp3'][0];
                    if (isset($custom_fields['audio_ogg']) && (filter_var($custom_fields['audio_ogg'][0], FILTER_VALIDATE_URL)))
                        $information["ogg"] = $custom_fields['audio_ogg'][0];
                    if (isset($custom_fields['audio_text']) && ($custom_fields['audio_text'][0] <> ''))
                        $information["text"] = $custom_fields['audio_text'][0];
                }
                return $information;
            }

            add_filter('get_post_audio_information', 'get_post_audio_enclosure', 5);
            add_filter('get_post_audio_information', 'get_post_audio_fields', 15);

            function piratenkleider_echo_player() {
                global $options;

                if ($options['aktiv-circleplayer'] != 1) {
                    return;
                }


                $information = array('ogg' => "", 'mp3' => "", 'text' => "");
                $information = apply_filters("get_post_audio_information", $information);


                if (($options['circleplayer-require-mp3fallback'] == 1) && (!isset($information['mp3'])) && (empty($information['mp3']))) {
                    return;
                }
                if ((isset($information['mp3']) && (!empty($information['mp3']))) || (isset($information['oga']) && (!empty($information['oga']))) || (isset($information['ogg']) && (!empty($information['ogg']))) || (isset($information['mp4']) && (!empty($information['mp4']))) || (isset($information['m4a']) && (!empty($information['m4a']))) || (isset($information['m4v']) && (!empty($information['m4v']))) || (isset($information['ogv']) && (!empty($information['ogv'])))
                ) {
                    ?>

                    <div class="widget" id="AudioPlayer">
                        <h3><?php _e('Diesen Beitrag anh&ouml;ren', 'piratenkleider'); ?></h3>
                        <script type="text/javascript">
                                    //<![CDATA[
                                    $(document).ready(function() {
                                    var myCirclePlayer = new CirclePlayer("#jquery_jplayer_1",
                                    {
                            <?php
                            if (isset($information['mp3'])) {
                                echo '"mp3": "' . $information['mp3'] . '",';
                                $supplied = 'mp3,';
                            }
                            if ((isset($information['m4a'])) && (!empty($information['m4a']))) {
                                echo 'm4a: "' . $information['m4a'] . '",';
                                $supplied = $supplied . 'm4a,';
                            } else if ((isset($information['mp4'])) && (!empty($information['mp4']))) {
                                echo 'm4a: "' . $information['mp4'] . '",';
                                $supplied = $supplied . 'm4a,';
                            }
                            if ((isset($information['oga'])) && (!empty($information['oga']))) {
                                echo '"oga": "' . $information['oga'] . '",';
                                $supplied = $supplied . 'oga,';
                            } else if ((isset($information['ogg'])) && (!empty($information['ogg']))) {
                                echo '"oga": "' . $information['ogg'] . '",';
                                $supplied = $supplied . 'oga,';
                            }

                            $supplied = rtrim($supplied, ',');
                            echo "}, {";
                            echo ' cssSelectorAncestor: "#cp_container_1", swfPath: "js",
wmode: "window", supplied: "' . $supplied . '",';
                            echo '});
});
//]]>
</script>';

                            echo '<div id="jquery_jplayer_1" class="cp-jplayer"></div>';
                            echo '<div id="cp_container_1" class="cp-container">';
                            echo '<div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
<div class="cp-buffer-1"> </div> 
<div class="cp-buffer-2"> </div> 
</div>
<div class="cp-progress-holder"><!-- .cp-gt50 only needed when progress is > than 50% -->
<div class="cp-progress-1"></div>
<div class = "cp-progress-2" > </div>
</div>
<div class="cp-circle-control"></div>
<ul class="cp-controls">
<li style="padding:0;"><a class="cp-play" tabindex="1">play</a></li>
<li style="padding:0;"><a class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
</ul>
</div>';

                            _e('Download:', 'piratenkleider');
                            $links = "";
                            foreach ($information as $key => $value) {
                                if ($key == 'text') {
                                    continue;
                                }
                                $links = $links . "<a href=\"$value\">$key</a>, ";
                            }
                            $links = rtrim($links, ', ');
                            echo $links;
                            echo '<br>';
                            if (strlen(trim($information['text'])) > 2) {
                                echo $information['text'] . " <br/>";
                            }
                            echo '</div>';
                        }
                    }

                    if (!class_exists('BBP_Piratenkleider')) {

                        class BBP_Piratenkleider extends BBP_Theme_Compat {
                            /** Functions ************************************************************ */

                            /**
                             * The main bbPress (Default) Loader
                             *
                             * @since bbPress (r3732)
                             *
                             * @uses BBP_Default::setup_globals()
                             * @uses BBP_Default::setup_actions()
                             */
                            public function __construct($properties = array()) {

                                parent::__construct(bbp_parse_args($properties, array(
                                    'id' => 'default',
                                    'name' => __('bbPress Default', 'bbpress'),
                                    'version' => bbp_get_version(),
                                    'dir' => trailingslashit(bbpress()->themes_dir . 'default'),
                                    'url' => trailingslashit(bbpress()->themes_url . 'default'),
                                                ), 'default_theme'));

                                $this->setup_actions();
                            }

                            /**
                             * Setup the theme hooks
                             *
                             * @since bbPress (r3732)
                             * @access private
                             *
                             * @uses add_filter() To add various filters
                             * @uses add_action() To add various actions
                             */
                            private function setup_actions() {

                                /** Scripts ********************************************************** */
                                add_action('bbp_enqueue_scripts', array($this, 'enqueue_styles')); // Enqueue theme CSS
                                add_action('bbp_enqueue_scripts', array($this, 'enqueue_scripts')); // Enqueue theme JS
                                add_filter('bbp_enqueue_scripts', array($this, 'localize_topic_script')); // Enqueue theme script localization
                                add_filter('bbp_before_has_replies_parse_args', array($this, 'custom_bbp_has_replies'));
                                add_action('bbp_ajax_favorite', array($this, 'ajax_favorite')); // Handles the topic ajax favorite/unfavorite
                                add_action('bbp_ajax_subscription', array($this, 'ajax_subscription')); // Handles the topic ajax subscribe/unsubscribe
                                add_action('bbp_ajax_forum_subscription', array($this, 'ajax_forum_subscription')); // Handles the forum ajax subscribe/unsubscribe

                                /** Template Wrappers ************************************************ */
                                add_action('bbp_before_main_content', array($this, 'before_main_content')); // Top wrapper HTML
                                add_action('bbp_after_main_content', array($this, 'after_main_content')); // Bottom wrapper HTML

                                /** Override ********************************************************* */
                                do_action_ref_array('bbp_theme_compat_actions', array(&$this));
                            }

                            function custom_bbp_has_replies() {
                                $args['orderby'] = 'ID';
                                $args['order'] = 'ASC';
                                return $args;
                            }

                            /**
                             * Inserts HTML at the top of the main content area to be compatible with
                             * the Twenty Twelve theme.
                             *
                             * @since bbPress (r3732)
                             */
                            public function before_main_content() {
                                ?>

                                        <div id = "bbp-container">
                                                <div id = "bbp-content" role = "main">
                                <?php
                            }

                            /**
                             * Inserts HTML at the bottom of the main content area to be compatible with
                             * the Twenty Twelve theme.
                             *
                             * @since bbPress (r3732)
                             */
                            public function after_main_content() {
                                ?>

                                        </div><!-- #bbp-content -->
                                                </div><!-- #bbp-container -->

                                <?php
                            }

                            /**
                             * Load the theme CSS
                             *
                             * @since bbPress (r3732)
                             *
                             * @uses wp_enqueue_style() To enqueue the styles
                             */
                            public function enqueue_styles() {

                                // RTL and/or minified
                                $suffix = is_rtl() ? '-rtl' : '';
                                //$suffix .= defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
                                // Get and filter the bbp-default style
                                $styles = apply_filters('bbp_default_styles', array(
                                    'bbp-default' => array(
                                        'file' => 'css/bbpress' . $suffix . '.css',
                                        'dependencies' => array()
                                    )
                                ));
                                // Enqueue the styles
                                foreach ($styles as $handle => $attributes) {
                                    bbp_enqueue_style($handle, $attributes['file'], $attributes['dependencies'], $this->version, 'screen');
                                }
                            }

                            /**
                             * Enqueue the required Javascript files
                             *
                             * @since bbPress (r3732)
                             *
                             * @uses bbp_is_single_forum() To check if it's the forum page
                             * @uses bbp_is_single_topic() To check if it's the topic page
                             * @uses bbp_thread_replies() To check if threaded replies are enabled
                             * @uses bbp_is_single_user_edit() To check if it's the profile edit page
                             * @uses wp_enqueue_script() To enqueue the scripts
                             */
                            public function enqueue_scripts() {

                                // Setup scripts array
                                $scripts = array();

                                // Minified
                                $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

                                // Always pull in jQuery for TinyMCE shortcode usage
                                if (bbp_use_wp_editor()) {
                                    $scripts['bbpress-editor'] = array(
                                        'file' => 'js/editor' . $suffix . '.js',
                                        'dependencies' => array('jquery')
                                    );
                                }

                                // Forum-specific scripts
                                if (bbp_is_single_forum()) {
                                    $scripts['bbpress-forum'] = array(
                                        'file' => 'js/forum' . $suffix . '.js',
                                        'dependencies' => array('jquery')
                                    );
                                }

                                // Topic-specific scripts
                                if (bbp_is_single_topic()) {

                                    // Topic favorite/unsubscribe
                                    $scripts['bbpress-topic'] = array(
                                        'file' => 'js/topic' . $suffix . '.js',
                                        'dependencies' => array('jquery')
                                    );

                                    // Hierarchical replies
                                    if (bbp_thread_replies()) {
                                        $scripts['bbpress-reply'] = array(
                                            'file' => 'js/reply' . $suffix . '.js',
                                            'dependencies' => array('jquery')
                                        );
                                    }
                                }

                                // User Profile edit
                                if (bbp_is_single_user_edit()) {
                                    $scripts['bbpress-user'] = array(
                                        'file' => 'js/user' . $suffix . '.js',
                                        'dependencies' => array('user-query')
                                    );
                                }

                                // Filter the scripts
                                $scripts = apply_filters('bbp_default_scripts', $scripts);

                                // Enqueue the scripts
                                foreach ($scripts as $handle => $attributes) {
                                    bbp_enqueue_script($handle, $attributes['file'], $attributes['dependencies'], $this->version, 'screen');
                                }
                            }

                            /**
                             * Load localizations for topic script
                             *
                             * These localizations require information that may not be loaded even by init.
                             *
                             * @since bbPress (r3732)
                             *
                             * @uses bbp_is_single_forum() To check if it's the forum page
                             * @uses bbp_is_single_topic() To check if it's the topic page
                             * @uses is_user_logged_in() To check if user is logged in
                             * @uses bbp_get_current_user_id() To get the current user id
                             * @uses bbp_get_forum_id() To get the forum id
                             * @uses bbp_get_topic_id() To get the topic id
                             * @uses bbp_get_favorites_permalink() To get the favorites permalink
                             * @uses bbp_is_user_favorite() To check if the topic is in user's favorites
                             * @uses bbp_is_subscriptions_active() To check if the subscriptions are active
                             * @uses bbp_is_user_subscribed() To check if the user is subscribed to topic
                             * @uses bbp_get_topic_permalink() To get the topic permalink
                             * @uses wp_localize_script() To localize the script
                             */
                            public function localize_topic_script() {

                                // Single forum
                                if (bbp_is_single_forum()) {
                                    wp_localize_script('bbpress-forum', 'bbpForumJS', array(
                                        'bbp_ajaxurl' => bbp_get_ajax_url(),
                                        'generic_ajax_error' => __('Something went wrong. Refresh your browser and try again.', 'bbpress'),
                                        'is_user_logged_in' => is_user_logged_in(),
                                        'subs_nonce' => wp_create_nonce('toggle-subscription_' . get_the_ID())
                                    ));

                                    // Single topic
                                } elseif (bbp_is_single_topic()) {
                                    wp_localize_script('bbpress-topic', 'bbpTopicJS', array(
                                        'bbp_ajaxurl' => bbp_get_ajax_url(),
                                        'generic_ajax_error' => __('Something went wrong. Refresh your browser and try again.', 'bbpress'),
                                        'is_user_logged_in' => is_user_logged_in(),
                                        'fav_nonce' => wp_create_nonce('toggle-favorite_' . get_the_ID()),
                                        'subs_nonce' => wp_create_nonce('toggle-subscription_' . get_the_ID())
                                    ));
                                }
                            }

                            /**
                             * AJAX handler to Subscribe/Unsubscribe a user from a forum
                             *
                             * @since bbPress (r5155)
                             *
                             * @uses bbp_is_subscriptions_active() To check if the subscriptions are active
                             * @uses bbp_is_user_logged_in() To check if user is logged in
                             * @uses bbp_get_current_user_id() To get the current user id
                             * @uses current_user_can() To check if the current user can edit the user
                             * @uses bbp_get_forum() To get the forum
                             * @uses wp_verify_nonce() To verify the nonce
                             * @uses bbp_is_user_subscribed() To check if the forum is in user's subscriptions
                             * @uses bbp_remove_user_subscriptions() To remove the forum from user's subscriptions
                             * @uses bbp_add_user_subscriptions() To add the forum from user's subscriptions
                             * @uses bbp_ajax_response() To return JSON
                             */
                            public function ajax_forum_subscription() {

                                // Bail if subscriptions are not active
                                if (!bbp_is_subscriptions_active()) {
                                    bbp_ajax_response(false, __('Subscriptions are no longer active.', 'bbpress'), 300);
                                }

                                // Bail if user is not logged in
                                if (!is_user_logged_in()) {
                                    bbp_ajax_response(false, __('Please login to subscribe to this forum.', 'bbpress'), 301);
                                }

                                // Get user and forum data
                                $user_id = bbp_get_current_user_id();
                                $id = intval($_POST['id']);

                                // Bail if user cannot add favorites for this user
                                if (!current_user_can('edit_user', $user_id)) {
                                    bbp_ajax_response(false, __('You do not have permission to do this.', 'bbpress'), 302);
                                }

                                // Get the forum
                                $forum = bbp_get_forum($id);

                                // Bail if forum cannot be found
                                if (empty($forum)) {
                                    bbp_ajax_response(false, __('The forum could not be found.', 'bbpress'), 303);
                                }

                                // Bail if user did not take this action
                                if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'toggle-subscription_' . $forum->ID)) {
                                    bbp_ajax_response(false, __('Are you sure you meant to do that?', 'bbpress'), 304);
                                }

                                // Take action
                                $status = bbp_is_user_subscribed($user_id, $forum->ID) ? bbp_remove_user_subscription($user_id, $forum->ID) : bbp_add_user_subscription($user_id, $forum->ID);

                                // Bail if action failed
                                if (empty($status)) {
                                    bbp_ajax_response(false, __('The request was unsuccessful. Please try again.', 'bbpress'), 305);
                                }

                                // Put subscription attributes in convenient array
                                $attrs = array(
                                    'forum_id' => $forum->ID,
                                    'user_id' => $user_id
                                );

                                // Action succeeded
                                bbp_ajax_response(true, bbp_get_forum_subscription_link($attrs, $user_id, false), 200);
                            }

                            /**
                             * AJAX handler to add or remove a topic from a user's favorites
                             *
                             * @since bbPress (r3732)
                             *
                             * @uses bbp_is_favorites_active() To check if favorites are active
                             * @uses bbp_is_user_logged_in() To check if user is logged in
                             * @uses bbp_get_current_user_id() To get the current user id
                             * @uses current_user_can() To check if the current user can edit the user
                             * @uses bbp_get_topic() To get the topic
                             * @uses wp_verify_nonce() To verify the nonce & check the referer
                             * @uses bbp_is_user_favorite() To check if the topic is user's favorite
                             * @uses bbp_remove_user_favorite() To remove the topic from user's favorites
                             * @uses bbp_add_user_favorite() To add the topic from user's favorites
                             * @uses bbp_ajax_response() To return JSON
                             */
                            public function ajax_favorite() {

                                // Bail if favorites are not active
                                if (!bbp_is_favorites_active()) {
                                    bbp_ajax_response(false, __('Favorites are no longer active.', 'bbpress'), 300);
                                }

                                // Bail if user is not logged in
                                if (!is_user_logged_in()) {
                                    bbp_ajax_response(false, __('Please login to make this topic a favorite.', 'bbpress'), 301);
                                }

                                // Get user and topic data
                                $user_id = bbp_get_current_user_id();
                                $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;

                                // Bail if user cannot add favorites for this user
                                if (!current_user_can('edit_user', $user_id)) {
                                    bbp_ajax_response(false, __('You do not have permission to do this.', 'bbpress'), 302);
                                }

                                // Get the topic
                                $topic = bbp_get_topic($id);

                                // Bail if topic cannot be found
                                if (empty($topic)) {
                                    bbp_ajax_response(false, __('The topic could not be found.', 'bbpress'), 303);
                                }

                                // Bail if user did not take this action
                                if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'toggle-favorite_' . $topic->ID)) {
                                    bbp_ajax_response(false, __('Are you sure you meant to do that?', 'bbpress'), 304);
                                }

                                // Take action
                                $status = bbp_is_user_favorite($user_id, $topic->ID) ? bbp_remove_user_favorite($user_id, $topic->ID) : bbp_add_user_favorite($user_id, $topic->ID);

                                // Bail if action failed
                                if (empty($status)) {
                                    bbp_ajax_response(false, __('The request was unsuccessful. Please try again.', 'bbpress'), 305);
                                }

                                // Put subscription attributes in convenient array
                                $attrs = array(
                                    'topic_id' => $topic->ID,
                                    'user_id' => $user_id
                                );

                                // Action succeeded
                                bbp_ajax_response(true, bbp_get_user_favorites_link($attrs, $user_id, false), 200);
                            }

                            /**
                             * AJAX handler to Subscribe/Unsubscribe a user from a topic
                             *
                             * @since bbPress (r3732)
                             *
                             * @uses bbp_is_subscriptions_active() To check if the subscriptions are active
                             * @uses bbp_is_user_logged_in() To check if user is logged in
                             * @uses bbp_get_current_user_id() To get the current user id
                             * @uses current_user_can() To check if the current user can edit the user
                             * @uses bbp_get_topic() To get the topic
                             * @uses wp_verify_nonce() To verify the nonce
                             * @uses bbp_is_user_subscribed() To check if the topic is in user's subscriptions
                             * @uses bbp_remove_user_subscriptions() To remove the topic from user's subscriptions
                             * @uses bbp_add_user_subscriptions() To add the topic from user's subscriptions
                             * @uses bbp_ajax_response() To return JSON
                             */
                            public function ajax_subscription() {

                                // Bail if subscriptions are not active
                                if (!bbp_is_subscriptions_active()) {
                                    bbp_ajax_response(false, __('Subscriptions are no longer active.', 'bbpress'), 300);
                                }

                                // Bail if user is not logged in
                                if (!is_user_logged_in()) {
                                    bbp_ajax_response(false, __('Please login to subscribe to this topic.', 'bbpress'), 301);
                                }

                                // Get user and topic data
                                $user_id = bbp_get_current_user_id();
                                $id = intval($_POST['id']);

                                // Bail if user cannot add favorites for this user
                                if (!current_user_can('edit_user', $user_id)) {
                                    bbp_ajax_response(false, __('You do not have permission to do this.', 'bbpress'), 302);
                                }

                                // Get the topic
                                $topic = bbp_get_topic($id);

                                // Bail if topic cannot be found
                                if (empty($topic)) {
                                    bbp_ajax_response(false, __('The topic could not be found.', 'bbpress'), 303);
                                }

                                // Bail if user did not take this action
                                if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'toggle-subscription_' . $topic->ID)) {
                                    bbp_ajax_response(false, __('Are you sure you meant to do that?', 'bbpress'), 304);
                                }

                                // Take action
                                $status = bbp_is_user_subscribed($user_id, $topic->ID) ? bbp_remove_user_subscription($user_id, $topic->ID) : bbp_add_user_subscription($user_id, $topic->ID);

                                // Bail if action failed
                                if (empty($status)) {
                                    bbp_ajax_response(false, __('The request was unsuccessful. Please try again.', 'bbpress'), 305);
                                }

                                // Put subscription attributes in convenient array
                                $attrs = array(
                                    'topic_id' => $topic->ID,
                                    'user_id' => $user_id
                                );

                                // Action succeeded
                                bbp_ajax_response(true, bbp_get_user_subscribe_link($attrs, $user_id, false), 200);
                            }

                        }

                        new BBP_Piratenkleider();
                    }