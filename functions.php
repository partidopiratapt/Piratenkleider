<?php
/**
 * Piratenkleider Theme Optionen
 *
 * @source http://github.com/xwolfde/Piratenkleider
 * @creator xwolf
 * @version 2.14.4
 * @licence CC-BY-SA 3.0 
 */
// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain('piratenkleider', get_template_directory() . '/languages');

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if (is_readable($locale_file)) require_once( $locale_file );

require( get_template_directory() . '/inc/constants.php' );

$options = get_option('piratenkleider_theme_options');
if (!isset($options['anonymize-user']))
        $options['anonymize-user'] = $defaultoptions['anonymize-user'];


if ($options['anonymize-user'] == 1) {
    /* IP-Adresse überschreiben */
    $_SERVER["REMOTE_ADDR"] = "0.0.0.0";
    /* UA-String überschreiben */
    $_SERVER["HTTP_USER_AGENT"] = "";
    update_option('require_name_email', 0);
}

if (!isset($options['feed_cache_lifetime']))
        $options['feed_cache_lifetime'] = $defaultoptions['feed_cache_lifetime'];
if (!isset($options['twitter_cache_lifetime']))
        $options['twitter_cache_lifetime'] = $defaultoptions['twitter_cache_lifetime'];
if ($options['feed_cache_lifetime'] < 600) {
    $options['feed_cache_lifetime'] = 1800;
}
// Das holen von feeds sollte auf keinen Fall haeufiger als alle 10 Minuten erfolgen
if ($options['twitter_cache_lifetime'] > $options['feed_cache_lifetime']) {
    $options['twitter_cache_lifetime'] = $options['feed_cache_lifetime'];
}
// Twitter Feeds sollten nicht laenger warten als die allgemeine feeds
function feed_lifetime_cb() {
    global $options;
    // change the default feed cache recreation period to 2 hours
    return $options['feed_cache_lifetime'];
}
add_filter('wp_feed_cache_transient_lifetime', 'feed_lifetime_cb');


if (!isset($content_width)) $content_width = $defaultoptions['content-width'];
require_once ( get_template_directory() . '/theme-options.php' );

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action('after_setup_theme', 'piratenkleider_setup');

if (!function_exists('piratenkleider_setup')):

    function piratenkleider_setup() {
        global $defaultoptions, $bp;
        // bp_core_clear_cache();
        //bp_core_clear_member_count_caches();
        // Load the AJAX functions for the theme
        require( get_template_directory() . '/_inc/ajax.php' );
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();
        // This theme uses post thumbnails
        add_theme_support('post-thumbnails');
        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        if (!is_admin()) {
// Register buttons for the relevant component templates
// Friends button
            if (bp_is_active('friends'))
                    add_action('bp_member_header_actions',
                        'bp_add_friend_button', 5);

// Activity button
            if (bp_is_active('activity'))
                    add_action('bp_member_header_actions',
                        'bp_send_public_message_button', 20);

// Messages button
            if (bp_is_active('messages'))
                    add_action('bp_member_header_actions',
                        'bp_send_private_message_button', 20);

// Group buttons
            if (bp_is_active('groups')) {
                add_action('bp_group_header_actions', 'bp_group_join_button', 5);
                add_action('bp_group_header_actions',
                        'bp_group_new_topic_button', 20);
                add_action('bp_directory_groups_actions', 'bp_group_join_button');
            }

// Blog button
            if (bp_is_active('blogs'))
                    add_action('bp_directory_blogs_actions',
                        'bp_blogs_visit_blog_button');
        }

        /*
         * Header-Kontrolle, bis WP 3.3
         */

        define('HEADER_TEXTCOLOR', '');
        define('HEADER_IMAGE', $defaultoptions['logo']);
        define('HEADER_IMAGE_WIDTH', $defaultoptions['logo-width']); // choose any number you like here
        define('HEADER_IMAGE_HEIGHT', $defaultoptions['logo-height']); // choose any number you like here         
        define('NO_HEADER_TEXT', true);

        //add_custom_image_header('piratenkleider_header_style', 'piratenkleider_admin_header_style');

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
            // $background is the saved custom image, or the default image.
            $background = set_url_scheme(get_background_image());

            // $color is the saved custom color.
            // A default has to be specified in style.css. It will not be printed here.
            $color = get_theme_mod('background_color');

	        if ( ! $background && ! $color )
	                return;

            $style = $color ? "background-color: #$color;" : '';

            if ($background) {
                $image = " background-image: url('$background');";

                $repeat = get_theme_mod('background_repeat', 'repeat-x');
	                if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
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
            ?>
            <style type="text/css" id="custom-background-css">
                .header { <?php echo trim($style); ?> }
            </style>
            <?php
        }

        add_theme_support('custom-background', $args);


        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
                'primary' => __( 'Hauptnavigation <br />&nbsp; (Statische Seiten)', 'piratenkleider' ),
                'top' => __( 'Linkmenu <br />&nbsp; (Links zu Webportalen wie Wiki, Forum, etc)', 'piratenkleider' ),
                'sub' => __( 'Technische Navigation <br />&nbsp; (Kontakt, Impressunm, etc)', 'piratenkleider' ),
        ));

        if (!isset($options['login_errors']))
                $options['login_errors'] = $defaultoptions['login_errors'];
        if ($options['login_errors'] == 0) {
            /** Abschalten von Fehlermeldungen auf der Loginseite */
            add_filter('login_errors', create_function('$a', "return null;"));
        }
        // Enqueue the global JS - Ajax will not work without it
        wp_enqueue_script('dtheme-ajax-js',
                get_template_directory_uri() . '/_inc/global.js',
                array('jquery'), bp_get_version());

        // Add words that we need to use in JS to the end of the page so they can be translated and still used.
        $params = array(
            'my_favs' => __('My Favorites', 'buddypress'),
            'accepted' => __('Accepted', 'buddypress'),
            'rejected' => __('Rejected', 'buddypress'),
            'show_all_comments' => __('Show all comments for this thread',
                    'buddypress'),
            'show_all' => __('Show all', 'buddypress'),
            'comments' => __('comments', 'buddypress'),
            'close' => __('Close', 'buddypress'),
            'view' => __('View', 'buddypress'),
            'mark_as_fav' => __('Favorite', 'buddypress'),
            'remove_fav' => __('Remove Favorite', 'buddypress')
        );
        wp_localize_script('dtheme-ajax-js', 'BP_DTheme', $params);

        // Maybe enqueue comment reply JS
        if (is_singular() && bp_is_blog_page() && get_option('thread_comments'))
                wp_enqueue_script('comment-reply');

        /** Entfernen der Wordpressversionsnr im Header */
        remove_action('wp_head', 'wp_generator');
    }
