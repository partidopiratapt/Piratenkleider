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
                        <?php $onlineMembers = bp_core_get_users( array( 'type' => 'online')); ?>
                        <div id="upshrinkHeaderIC">
                            <div class="title_barIC">
                                <h4 class="titlebg">
                                    <span class="ie6_header floatleft">Estatísticas</span>
                                </h4>
                            </div>
                            <p class="smalltext">
                                <?php echo esc_html($stats['topic_count']) + esc_html($stats['reply_count']); ?> Mensagens em <?php echo esc_html($stats['topic_count']); ?> Tópicos por <?php echo esc_html($stats['user_count']); ?> Membros. Membro Mais Recente: <strong> <a href="http://www.forum.partidopiratapt.eu/index.php?action=profile;u=629" title="Ver o perfil de Zoinc">Zoinc</a></strong><br>
                                Última Mensagem: <strong>"<a href="http://www.forum.partidopiratapt.eu/index.php/topic,2215.msg10806.html#new" title="Re: Pirate Bay em vias de ser bloqueado em Portugal">Re: Pirate Bay em vias d...</a>"</strong>  ( 27 de Setembro de 2013, 00:09:06 )
                            </p>
                        </div>
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