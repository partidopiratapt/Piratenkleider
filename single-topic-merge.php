<?php get_template_part('page-header') ?>         
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

    <?php if (have_posts()) while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
            <?php wp_link_pages(array('before' => '' . __('P&aacute;ginas:', 'piratenkleider'), 'after' => '')); ?>
            <?php edit_post_link(__('Edit', 'piratenkleider'), '', ''); ?>
    <?php endwhile; ?>
</div>
<?php get_template_part('page-footer') ?>    