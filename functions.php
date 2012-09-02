<?php
/**
 * Piratenkleider Theme Optionen
 *
 * @source http://github.com/xwolfde/Piratenkleider
 * @creator xwolf
 * @version 2.12
 * @licence CC-BY-SA 3.0 
 */
add_theme_support( 'bbpress' );


require( get_template_directory() . '/inc/constants.php' );

$options = get_option( 'piratenkleider_theme_options' );
if (!isset($options['anonymize-user'])) 
            $options['anonymize-user'] = $defaultoptions['anonymize-user'];


if ($options['anonymize-user']==1) {
    /* IP-Adresse überschreiben */
    $_SERVER["REMOTE_ADDR"] = "0.0.0.0";
    /* UA-String überschreiben */
    $_SERVER["HTTP_USER_AGENT"] = "";
    
    update_option('require_name_email',0);
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
 function feed_lifetime_cb( ) {
            global $options;
            // change the default feed cache recreation period to 2 hours
            return $options['feed_cache_lifetime'];
}
add_filter( 'wp_feed_cache_transient_lifetime' , 'feed_lifetime_cb' );
        

if ( ! isset( $content_width ) )   $content_width = $defaultoptions['content-width'];
require_once ( get_template_directory() . '/theme-options.php' );

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'piratenkleider_setup' );

if ( ! function_exists( 'piratenkleider_setup' ) ):

function piratenkleider_setup() {
     global $defaultoptions;
        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        // This theme uses post thumbnails
        add_theme_support( 'post-thumbnails' );

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        
        /* 
         * Header-Kontrolle, bis WP 3.3
         */ 
     
        define('HEADER_TEXTCOLOR', '');
        define('HEADER_IMAGE', $defaultoptions['logo']); 
        define('HEADER_IMAGE_WIDTH',  $defaultoptions['logo-width'] ); // choose any number you like here
        define('HEADER_IMAGE_HEIGHT', $defaultoptions['logo-height'] ); // choose any number you like here         
        define('NO_HEADER_TEXT', true );
    
        //add_custom_image_header('piratenkleider_header_style', 'piratenkleider_admin_header_style');
        
        /* Folgendes erst ab WP 3.4:
         * Ich warte aber noch etwas ab, da einige Leute noch 3.3 einsetzen
         * */
            $args = array(
            'width'         => 279,
              'height'        => 88,
            'default-image' => get_template_directory_uri() . '/images/logo.png',
            'uploads'       => true,
               'random-default' => true,
                'flex-height' => true,
                'suggested-height' => 90,
                'flex-width' => true,
                'max-width' => 350,
                'suggested-width' => 300,
                
            );
            add_theme_support( 'custom-header', $args );
             
        
        
        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain( 'piratenkleider', get_template_directory() . '/languages' );

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if ( is_readable( $locale_file ) )
                require_once( $locale_file );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
                'primary' => __( 'Hauptnavigation <br />&nbsp; (Statische Seiten)', 'piratenkleider' ),
                'top' => __( 'Linkmenu <br />&nbsp; (Links zu Webportalen wie Wiki, Forum, etc)', 'piratenkleider' ),
                'sub' => __( 'Technische Navigation <br />&nbsp; (Kontakt, Impressunm, etc)', 'piratenkleider' ),
        ) );

        
        /** Abschalten von Fehlermeldungen auf der Loginseite */      
        // add_filter('login_errors', create_function('$a', "return null;"));
        
        
        /** Entfernen der Wordpressversionsnr im Header */
        remove_action('wp_head', 'wp_generator');
}
endif;

require( get_template_directory() . '/inc/widgets.php' );


function piratenkleider_avatar ($avatar_defaults) {
    global $defaultoptions;
    $myavatar =  $defaultoptions['src-default-avatar']; 
    $avatar_defaults[$myavatar] = "Piratenkleider";
    return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'piratenkleider_avatar' );

if ( ! function_exists( 'piratenkleider_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 */
function piratenkleider_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
        border-bottom: 1px solid #000;
        border-top: 4px solid #000;
        background-repeat: no-repeat;
}
</style>
<?php
}
endif;

if ( ! function_exists( 'piratenkleider_filter_wp_title' ) ) :   
/*
 * Sets the title
 */
