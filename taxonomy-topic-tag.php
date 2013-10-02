<?php

/**
 * Topic Tag
 *
 * @package bbPress
 * @subpackage Theme
 */

get_template_part('page-header');
do_action( 'bbp_before_main_content' );
    $image_url = piratenkleider_get_cover(sprintf(__('Topic Tag: %s', 'bbpress'), bbp_get_topic_tag_name()), get_the_ID());
?>
    <div class="skin">
	<?php
        do_action( 'bbp_template_notices' );
        if (!(isset($image_url) && (strlen($image_url) > 4))) {
        echo '        <h1 id="page-title"><span>'; printf(__('Topic Tag: %s', 'bbpress'), bbp_get_topic_tag_name()); echo'</span></h1>';
        } ?>
    
	<div id="topic-tag" class="bbp-topic-tag">
		<div class="entry-content">
			<?php bbp_get_template_part( 'content', 'archive-topic' ); ?>
		</div>
	</div><!-- #topic-tag -->
    </div>
	<?php do_action( 'bbp_after_main_content' ); ?>
</div>
    <div class="content-aside">
        <div class="skin">      
            <?php
            if (!isset($options['aktiv-circleplayer']))
                $options['aktiv-circleplayer'] = $defaultoptions['aktiv-circleplayer'];
            if ($options['aktiv-circleplayer'] == 1) {
                piratenkleider_echo_player();
            }
            get_sidebar('bbpress');
            ?>
        </div>
    </div>
</div>
<?php get_piratenkleider_socialmediaicons(2); ?>
</div>

<?php get_footer(); ?>