endif;

require( get_template_directory() . '/inc/widgets.php' );

function piratenkleider_scripts() {
    global $options;
    global $defaultoptions;
    if (!isset($options['aktiv-circleplayer']))
            $options['aktiv-circleplayer'] = $defaultoptions['aktiv-circleplayer'];
    if (!isset($options['aktiv-dynamic-sidebar']))
            $options['aktiv-dynamic-sidebar'] = $defaultoptions['aktiv-dynamic-sidebar'];
    if (!isset($options['aktiv-commentreplylink']))
            $options['aktiv-commentreplylink'] = $defaultoptions['aktiv-commentreplylink'];
    if (!isset($options['category-startpageview'])) 
            $options['category-startpageview'] = $defaultoptions['category-startpageview'];  

    if  ( (($options['slider-aktiv']==1) && (is_home() || is_front_page())) 
          || (($options['slider-aktiv']==1) && is_category() && ($options['category-startpageview']==1))
	  || ($options['slider-defaultwerbeplakate']==1) 
	  || ($options['aktiv-circleplayer']==1) 	    
	  || ($options['aktiv-dynamic-sidebar']==1 ) ) {
        /* Flexslider 2.0 does not work with jQuery 1.8 yet :(  */
        wp_enqueue_script(
		'myjquery',
		$defaultoptions['src-jquery'],
		false,
                "1.7.2"
        );
    }

    wp_enqueue_script(
		'layoutjs',
		$defaultoptions['src-layoutjs'],
		array('myjquery'),
            $defaultoptions['js-version']
    );
    wp_enqueue_script(
		'yaml-focusfix',
		$defaultoptions['src-yaml-focusfix'],
		false,
            $defaultoptions['js-version']
    );


    if (is_singular() && ($options['aktiv-commentreplylink'] == 1) && get_option('thread_comments')) {
        wp_enqueue_script(
		'comment-reply',
		$defaultoptions['src-comment-reply'],
		false,
                $defaultoptions['js-version']
        );
    }


    if ($options['aktiv-dynamic-sidebar'] == 1) {
        wp_enqueue_script(
		'dynamic-sidebar',
		$defaultoptions['src-dynamic-sidebar'],
		array('myjquery'),
                $defaultoptions['js-version']
        );
    }

    if (is_singular() && ($options['aktiv-circleplayer'] == 1)) {
        wp_enqueue_script(
		'jplayer',
		$defaultoptions['src-jplayer'],
		array('myjquery'),
                $defaultoptions['js-version']
        );
        wp_enqueue_script(
		'transform2d',
		$defaultoptions['src-transform2d'],
		array('jplayer'),
                $defaultoptions['js-version']
        );
        wp_enqueue_script(
		'grab',
		$defaultoptions['src-grab'],
		array('jplayer'),
                $defaultoptions['js-version']
        );
        wp_enqueue_script(
		'csstransforms',
		$defaultoptions['src-csstransforms'],
		array('jplayer'),
                $defaultoptions['js-version']
        );
        wp_enqueue_script(
		'circleplayer',
		$defaultoptions['src-circleplayer'],
		array('jplayer'),
                $defaultoptions['js-version']
        );
    }
   
    
       
}
add_action('wp_enqueue_scripts', 'piratenkleider_scripts');

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




if (!function_exists('piratenkleider_filter_wp_title')) :
    /*
     * Sets the title
     */
    function piratenkleider_filter_wp_title($title, $separator) {
        // Don't affect wp_title() calls in feeds.
        if ( is_feed() )
                return $title;

        // The $paged global variable contains the page number of a listing of posts.
        // The $page global variable contains the page number of a single post that is paged.
        // We'll display whichever one applies, if we're not looking at the first page.
        global $paged, $page;

        if (is_search()) {
            // If we're a search, let's start over:
                $title = sprintf( __( 'Suchergebnisse f&uuml;r %s', 'piratenkleider' ), '"' . get_search_query() . '"' );
            // Add a page number if we're on page 2 or more:
            if ($paged >= 2)
                        $title .= " $separator " . sprintf( __( 'Seite %s', 'piratenkleider' ), $paged );
            // Add the site name to the end:
            $title .= " $separator " . get_bloginfo('name', 'display');
            // We're done. Let's send the new title back to wp_title():
            return $title;
        }

        // Otherwise, let's start by adding the site name to the end:
        $title .= get_bloginfo('name', 'display');

        // If we have a site description and we're on the home/front page, add the description:
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && ( is_home() || is_front_page() ))
                $title .= " $separator " . $site_description;

        // Add a page number if necessary:
        if ($paged >= 2 || $page >= 2)
                $title .= " $separator " . sprintf( __( 'Seite %s', 'piratenkleider' ), max( $paged, $page ) );

        // Return the new title to wp_title():
        return $title;
    }
