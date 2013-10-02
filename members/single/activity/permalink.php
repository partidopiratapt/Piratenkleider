<?php
get_header();
global $defaultoptions;
global $options;
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <div class="skin">
                <?php do_action('template_notices'); ?>
                <div class="activity no-ajax" role="main">
                    <?php if (bp_has_activities('display_comments=threaded&show_hidden=true&include=' . bp_current_action())) : ?>
                        <ul id="activity-stream" class="activity-list item-list">
                            <?php while (bp_activities()) : bp_the_activity(); ?>
                                <?php locate_template(array('activity/entry.php'), true); ?>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>
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