function piratenkleider_filter_wp_title( $title, $separator ) {
        // Don't affect wp_title() calls in feeds.
        if ( is_feed() )
                return $title;

        // The $paged global variable contains the page number of a listing of posts.
        // The $page global variable contains the page number of a single post that is paged.
        // We'll display whichever one applies, if we're not looking at the first page.
        global $paged, $page;

        if ( is_search() ) {
                // If we're a search, let's start over:
                $title = sprintf( __( 'Suchergebnisse f&uuml;r %s', 'piratenkleider' ), '"' . get_search_query() . '"' );
                // Add a page number if we're on page 2 or more:
                if ( $paged >= 2 )
                        $title .= " $separator " . sprintf( __( 'Seite %s', 'piratenkleider' ), $paged );
                // Add the site name to the end:
                $title .= " $separator " . get_bloginfo( 'name', 'display' );
                // We're done. Let's send the new title back to wp_title():
                return $title;
        }

        // Otherwise, let's start by adding the site name to the end:
        $title .= get_bloginfo( 'name', 'display' );

        // If we have a site description and we're on the home/front page, add the description:
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
                $title .= " $separator " . $site_description;

        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 )
                $title .= " $separator " . sprintf( __( 'Seite %s', 'piratenkleider' ), max( $paged, $page ) );

        // Return the new title to wp_title():
        return $title;
}
endif;
add_filter( 'wp_title', 'piratenkleider_filter_wp_title', 10, 2 );


function piratenkleider_excerpt_length( $length ) {
        return $defaultoptions['teaser_maxlength'];
}
add_filter( 'excerpt_length', 'piratenkleider_excerpt_length' );

function piratenkleider_continue_reading_link() {
        return ' <a title="'.strip_tags(get_the_title()).'" href="'. get_permalink() . '">' . __( 'Weiterlesen <span class="meta-nav">&rarr;</span>', 'piratenkleider' ) . '</a>';
}

function piratenkleider_auto_excerpt_more( $more ) {
        return ' &hellip;' . piratenkleider_continue_reading_link();
}
add_filter( 'excerpt_more', 'piratenkleider_auto_excerpt_more' );


function piratenkleider_custom_excerpt_more( $output ) {
       if ( has_excerpt() && ! is_attachment() ) {      
                $output .= piratenkleider_continue_reading_link();
        }
        return $output;
}
add_filter( 'get_the_excerpt', 'piratenkleider_custom_excerpt_more' );



function piratenkleider_remove_gallery_css( $css ) {
        return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'piratenkleider_remove_gallery_css' );


function honor_ssl_for_attachments($url) {
	$http = site_url(FALSE, 'http');
	$https = site_url(FALSE, 'https');
        return is_ssl() ? str_replace($http, $https, $url) : $url;
}
add_filter('wp_get_attachment_url', 'honor_ssl_for_attachments');

if ( ! function_exists( 'piratenkleider_comment' ) ) :
/**
 * Template for comments and pingbacks.
 */
function piratenkleider_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        global $defaultoptions;
        
         $options = get_option( 'piratenkleider_theme_options' );  
         if (!isset($options['aktiv-avatar'])) 
            $options['aktiv-avatar'] = $defaultoptions['aktiv-avatar'];
        if (!isset($options['aktiv-commentreplylink'])) 
            $options['aktiv-commentreplylink'] = $defaultoptions['aktiv-commentreplylink'];
        
        switch ( $comment->comment_type ) :
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

                <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
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
                case 'pingback'  :
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
add_action( 'widgets_init', 'piratenkleider_remove_recent_comments_style' );



if ( ! function_exists( 'piratenkleider_post_pubdateinfo' ) ) :
/**
 * Fusszeile unter Artikeln: Ver&ouml;ffentlichungsdatum
 */
function piratenkleider_post_pubdateinfo() {
        printf( __( '<span class="meta-prep">Ver&ouml;ffentlicht am</span> %1$s ', 'piratenkleider' ),
                sprintf( '<span class="entry-date">%1$s</span>',
                        get_the_date()
                )
        );
}
endif;

if ( ! function_exists( 'piratenkleider_post_autorinfo' ) ) :
/**
 * Fusszeile unter Artikeln: Autorinfo
 */