endif;
add_filter('wp_title', 'piratenkleider_filter_wp_title', 10, 2);


function piratenkleider_excerpt_length($length) {
    global $defaultoptions;
    return $defaultoptions['teaser_maxlength'];
}
add_filter('excerpt_length', 'piratenkleider_excerpt_length');

function piratenkleider_continue_reading_link() {
        return ' <a class="nobr" title="'.strip_tags(get_the_title()).'" href="'. get_permalink() . '">' . __( 'Weiterlesen <span class="meta-nav">&rarr;</span>', 'piratenkleider' ) . '</a>';
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

if (!function_exists('piratenkleider_comment')) :
    /**
     * Template for comments and pingbacks.
     */
    function piratenkleider_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        global $defaultoptions;

        $options = get_option('piratenkleider_theme_options');
        if (!isset($options['aktiv-avatar']))
                $options['aktiv-avatar'] = $defaultoptions['aktiv-avatar'];
        if (!isset($options['aktiv-commentreplylink']))
                $options['aktiv-commentreplylink'] = $defaultoptions['aktiv-commentreplylink'];

        switch ($comment->comment_type) :
            case '' :
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <div id="comment-<?php comment_ID(); ?>">
                        <div class="comment-details">

                            <div class="comment-author vcard">
                    <?php if ($options['aktiv-avatar']==1) {
                                    echo '<div class="avatar">';
                        echo get_avatar( $comment, 48, $defaultoptions['src-default-avatar']); 
                                    echo '</div>';
                                }
                    printf( __( '%s <span class="says">meinte am</span>', 'piratenkleider' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); 
                                ?>
                            </div><!-- .comment-author .vcard -->
                <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em><?php _e( 'Der Kommentar wartet auf die Freischaltung.', 'piratenkleider' ); ?></em>
                                <br />
                                <?php endif; ?>

                            <div class="comment-meta commentmetadata"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                <?php
                /* translators: 1: date, 2: time */
                       printf( __( '%1$s um %2$s', 'piratenkleider' ), get_comment_date(),  get_comment_time() ); ?></a> Folgendes:<?php edit_comment_link( __( '(Edit)', 'piratenkleider' ), ' ' );
                ?>
                            </div><!-- .comment-meta .commentmetadata -->
                        </div>

                        <div class="comment-body"><?php comment_text(); ?></div>
                    <?php if ($options['aktiv-commentreplylink']) { ?>
                            <div class="reply">
                        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>                       
                            </div> <!-- .reply -->
                <?php } ?>


                    </div><!-- #comment-##  -->

                    <?php
                    break;
                case 'pingback' :
                case 'trackback' :
                    ?>
                <li class="post pingback">
                <p><?php _e( 'Pingback:', 'piratenkleider' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'piratenkleider'), ' ' ); ?></p>
                    <?php
                    break;
            endswitch;
        }
    endif;




    function piratenkleider_remove_recent_comments_style() {
        global $wp_widget_factory;
        remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
    }
    add_action('widgets_init', 'piratenkleider_remove_recent_comments_style');



    if (!function_exists('piratenkleider_post_pubdateinfo')) :
        /**
         * Fusszeile unter Artikeln: Ver&ouml;ffentlichungsdatum
         */
        function piratenkleider_post_pubdateinfo() {
        printf( __( '<span class="meta-prep">Ver&ouml;ffentlicht am</span> %1$s ', 'piratenkleider' ),
                    sprintf('<span class="entry-date">%1$s</span>',
                            get_the_date()
                    )
            );
        }
    endif;

    if (!function_exists('piratenkleider_post_autorinfo')) :
        /**
         * Fusszeile unter Artikeln: Autorinfo
         */
        function piratenkleider_post_autorinfo() {
        printf( __( '<span class="meta-prep-author">von</span> %1$s ', 'piratenkleider' ),               
                    sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span> ',
                            get_author_posts_url(get_the_author_meta('ID')),
                        sprintf( esc_attr__( 'Artikel von %s', 'piratenkleider' ), get_the_author() ),
                            get_the_author()
                    )
            );
        }
    endif;

    if (!function_exists('piratenkleider_post_taxonominfo')) :
        /**
         * Fusszeile unter Artikeln: Taxonomie
         */
        function piratenkleider_post_taxonominfo() {
            $tag_list = get_the_tag_list('', ', ');
            if ($tag_list) {
                $posted_in = __( 'unter %1$s und tagged %2$s. <br>Hier der permanente <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Link</a> zu diesem Artikel.', 'piratenkleider' );
            } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
                $posted_in = __( 'unter %1$s. <br><a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permanenter Link</a> zu diesem Artikel.', 'piratenkleider' );
            } else {
                $posted_in = __( '<a href="%3$s" title="Permalink to %4$s" rel="bookmark">Permanenter Link</a> zu diesem Artikel.', 'piratenkleider' );
            }
            // Prints the string, replacing the placeholders.
            printf(
                $posted_in,
                get_the_category_list( ', ' ),
                $tag_list,
                get_permalink(),
                the_title_attribute( 'echo=0' )
            );
        }
    endif;

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




