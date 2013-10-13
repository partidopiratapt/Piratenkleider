<?php
/**
 * bbPress - Forum Archive
 *
 * @package bbPress
 * @subpackage Theme
 */
get_header();
global $defaultoptions;
global $options;
$stats = bbp_get_statistics();
?>
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">            
            <?php
            $image_url = piratenkleider_get_cover(bbp_get_forum_archive_title(), get_the_ID());
            ?>
            <div class="skin">
                <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                    <h1 id="page-title"><span><?php bbp_forum_archive_title(); ?></span></h1>
                <?php } ?>
                <?php do_action('bbp_template_notices'); ?>
                <div id="forum-front" class="bbp-forum-front">
                    <div class="entry-content">
                        <?php bbp_get_template_part('content', 'archive-forum'); ?>
                        <div id="posting_icons" class="floatleft">
                            <ul class="reset">
                                <li class="floatleft"><img width="24px" height="24px" src="<?php echo get_template_directory_uri() ?>/images/Blue-Pirates-icon.png" alt=""> Há novas mensagens</li>
                                <li class="floatleft"><img width="24px" height="24px" src="<?php echo get_template_directory_uri() ?>/images/Lightbrown-Pirates-icon.png" alt=""> Não há novas mensagens</li>
                            </ul>
                        </div>
                        <?php $onlineMembers = bp_core_get_users(array('type' => 'online')); ?>
                    </div>
                </div><!-- #forum-front -->
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
                get_sidebar('bbpress');
                ?>
            </div>
        </div>
    </div>
    <?php get_piratenkleider_socialmediaicons(2); ?>
</div>
<?php get_footer(); ?>