function piratenkleider_post_autorinfo() {
        printf( __( '<span class="meta-prep-author">von</span> %1$s ', 'piratenkleider' ),               
                sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span> ',
                        get_author_posts_url( get_the_author_meta( 'ID' ) ),
                        sprintf( esc_attr__( 'Artikel von %s', 'piratenkleider' ), get_the_author() ),
                        get_the_author()
                )
        );
}
endif;

if ( ! function_exists( 'piratenkleider_post_taxonominfo' ) ) :
/**
 * Fusszeile unter Artikeln: Taxonomie
 */
function piratenkleider_post_taxonominfo() {
         $tag_list = get_the_tag_list( '', ', ' );
        if ( $tag_list ) {
                $posted_in = __( 'unter %1$s und tagged %2$s. <br>Hier der permanente <a href="%3$s" title="Permalink to %4$s" rel="bookmark">Link</a> zu diesem Artikel.', 'piratenkleider' );
        } elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
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


add_theme_support( 'post-thumbnails' );



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
    public function start_el( &$output, $item, $depth, $args ) {
        if ( '-' === $item->title )
        {
            // you may remove the <hr> here and use plain CSS.
            $output .= '<li class="menu_separator"><hr>';
        } else{
            parent::start_el( $output, $item, $depth, $args );
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

if ( ! function_exists( 'get_piratenkleider_socialmediaicons' ) ) :
/**
     * Displays Social Media Icons
     */
function get_piratenkleider_socialmediaicons( $darstellung = 1 ){
    $options = get_option( 'piratenkleider_theme_options' ); 
    $zeigeoption = $options['alle-socialmediabuttons'];
    
    if ($darstellung ==0) {
        /* Keine Links */
        return; 
    }
   if ($darstellung!=$zeigeoption) {
        /* Nichts anzeigen, da wir im falschen Modus sind */
       return;
   }
    if ($zeigeoption==2) {    
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
       
        
    if ($zeigeoption==2) {    
           /* Links an der Seite */
            echo '</div>';
    }
}
endif;


if ( ! function_exists( 'get_piratenkleider_seitenmenu' ) ) :
/*
 * Anzeige des Sidebar-Menus
 */
function get_piratenkleider_seitenmenu( $zeige_sidebarpagemenu = 1 , $zeige_subpagesonly =1 ){
  global $defaultoptions;
  global $post;
  
    if ($zeige_sidebarpagemenu==1) {   
        if ($zeige_subpagesonly==1) {
            //if the post has a parent

            if($post->post_parent){
               if($post->ancestors) {
                    $ancestors = end($post->ancestors);
                    $sidelinks = wp_list_pages("title_li=&child_of=".$ancestors."&echo=0");
                } else {                
                    $sidelinks .= wp_list_pages("sort_column=menu_order&title_li=&echo=0&depth=5&child_of=".$post->post_parent);              
                } 
            }else{
                // display only main level and children
                $sidelinks .= wp_list_pages("sort_column=menu_order&title_li=&echo=0&depth=5&child_of=".$post->ID);
            }

            if ($sidelinks) { 
                echo '<ul class="menu">';                   
                echo $sidelinks; 
                echo '</ul>';         
            } 

        } else {

            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array('depth' => 0, 'container_class' => 'menu-header', 'theme_location' => 'primary', 'walker'  => new My_Walker_Nav_Menu()) );      
            } else { 
                echo '<ul class="menu">';   
                    wp_page_menu( ); 
                echo '</ul>';                        
            } 
        }
    }
  
}
endif;


if ( ! function_exists( 'get_piratenkleider_custom_excerpt' ) ) :
/*
 * Erstellen des Extracts
 */
function get_piratenkleider_custom_excerpt( ){
  global $defaultoptions;
  global $post;
  
 
  if (has_excerpt()) {
      return  get_the_excerpt();
  } else {
      $excerpt = get_the_content();
       if (!isset($excerpt)) {
          $excerpt = 'Sem conte&uacute;do';
        }
  }
  
  $excerpt = strip_shortcodes($excerpt);
  $excerpt = strip_tags($excerpt); 
  if (mb_strlen($excerpt)<5) {
      $excerpt = 'Sem conte&uacute;do';
  }
// $excerpt =  closetags(strip_html_tags( $excerpt ));
  if (mb_strlen($excerpt) >  $defaultoptions['teaser_maxlength']) {
    $the_str = mb_substr($excerpt, 0, $defaultoptions['teaser_maxlength']);
    $the_str .= "...";
  }  else {
      $the_str = $excerpt;
  }
  $the_str .= piratenkleider_continue_reading_link();
  return $the_str;
}
endif;

if ( ! function_exists( 'short_title' ) ) :
/*
 * Erstellen des Kurztitels
 */
function short_title($after = '...', $length = 6, $textlen = 10) {
   $thistitle =   get_the_title();  
   $mytitle = explode(' ', get_the_title());
   if ((count($mytitle)>$length) || (mb_strlen($thistitle)> $textlen)) {
       while(((count($mytitle)>$length) || (mb_strlen($thistitle)> $textlen)) && (count($mytitle)>1)) {
           array_pop($mytitle);
           $thistitle = implode(" ",$mytitle);           
       }       
      $morewords = 1;
   } else {       
       $morewords = 0;
   }
   if (mb_strlen($thistitle)> $textlen) {
      $thistitle = mb_substr($thistitle, 0, $textlen);
      $morewords = 1;     
   }
   if ($morewords==1) {
       $thistitle .= $after;
   }   
   return $thistitle;
}
endif;

if ( ! function_exists( 'piratenkleider_fetch_feed' ) ) :
/*
 * Feet holen mit direkter Angabe der SimplePie-Parameter
 */
function piratenkleider_fetch_feed($url,$lifetime=0) {
    global $defaultoptions;
    $options = get_option( 'piratenkleider_theme_options' );
    
 
    if (!isset($options['feed_cache_lifetime'])) 
                $options['feed_cache_lifetime'] = $defaultoptions['feed_cache_lifetime'];

    if ($lifetime==0){
        $lifetime=  $options['feed_cache_lifetime'];
    }
    if ($lifetime < 600) $lifetime = 1800;
    // Das holen von feeds sollte auf keinen Fall haeufiger als alle 10 Minuten erfolgen

    require_once  (ABSPATH . WPINC . '/class-feed.php');

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
    
    do_action_ref_array( 'wp_feed_options', array( &$feed, $url ) );
    $feed->init();
    $feed->handle_content_type();

    if ( $feed->error() )
        return new WP_Error('simplepie-error', $feed->error());

    return $feed;
}
endif;


function wpi_linkexternclass($content) {
        return preg_replace_callback('/<a[^>]+/', 'wpi_linkexternclass_callback', $content);
    }
 
function wpi_linkexternclass_callback($matches)
    {
        $link = $matches[0];
        $site_link = home_url();  
 
            if (strpos($link, 'class') === false)
            {
                $link = preg_replace("%(href=\S(?!$site_link))%i", 'class="extern" $1', $link);
            }       
        return $link;
    }
add_filter('the_content', 'wpi_linkexternclass');


add_action( 'template_redirect', 'rw_relative_urls' );
    function rw_relative_urls() {
        // Don't do anything if:
        // - In feed
        // - In sitemap by WordPress SEO plugin
        if ( is_feed() || get_query_var( 'sitemap' ) )
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
        foreach ( $filters as $filter ) {
         add_filter( $filter, 'wp_make_link_relative' );
        }
    }

 function wpi_relativeurl($content){
        return preg_replace_callback('/<a[^>]+/', 'wpi_relativeurl_callback', $content);
    }
 
function wpi_relativeurl_callback($matches) {

        $link = $matches[0];
        $site_link =  home_url();  
        $link = preg_replace("%href=\"$site_link%i", 'href="', $link); 
                
        return $link;
    }
add_filter('the_content', 'wpi_relativeurl');
   

function dimox_breadcrumbs() {
  global $defaultoptions;
  $delimiter = '/';
  $home = __( 'Startseite', 'piratenkleider' ); // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $homeLink = home_url('/');
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . __( 'Artikel der Kategorie ', 'piratenkleider' ). '"' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . __( 'Suche', 'piratenkleider' ).'"' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . __( 'Artikel mit Schlagwort ', 'piratenkleider' ). '"' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . __( 'Artikel von ', 'piratenkleider' ). $userdata->display_name . $after;
 
    } elseif ( is_404() ) {
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



 
if( !is_admin()){
        wp_deregister_script('jquery');
        // muss trotz ThemeCheck Warnung drin bleiben, ansonsten wird veraltetes jQuery geladen
       // und der Slider und anderes mag dann nicht mehr
       wp_register_script('jquery', $defaultoptions['src-jquery'] , false, "1.7.2");
        wp_enqueue_script('jquery');

       wp_register_script('layoutjs', $defaultoptions['src-layoutjs'] , false, $defaultoptions['js-version']);
        wp_enqueue_script('layoutjs');
       wp_register_script('yaml-focusfix', $defaultoptions['src-yaml-focusfix'] , false, $defaultoptions['js-version']);
       wp_enqueue_script('yaml-focusfix');
       
       wp_deregister_script('comment-reply');
       if (!isset($options['aktiv-commentreplylink'])) 
            $options['aktiv-commentreplylink'] = $defaultoptions['aktiv-commentreplylink'];
       if ($options['aktiv-commentreplylink']==1) {        
            wp_register_script('comment-reply', $defaultoptions['src-comment-reply'] , false,  $defaultoptions['js-version']);
            wp_enqueue_script('comment-reply');
       }
      if (!isset($options['aktiv-dynamic-sidebar'])) 
          $options['aktiv-dynamic-sidebar'] = $defaultoptions['aktiv-dynamic-sidebar'];
      
       if ($options['aktiv-dynamic-sidebar']==1) {        
            wp_register_script('dynamic-sidebar', $defaultoptions['src-dynamic-sidebar'] , false,  $defaultoptions['js-version']);
            wp_enqueue_script('dynamic-sidebar');
       }       
       
       
       
}
       
        
function piratenkleider_admin_head() {
    echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/css/admin.css" />'; 
}
add_action('admin_head', 'piratenkleider_admin_head');

function custom_login() { 
    echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/css/custom-login.css" />'; 
}
add_action('login_head', 'custom_login');

/**
 * Functions of bbPress's Twenty Ten theme
 *
 * @package bbPress
 * @subpackage BBP_Twenty_Ten
 * @since Twenty Ten 1.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/** Theme Setup ***************************************************************/

if ( !class_exists( 'BBP_Twenty_Ten' ) ) :

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

	/** Functions *************************************************************/

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
		$bbp           = bbpress();
		$this->id      = 'bbp-twentyten';
		$this->name    = __( 'Twenty Ten (bbPress)', 'bbpress' ) ;
		$this->version = bbp_get_version();
		$this->dir     = trailingslashit( $bbp->themes_dir . 'bbp-twentyten' );
		$this->url     = trailingslashit( $bbp->themes_url . 'bbp-twentyten' );
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
		add_action( 'bbp_enqueue_scripts',      array( $this, 'enqueue_styles'        ) ); // Enqueue theme CSS
		add_action( 'bbp_enqueue_scripts',      array( $this, 'enqueue_scripts'       ) ); // Enqueue theme JS
		add_filter( 'bbp_enqueue_scripts',      array( $this, 'localize_topic_script' ) ); // Enqueue theme script localization
		add_action( 'bbp_head',                 array( $this, 'head_scripts'          ) ); // Output some extra JS in the <head>
		add_action( 'wp_ajax_dim-favorite',     array( $this, 'ajax_favorite'         ) ); // Handles the ajax favorite/unfavorite
		add_action( 'wp_ajax_dim-subscription', array( $this, 'ajax_subscription'     ) ); // Handles the ajax subscribe/unsubscribe
	}

	/**
	 * Load the theme CSS
	 *
	 * @since bbPress (r2652)
	 * @uses wp_enqueue_style() To enqueue the styles
	 */
	public function enqueue_styles() {

		// Right to left
		if ( is_rtl() ) {

			// TwentyTen
			if ( 'twentyten' == get_template() ) {
				wp_enqueue_style( 'twentyten',     get_template_directory_uri() . '/style.css', '',          $this->version, 'screen' );
				wp_enqueue_style( 'twentyten-rtl', get_template_directory_uri() . '/rtl.css',   'twentyten', $this->version, 'screen' );
			}

			// bbPress specific
			wp_enqueue_style( 'bbp-twentyten-bbpress', $this->url . 'css/bbpress-rtl.css', 'twentyten-rtl', $this->version, 'screen' );

		// Left to right
		} else {

			// TwentyTen
			if ( 'twentyten' == get_template() ) {
				wp_enqueue_style( 'twentyten',     get_template_directory_uri() . '/style.css', '',          $this->version, 'screen' );
			}

			// bbPress specific
			wp_enqueue_style( 'bbp-twentyten-bbpress', $this->url . 'css/bbpress.css', 'twentyten', $this->version, 'screen' );
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

		if ( bbp_is_single_topic() )
			wp_enqueue_script( 'bbp_topic', $this->url . 'js/topic.js', array( 'wp-lists' ), $this->version, true );

		if ( bbp_is_single_user_edit() )
			wp_enqueue_script( 'user-profile' );
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
		if ( bbp_is_single_topic() ) : ?>

		<script type='text/javascript'>
			/* <![CDATA[ */
			var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
			/* ]]> */
		</script>

		<?php elseif ( bbp_is_single_user_edit() ) : ?>

		<script type="text/javascript" charset="utf-8">
			if ( window.location.hash == '#password' ) {
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
		if ( !bbp_is_single_topic() )
			return;

		// Bail if user is not logged in
		if ( !is_user_logged_in() )
			return;

		$user_id = bbp_get_current_user_id();

		$localizations = array(
			'currentUserId' => $user_id,
			'topicId'       => bbp_get_topic_id(),
		);

		// Favorites
		if ( bbp_is_favorites_active() ) {
			$localizations['favoritesActive'] = 1;
			$localizations['favoritesLink']   = bbp_get_favorites_permalink( $user_id );
			$localizations['isFav']           = (int) bbp_is_user_favorite( $user_id );
			$localizations['favLinkYes']      = __( 'favorites',                                         'bbpress' );
			$localizations['favLinkNo']       = __( '?',                                                 'bbpress' );
			$localizations['favYes']          = __( 'This topic is one of your %favLinkYes% [%favDel%]', 'bbpress' );
			$localizations['favNo']           = __( '%favAdd% (%favLinkNo%)',                            'bbpress' );
			$localizations['favDel']          = __( '&times;',                                           'bbpress' );
			$localizations['favAdd']          = __( 'Add this topic to your favorites',                  'bbpress' );
		} else {
			$localizations['favoritesActive'] = 0;
		}

		// Subscriptions
		if ( bbp_is_subscriptions_active() ) {
			$localizations['subsActive']   = 1;
			$localizations['isSubscribed'] = (int) bbp_is_user_subscribed( $user_id );
			$localizations['subsSub']      = __( 'Subscribe',   'bbpress' );
			$localizations['subsUns']      = __( 'Unsubscribe', 'bbpress' );
			$localizations['subsLink']     = bbp_get_topic_permalink();
		} else {
			$localizations['subsActive'] = 0;
		}

		wp_localize_script( 'bbp_topic', 'bbpTopicJS', $localizations );
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
		$id      = intval( $_POST['id'] );

		if ( !current_user_can( 'edit_user', $user_id ) )
			die( '-1' );

		if ( !$topic = bbp_get_topic( $id ) )
			die( '0' );

		check_ajax_referer( 'toggle-favorite_' . $topic->ID );

		if ( bbp_is_user_favorite( $user_id, $topic->ID ) ) {
			if ( bbp_remove_user_favorite( $user_id, $topic->ID ) ) {
				die( '1' );
			}
		} else {
			if ( bbp_add_user_favorite( $user_id, $topic->ID ) ) {
				die( '1' );
			}
		}

		die( '0' );
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
		if ( !bbp_is_subscriptions_active() )
			return;

		$user_id = bbp_get_current_user_id();
		$id      = intval( $_POST['id'] );

		if ( !current_user_can( 'edit_user', $user_id ) )
			die( '-1' );

		if ( !$topic = bbp_get_topic( $id ) )
			die( '0' );

		check_ajax_referer( 'toggle-subscription_' . $topic->ID );

		if ( bbp_is_user_subscribed( $user_id, $topic->ID ) ) {
			if ( bbp_remove_user_subscription( $user_id, $topic->ID ) ) {
				die( '1' );
			}
		} else {
			if ( bbp_add_user_subscription( $user_id, $topic->ID ) ) {
				die( '1' );
			}
		}

		die( '0' );
	}
}
new BBP_Twenty_Ten();
endif;