class My_Walker_Nav_Menu extends Walker_Nav_Menu
{
        /**
         * Start the element output.
         *
         * @param  string $output Passed by reference. Used to append additional content.
         * @param  object $item   Menu item data object.
         * @param  int $depth     Depth of menu item. May be used for padding.
         * @param  array $args    Additional strings.
         * @return void
         */
        public function start_el(&$output, $item, $depth, $args) {
        if ( '-' === $item->title )
        {
                // you may remove the <hr> here and use plain CSS.
                $output .= '<li class="menu_separator"><hr>';
            } else {
                parent::start_el($output, $item, $depth, $args);
            }
        }
        /* Klasse has_children einfuegen */
    public function display_element($el, &$children, $max_depth, $depth = 0, $args, &$output){
            $id = $this->db_fields['id'];

        if(isset($children[$el->$id]))
            $el->classes[] = 'has_children';

        parent::display_element($el, $children, $max_depth, $depth, $args, $output);
        }
    }

    if (!function_exists('get_piratenkleider_socialmediaicons')) :
        /**
         * Displays Social Media Icons
         */
        function get_piratenkleider_socialmediaicons($darstellung = 1) {
            $options = get_option('piratenkleider_theme_options');
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
    if ( $options['social_facebook'] != "" ){ echo '<li class="facebook"><a href="'.$options['social_facebook'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/facebook-24x24.png" width="24" height="24" alt="Facebook"></a></li>'; }
    if ( $options['social_twitter'] != "" ){  echo '<li class="twitter"><a href="'.$options['social_twitter'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/twitter-24x24.png" width="24" height="24" alt="Twitter"></a></li>'; }				
    if ( $options['social_gplus'] != "" ){  echo '<li class="gplus"><a href="'.$options['social_gplus'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/gplus-24x24.png" width="24" height="24" alt="Google+"></a></li>'; }
    if ( $options['social_diaspora'] != "" ){  echo '<li class="diaspora"><a href="'.$options['social_diaspora'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/diaspora-24x24.png" width="24" height="24" alt="Diaspora"></a></li>'; }
    if ( $options['social_identica'] != "" ){  echo '<li class="identica"><a href="'.$options['social_identica'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/identica-24x24.png" width="24" height="24" alt="identi.ca"></a></li>'; }															
    if ( $options['social_youtube'] != "" ){  echo '<li class="youtube"><a href="'.$options['social_youtube'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/youtube-24x24.png" width="24" height="24" alt="YouTube"></a></li>'; }
    if ( $options['social_itunes'] != "" ){  echo '<li class="itunes"><a href="'.$options['social_itunes'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/itunes-24x24.png" width="24" height="24" alt="iTunes"></a></li>'; }
    if ( $options['social_flickr'] != "" ){  echo '<li class="flickr"><a href="'.$options['social_flickr'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/flickr-24x24.png" width="24" height="24" alt="flickr"></a></li>'; }	
    if ( $options['social_delicious'] != "" ){  echo '<li class="delicious"><a href="'.$options['social_delicious'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/delicious-24x24.png" width="24" height="24" alt="Delicious"></a></li>'; }
    if ( $options['social_flattr'] != "" ){  echo '<li class="flattr"><a href="'.$options['social_flattr'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/flattr-24x24.png" width="24" height="24" alt="Flattr"></a></li>'; }
    if ( $options['social_feed'] != "" ){  echo '<li class="feed"><a href="'.$options['social_feed'].'" target="blank"><img src="'.get_template_directory_uri().'/images/social-media/feed-24x24.png" width="24" height="24" alt="RSS/Atom-Feed"></a></li>'; }
            echo '</ul>';


            if ($zeigeoption == 2) {
                /* Links an der Seite */
                echo '</div>';
            }
        }
    endif;


    if (!function_exists('get_piratenkleider_seitenmenu')) :
        /*
         * Anzeige des Sidebar-Menus
         */
function get_piratenkleider_seitenmenu( $zeige_sidebarpagemenu = 1 , $zeige_subpagesonly =1 ){
            global $post;
            $sidelinks = '';
            if ($zeige_sidebarpagemenu == 1) {
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

                    if (has_nav_menu('primary')) {
                wp_nav_menu( array('depth' => 0, 'container_class' => 'menu-header', 'theme_location' => 'primary', 'walker'  => new My_Walker_Nav_Menu()) );      
                    } else {
                        echo '<ul class="menu">';
                        wp_page_menu();
                        echo '</ul>';
                    }
                }
            }

        }
    endif;

    if (!function_exists('get_piratenkleider_firstpicture')) :
        /*
         * Erstes Bild aus einem Artikel auslesen, wenn dies vorhanden ist
         */
        function get_piratenkleider_firstpicture() {
            global $post;
            $first_img = '';
            ob_start();
            ob_end_clean();
    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
            if ((is_array($matches[1])) && (isset($matches [1][0]))) {
                $first_img = $matches [1] [0];
                if (!empty($first_img)) {
                    $site_link = home_url();
                    $first_img = preg_replace("%$site_link%i", '', $first_img);
                    $imagehtml = '<img src="' . $first_img . '" alt="" width="130">';
                    return $imagehtml;
                }
            }
        }
    endif;


    if (!function_exists('get_piratenkleider_custom_excerpt')) :
        /*
         * Erstellen des Extracts
         */
        function get_piratenkleider_custom_excerpt() {
            global $defaultoptions;
            global $post;


            if (has_excerpt()) {
                return get_the_excerpt();
            } else {
                $excerpt = get_the_content();
                if (!isset($excerpt)) {
          $excerpt = __( 'Kein Inhalt', 'piratenkleider' );
                }
            }

            $excerpt = strip_shortcodes($excerpt);
            $excerpt = strip_tags($excerpt);
            if (mb_strlen($excerpt) < 5) {
      $excerpt = __( 'Kein Inhalt', 'piratenkleider' );
            }
// $excerpt =  closetags(strip_html_tags( $excerpt ));
            if (mb_strlen($excerpt) > $defaultoptions['teaser_maxlength']) {
    $the_str = mb_substr($excerpt, 0, $defaultoptions['teaser_maxlength']);
                $the_str .= "...";
            } else {
                $the_str = $excerpt;
            }
            $the_str .= piratenkleider_continue_reading_link();
            return $the_str;
        }
    endif;

    if (!function_exists('short_title')) :
        /*
         * Erstellen des Kurztitels
         */
        function short_title($after = '...', $length = 6, $textlen = 10) {
            $thistitle = get_the_title();
            $mytitle = explode(' ', get_the_title());
            if ((count($mytitle) > $length) || (mb_strlen($thistitle) > $textlen)) {
       while(((count($mytitle)>$length) || (mb_strlen($thistitle)> $textlen)) && (count($mytitle)>1)) {
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
    endif;

    if (!function_exists('piratenkleider_fetch_feed')) :
        /*
         * Feet holen mit direkter Angabe der SimplePie-Parameter
         */
        function piratenkleider_fetch_feed($url, $lifetime = 0) {
            global $defaultoptions;
            $options = get_option('piratenkleider_theme_options');


            if (!isset($options['feed_cache_lifetime']))
                    $options['feed_cache_lifetime'] = $defaultoptions['feed_cache_lifetime'];

            if ($lifetime == 0) {
                $lifetime = $options['feed_cache_lifetime'];
            }
            if ($lifetime < 600) $lifetime = 1800;
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

            do_action_ref_array('wp_feed_options', array(&$feed, $url));
            $feed->init();
            $feed->handle_content_type();

            if ($feed->error())
                    return new WP_Error('simplepie-error', $feed->error());

            return $feed;
        }
    endif;


    function wpi_linkexternclass($content) {
        return preg_replace_callback('/<a[^>]+/', 'wpi_linkexternclass_callback', $content);
    }

    function wpi_linkexternclass_callback($matches) {
        $link = $matches[0];
        $site_link = home_url();
        if ((strpos($link, 'class') === false)
           && (strpos($link, $site_link) === false)) {
            $link = preg_replace("%(href=\S(?!($site_link|#)))%i", 'class="extern" $1', $link);
        }
        return $link;
    }
    add_filter('the_content', 'wpi_linkexternclass');

    /*
     * Disabled. Will be replaced wih Wordpress HTTPS plugin.
     * Makes problems with directory based multiside installations
      add_action('template_redirect', 'rw_relative_urls');
      function rw_relative_urls() {
      // Don't do anything if:
      // - In feed
      // - In sitemap by WordPress SEO plugin
      // - Not if Wordpress HTTPS is activated

      $wphttpsactive = in_array('wordpress-https/wordpress-https.php', (array) get_option('active_plugins', array() ) );
      if ( is_feed() || get_query_var( 'sitemap' ) || $wphttpsactive )
      return;
      $filters = array(
      'post_link',
      'post_type_link',
      'page_link',
      'attachment_link',
      'get_shortlink',
      'post_type_archive_link',
      'get_pagenum_link',
      'get_comments_pagenum_link',
      'term_link',
      'search_link',
      'day_link',
      'month_link',
      'year_link',
      );
      foreach ($filters as $filter) {
      add_filter($filter, 'wp_make_link_relative');
      }
      }

     */

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


    function dimox_breadcrumbs() {
        global $defaultoptions;
        $delimiter = '/';
        $home = __('Startseite', 'piratenkleider'); // text for the 'Home' link
        $before = '<span class="current">'; // tag before the current crumb
        $after = '</span>'; // tag after the current crumb

        if (!is_home() && !is_front_page() || is_paged()) {

            echo '<div id="crumbs">';

            global $post;
            $homeLink = home_url('/');
            echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

            if (is_category()) {
                global $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . __( 'Artikel der Kategorie ', 'piratenkleider' ). '"' . single_cat_title('', false) . '"' . $after;
 
            } elseif (is_day()) {
                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
                echo $before . get_the_time('d') . $after;

            } elseif (is_month()) {
                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
                echo $before . get_the_time('F') . $after;

            } elseif (is_year()) {
                echo $before . get_the_time('Y') . $after;

            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
                    echo $before . get_the_title() . $after;
                } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo is_wp_error( $cat_parents = get_category_parents($cat, TRUE, '' . $delimiter . '') ) ? '' : $cat_parents;
                    echo $before . get_the_title() . $after;
                }

            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                echo $before . $post_type->labels->singular_name . $after;

            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo is_wp_error( $cat_parents = get_category_parents($cat, TRUE, '' . $delimiter . '') ) ? '' : $cat_parents;
                echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
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
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;

            } elseif (is_search()) {
                echo $before . __('Suche', 'piratenkleider') . '"' . get_search_query() . '"' . $after;

            } elseif (is_tag()) {
      echo $before . __( 'Artikel mit Schlagwort ', 'piratenkleider' ). '"' . single_tag_title('', false) . '"' . $after;
 
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
            echo '</div>';
        }
    }





function piratenkleider_header_style() {} 

    function piratenkleider_admin_head() {
        echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/admin.css" />';
    }
    add_action('admin_head', 'piratenkleider_admin_head');

    function custom_login() {
        echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/custom-login.css" />';
    }
    add_action('login_head', 'custom_login');



    /* Circleplayer-Import
     *    von Bejamin Stöcker (@EinfachBen)
     */

    function get_post_audio_enclosure($information) {
        $custom_keys = get_post_custom_keys();
	// $allowed_output = array('mp3', 'oga', 'ogg', 'mp4','m4a','ogv','m4v');
	$allowed_output = array('mp3', 'oga', 'ogg');
	    
        if (in_array('enclosure', $custom_keys)) {
            $custom_fields = get_post_custom();
            $enclosures = $custom_fields['enclosure'];
            if (!isset($enclosures)) $enclosures = $custom_fields['_encloseme'];;

            foreach ($enclosures as $thatValue) {
			$encdata = explode( "\n", $thatValue );
			$extension = pathinfo( $encdata[0], PATHINFO_EXTENSION );
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
	if (isset($custom_fields['audio_disable']) && ($custom_fields['audio_disable'][0] == true)){
            $information["mp3"] = "";
            $information["ogg"] = "";
            $information["text"] = "";
            return $information;
        } else {
		if (isset($custom_fields['audio_mp3']) && (filter_var($custom_fields['audio_mp3'][0], FILTER_VALIDATE_URL)))
                    $information["mp3"] = $custom_fields['audio_mp3'][0];
		if (isset($custom_fields['audio_ogg']) && (filter_var($custom_fields['audio_ogg'][0], FILTER_VALIDATE_URL)))
                    $information["ogg"] = $custom_fields['audio_ogg'][0];
		if (isset($custom_fields['audio_text']) && ($custom_fields['audio_text'][0]<>''))
                    $information["text"] = $custom_fields['audio_text'][0];
        }
        return $information;
    }

    add_filter('get_post_audio_information', 'get_post_audio_enclosure', 5);
    add_filter('get_post_audio_information', 'get_post_audio_fields', 15);

    function piratenkleider_echo_player() {
    global $options;
    global $defaultoptions;

    if (!isset($options['aktiv-circleplayer'])) 
            $options['aktiv-circleplayer'] = $defaultoptions['aktiv-circleplayer'];         
    if ($options['aktiv-circleplayer']!=1) {
	return;
    }
    if (!isset($options['circleplayer-require-mp3fallback'])) 
        $options['circleplayer-require-mp3fallback'] = $defaultoptions['circleplayer-require-mp3fallback'];  
    
        $information = array('ogg' => "", 'mp3' => "", 'text' => "");
        $information = apply_filters("get_post_audio_information", $information);

    
    if (($options['circleplayer-require-mp3fallback']==1) 
		&& (!isset($information['mp3'])) 
		&& (empty($information['mp3']))) {
	return;
    }
    if	((isset($information['mp3']) && (!empty($information['mp3'])))
	    || (isset($information['oga'])  && (!empty($information['oga'])))
	    || (isset($information['ogg'])  && (!empty($information['ogg'])))
	    || (isset($information['mp4'])  && (!empty($information['mp4'])))
	    || (isset($information['m4a'])  && (!empty($information['m4a'])))
	    || (isset($information['m4v'])  && (!empty($information['m4v'])))
	    || (isset($information['ogv']) && (!empty($information['ogv'])))
	) {	    	  
	 
            ?>
		
            <div class="widget" id="AudioPlayer">
	<h3><?php _e( 'Diesen Beitrag anh&ouml;ren', 'piratenkleider' ); ?></h3>

                <script type="text/javascript">
                    //<![CDATA[
                    $(document).ready(function() {
                        var myCirclePlayer = new CirclePlayer("#jquery_jplayer_1",
                                {
	<?php 
	    if (isset($information['mp3'])) { 
		echo '"mp3": "'.$information['mp3'].'",';
		$supplied = 'mp3,';	
	    }
	    if ((isset($information['m4a'])) && (!empty($information['m4a']))) { 		
		echo 'm4a: "'.$information['m4a'].'",';	    
		$supplied = $supplied . 'm4a,';
	    } else if ( (isset($information['mp4'])) && (!empty($information['mp4']))) { 
		echo 'm4a: "'.$information['mp4'].'",';
		$supplied = $supplied . 'm4a,';
	    } 	    
	    if ((isset($information['oga'])) && (!empty($information['oga']))) { 		
		echo '"oga": "'.$information['oga'].'",';
		$supplied = $supplied . 'oga,';
	    } else if ((isset($information['ogg'])) && (!empty($information['ogg']))) { 
		echo '"oga": "'.$information['ogg'].'",';
		$supplied = $supplied . 'oga,';
	    } 
	    
	    $supplied =rtrim($supplied,','); 
	?>	    
                                }, {
                            cssSelectorAncestor: "#cp_container_1",
                            swfPath: "js",
		wmode: "window",
		supplied: "<?php echo $supplied;?>",
                        });
                    });
                    //]]>
                </script>
                <div id="jquery_jplayer_1" class="cp-jplayer"></div>  
                <div id="cp_container_1" class="cp-container">
                    <div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
                        <div class="cp-buffer-1"></div>
                        <div class="cp-buffer-2"></div>
                    </div>
                    <div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
                        <div class="cp-progress-1"></div>
                        <div class="cp-progress-2"></div>
                    </div>
                    <div class="cp-circle-control"></div>
                    <ul class="cp-controls">
                        <li style="padding:0;"><a class="cp-play" tabindex="1">play</a></li>
                        <li style="padding:0;"><a class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
                    </ul>
                </div>
	<?php _e( 'Download:', 'piratenkleider' ); 
	$links = "";
	foreach($information as $key=>$value){
	    if ($key == 'text') { continue; }
	    $links = $links . "<a href=\"$value\">$key</a>, ";
            }
	$links =rtrim($links,', '); 
	echo $links;
            ?> 
	<br/>
	<?php if(strlen(trim($information['text']))>2) { 
	  echo $information['text']." <br/>";
	 } ?>
            </div>
            <?php
        }
    }

    /**
     * Functions of bbPress's Twenty Ten theme
     *
     * @package bbPress
     * @subpackage BBP_Twenty_Ten
     * @since Twenty Ten 1.1
     */
// Exit if accessed directly
    if (!defined('ABSPATH')) exit;

    /** Theme Setup ************************************************************** */
    if (!class_exists('BBP_Twenty_Ten')) :

        /**
         * Loads bbPress Twenty Ten Theme functionality
         *
         * Usually functions.php contains a few functions wrapped in function_exisits()
         * checks. Since bbp-twenty-ten is intended to be used both as a child theme and
         * for Theme Compatibility, we've moved everything into one convenient class
         * that can be copied or extended.
         *
         * See @link BBP_Theme_Compat() for more.
         *
         * @since bbPress (r3277)
         * @package bbPress
         * @subpackage BBP_Twenty_Ten
         */
        class BBP_Twenty_Ten extends BBP_Theme_Compat {
            /** Functions ************************************************************ */

            /**
             * The main bbPress (Twenty Ten) Loader
             *
             * @since bbPress (r3277)
             * @uses BBP_Twenty_Ten::setup_globals()
             * @uses BBP_Twenty_Ten::setup_actions()
             */
            public function __construct() {
                $this->setup_globals();
                $this->setup_actions();
            }

            /**
             * Component global variables
             *
             * @since bbPress (r2626)
             * @access private
             * @uses bbp_get_version() To get the bbPress version
             * @uses get_stylesheet_directory() To get the stylesheet path
             * @uses get_stylesheet_directory_uri() To get the stylesheet uri
             */
            private function setup_globals() {
                $bbp = bbpress();
                $this->id = 'bbp-twentyten';
                $this->name = __('Twenty Ten (bbPress)', 'bbpress');
                $this->version = bbp_get_version();
                $this->dir = trailingslashit($bbp->themes_dir . 'bbp-twentyten');
                $this->url = trailingslashit($bbp->themes_url . 'bbp-twentyten');
            }

            /**
             * Setup the theme hooks
             *
             * @since bbPress (r3277)
             * @access private
             * @uses add_filter() To add various filters
             * @uses add_action() To add various actions
             */
            private function setup_actions() {
                add_action('bbp_enqueue_scripts', array($this, 'enqueue_styles')); // Enqueue theme CSS
                add_action('bbp_enqueue_scripts',
                        array($this, 'enqueue_scripts')); // Enqueue theme JS
                add_filter('bbp_enqueue_scripts',
                        array($this, 'localize_topic_script')); // Enqueue theme script localization
                add_action('bbp_head', array($this, 'head_scripts')); // Output some extra JS in the <head>
                add_action('wp_ajax_dim-favorite', array($this, 'ajax_favorite')); // Handles the ajax favorite/unfavorite
                add_action('wp_ajax_dim-subscription',
                        array($this, 'ajax_subscription')); // Handles the ajax subscribe/unsubscribe
            }

            /**
             * Load the theme CSS
             *
             * @since bbPress (r2652)
             * @uses wp_enqueue_style() To enqueue the styles
             */
            public function enqueue_styles() {

                // Right to left
                if (is_rtl()) {

                    // TwentyTen
                    if ('twentyten' == get_template()) {
                        wp_enqueue_style('twentyten',
                                get_template_directory_uri() . '/style.css', '',
                                $this->version, 'screen');
                        wp_enqueue_style('twentyten-rtl',
                                get_template_directory_uri() . '/rtl.css',
                                'twentyten', $this->version, 'screen');
                    }

                    // bbPress specific
                    wp_enqueue_style('bbp-twentyten-bbpress',
                            $this->url . 'css/bbpress-rtl.css', 'twentyten-rtl',
                            $this->version, 'screen');

                    // Left to right
                } else {

                    // TwentyTen
                    if ('twentyten' == get_template()) {
                        wp_enqueue_style('twentyten',
                                get_template_directory_uri() . '/style.css', '',
                                $this->version, 'screen');
                    }

                    // bbPress specific
                    wp_enqueue_style('bbp-twentyten-bbpress',
                            $this->url . 'css/bbpress.css', 'twentyten',
                            $this->version, 'screen');
                }
            }

            /**
             * Enqueue the required Javascript files
             *
             * @since bbPress (r2652)
             * @uses bbp_is_single_topic() To check if it's the topic page
             * @uses get_stylesheet_directory_uri() To get the stylesheet directory uri
             * @uses bbp_is_single_user_edit() To check if it's the profile edit page
             * @uses wp_enqueue_script() To enqueue the scripts
             */
            public function enqueue_scripts() {

                if (bbp_is_single_topic())
                        wp_enqueue_script('bbp_topic',
                            $this->url . 'js/topic.js', array('wp-lists'),
                            $this->version, true);

                if (bbp_is_single_user_edit())
                        wp_enqueue_script('user-profile');
            }

            /**
             * Put some scripts in the header, like AJAX url for wp-lists
             *
             * @since bbPress (r2652)
             * @uses bbp_is_single_topic() To check if it's the topic page
             * @uses admin_url() To get the admin url
             * @uses bbp_is_single_user_edit() To check if it's the profile edit page
             */
            public function head_scripts() {
                if (bbp_is_single_topic()) :
                    ?>

                    <script type='text/javascript'>
                        /* <![CDATA[ */
                        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                        /* ]]> */
                    </script>

                <?php elseif (bbp_is_single_user_edit()) : ?>

                    <script type="text/javascript" charset="utf-8">
                        if (window.location.hash == '#password') {
                            document.getElementById('pass1').focus();
                        }
                    </script>

                    <?php
                endif;
            }

            /**
             * Load localizations for topic script
             *
             * These localizations require information that may not be loaded even by init.
             *
             * @since bbPress (r2652)
             * @uses bbp_is_single_topic() To check if it's the topic page
             * @uses is_user_logged_in() To check if user is logged in
             * @uses bbp_get_current_user_id() To get the current user id
             * @uses bbp_get_topic_id() To get the topic id
             * @uses bbp_get_favorites_permalink() To get the favorites permalink
             * @uses bbp_is_user_favorite() To check if the topic is in user's favorites
             * @uses bbp_is_subscriptions_active() To check if the subscriptions are active
             * @uses bbp_is_user_subscribed() To check if the user is subscribed to topic
             * @uses bbp_get_topic_permalink() To get the topic permalink
             * @uses wp_localize_script() To localize the script
             */
            public function localize_topic_script() {

                // Bail if not viewing a single topic
                if (!bbp_is_single_topic()) return;

                // Bail if user is not logged in
                if (!is_user_logged_in()) return;

                $user_id = bbp_get_current_user_id();

                $localizations = array(
                    'currentUserId' => $user_id,
                    'topicId' => bbp_get_topic_id(),
                );

                // Favorites
                if (bbp_is_favorites_active()) {
                    $localizations['favoritesActive'] = 1;
                    $localizations['favoritesLink'] = bbp_get_favorites_permalink($user_id);
                    $localizations['isFav'] = (int) bbp_is_user_favorite($user_id);
                    $localizations['favLinkYes'] = __('favorites', 'bbpress');
                    $localizations['favLinkNo'] = __('?', 'bbpress');
                    $localizations['favYes'] = __('This topic is one of your %favLinkYes% [%favDel%]',
                            'bbpress');
                    $localizations['favNo'] = __('%favAdd% (%favLinkNo%)',
                            'bbpress');
                    $localizations['favDel'] = __('&times;', 'bbpress');
                    $localizations['favAdd'] = __('Add this topic to your favorites',
                            'bbpress');
                } else {
                    $localizations['favoritesActive'] = 0;
                }

                // Subscriptions
                if (bbp_is_subscriptions_active()) {
                    $localizations['subsActive'] = 1;
                    $localizations['isSubscribed'] = (int) bbp_is_user_subscribed($user_id);
                    $localizations['subsSub'] = __('Subscribe', 'bbpress');
                    $localizations['subsUns'] = __('Unsubscribe', 'bbpress');
                    $localizations['subsLink'] = bbp_get_topic_permalink();
                } else {
                    $localizations['subsActive'] = 0;
                }

                wp_localize_script('bbp_topic', 'bbpTopicJS', $localizations);
            }

            /**
             * Add or remove a topic from a user's favorites
             *
             * @since bbPress (r2652)
             * @uses bbp_get_current_user_id() To get the current user id
             * @uses current_user_can() To check if the current user can edit the user
             * @uses bbp_get_topic() To get the topic
             * @uses check_ajax_referer() To verify the nonce & check the referer
             * @uses bbp_is_user_favorite() To check if the topic is user's favorite
             * @uses bbp_remove_user_favorite() To remove the topic from user's favorites
             * @uses bbp_add_user_favorite() To add the topic from user's favorites
             */
            public function ajax_favorite() {
                $user_id = bbp_get_current_user_id();
                $id = intval($_POST['id']);

                if (!current_user_can('edit_user', $user_id)) die('-1');

                if (!$topic = bbp_get_topic($id)) die('0');

                check_ajax_referer('toggle-favorite_' . $topic->ID);

                if (bbp_is_user_favorite($user_id, $topic->ID)) {
                    if (bbp_remove_user_favorite($user_id, $topic->ID)) {
                        die('1');
                    }
                } else {
                    if (bbp_add_user_favorite($user_id, $topic->ID)) {
                        die('1');
                    }
                }

                die('0');
            }

            /**
             * Subscribe/Unsubscribe a user from a topic
             *
             * @since bbPress (r2668)
             * @uses bbp_is_subscriptions_active() To check if the subscriptions are active
             * @uses bbp_get_current_user_id() To get the current user id
             * @uses current_user_can() To check if the current user can edit the user
             * @uses bbp_get_topic() To get the topic
             * @uses check_ajax_referer() To verify the nonce & check the referer
             * @uses bbp_is_user_subscribed() To check if the topic is in user's
             *                                 subscriptions
             * @uses bbp_remove_user_subscriptions() To remove the topic from user's
             *                                        subscriptions
             * @uses bbp_add_user_subscriptions() To add the topic from user's subscriptions
             */
            public function ajax_subscription() {
                if (!bbp_is_subscriptions_active()) return;

                $user_id = bbp_get_current_user_id();
                $id = intval($_POST['id']);

                if (!current_user_can('edit_user', $user_id)) die('-1');

                if (!$topic = bbp_get_topic($id)) die('0');

                check_ajax_referer('toggle-subscription_' . $topic->ID);

                if (bbp_is_user_subscribed($user_id, $topic->ID)) {
                    if (bbp_remove_user_subscription($user_id, $topic->ID)) {
                        die('1');
                    }
                } else {
                    if (bbp_add_user_subscription($user_id, $topic->ID)) {
                        die('1');
                    }
                }

                die('0');
            }

        }

        new BBP_Twenty_Ten();
endif;
