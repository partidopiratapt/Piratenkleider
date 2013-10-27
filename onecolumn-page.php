<?php
get_header();
global $defaultoptions;
global $options;
?>

<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <div class="content-header">            
                <h1 id="page-title"><span><?php the_title(); ?></span></h1>
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
                <?php do_action('bp_before_blog_page'); ?>
                <div class="page" id="blog-page" role="main">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry">
                                    <?php the_content(__('<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress')); ?>
                                    <?php wp_link_pages(array('before' => '<div class="page-link"><p>' . __('Pages: ', 'buddypress'), 'after' => '</p></div>', 'next_or_number' => 'number')); ?>
                                    <?php edit_post_link(__('Edit this page.', 'buddypress'), '<p class="edit-link">', '</p>'); ?>
                                </div>
                            </div>
                            <?php comments_template(); ?>
                            <?php
                        endwhile;
                    endif;
                    ?>
                </div><!-- .page -->
                <?php do_action('bp_after_blog_page'); ?>
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