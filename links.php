<?php
get_header();
global $defaultoptions;
global $options;
?>

<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <div class="content-header">            
                <h1 id="page-title"><span><?php _e('Links', 'buddypress'); ?></span></h1>
                <?php
                if (has_post_thumbnail()) {
                    echo '<div class="symbolbild">';
                    the_post_thumbnail();
                    echo '</div>';
                } else {
                    if ($options['aktiv-defaultseitenbild'] == 1) {
                        $bilderoptions = get_option('piratenkleider_theme_defaultbilder');
                        $defaultbildsrc = $bilderoptions['seiten-defaultbildsrc'];
                        if (isset($defaultbildsrc) && (strlen($defaultbildsrc) > 4)) {
                            echo '<div class="symbolbild">';
                            echo '<img src="' . $defaultbildsrc . '"  alt="">';
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
            <div class="skin">
                <?php do_action('bp_before_blog_links'); ?>
                <div class="page" id="blog-latest" role="main">
                    <ul id="links-list">
                        <?php wp_list_bookmarks(); ?>
                    </ul>
                </div>
                <?php do_action('bp_after_blog_links'); ?>
            </div>
        </div>
        <div class="content-aside">
            <div class="skin">      
                <?php
                if (!isset($options['aktiv-circleplayer']))
                    $options['aktiv-circleplayer'] = $defaultoptions['aktiv-circleplayer'];
                if ($options['aktiv-circleplayer'] == 1) {
                    piratenkleider_echo_player();
                }
                get_sidebar('buddypress');
                ?>
            </div>
        </div>
    </div>
    <?php get_piratenkleider_socialmediaicons(2); ?>
</div>
<?php get_footer(); ?>