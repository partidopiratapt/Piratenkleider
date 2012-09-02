<?php get_template_part('page-header') ?>
<div class="content-header">            
    <h1 id="page-title"><span><?php _e('Activity', 'buddypress'); ?></span></h1>

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
    <?php do_action('bp_before_directory_activity'); ?>

    <?php do_action('bp_before_directory_activity_content'); ?>

    <?php if (is_user_logged_in()) : ?>

        <?php locate_template(array('activity/post-form.php'), true); ?>

    <?php endif; ?>

    <?php do_action('template_notices'); ?>

    <div class="item-list-tabs activity-type-tabs" role="navigation">
        <ul>
            <?php do_action('bp_before_activity_type_tab_all'); ?>

            <li class="selected" id="activity-all"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/'; ?>" title="<?php _e('Actividade publica para qualquer pessoa do site.', 'buddypress'); ?>"><?php printf(__('Todos os Membros <span>%s</span>', 'buddypress'), bp_get_total_site_member_count()); ?></a></li>

            <?php if (is_user_logged_in()) : ?>

                <?php do_action('bp_before_activity_type_tab_friends') ?>

                <?php if (bp_is_active('friends')) : ?>

                    <?php if (bp_get_total_friend_count(bp_loggedin_user_id())) : ?>

                        <li id="activity-friends"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_friends_slug() . '/'; ?>" title="<?php _e('Só actividades dos meus amigos.', 'buddypress'); ?>"><?php printf(__('Meus Amigos <span>%s</span>', 'buddypress'), bp_get_total_friend_count(bp_loggedin_user_id())); ?></a></li>

                    <?php endif; ?>

                <?php endif; ?>

                <?php do_action('bp_before_activity_type_tab_groups') ?>

                <?php if (bp_is_active('groups')) : ?>

                    <?php if (bp_get_total_group_count_for_user(bp_loggedin_user_id())) : ?>

                        <li id="activity-groups"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_groups_slug() . '/'; ?>" title="<?php _e('Actividades de grupos de que sou membro.', 'buddypress'); ?>"><?php printf(__('Meus Grupos <span>%s</span>', 'buddypress'), bp_get_total_group_count_for_user(bp_loggedin_user_id())); ?></a></li>

                    <?php endif; ?>

                <?php endif; ?>

                <?php do_action('bp_before_activity_type_tab_favorites'); ?>

                <?php if (bp_get_total_favorite_count_for_user(bp_loggedin_user_id())) : ?>

                    <li id="activity-favorites"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/favorites/'; ?>" title="<?php _e("Actividade em que sou marcado como favorito.", 'buddypress'); ?>"><?php printf(__('Meu Favoritos <span>%s</span>', 'buddypress'), bp_get_total_favorite_count_for_user(bp_loggedin_user_id())); ?></a></li>

                <?php endif; ?>

                <?php do_action('bp_before_activity_type_tab_mentions'); ?>

                <li id="activity-mentions"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/mentions/'; ?>" title="<?php _e('Actividades em que foi mencionado.', 'buddypress'); ?>"><?php _e('Menções', 'buddypress'); ?><?php if (bp_get_total_mention_count_for_user(bp_loggedin_user_id())) : ?> <strong><?php printf(__('<span>%s new</span>', 'buddypress'), bp_get_total_mention_count_for_user(bp_loggedin_user_id())); ?></strong><?php endif; ?></a></li>

            <?php endif; ?>

            <?php do_action('bp_activity_type_tabs'); ?>
        </ul>
    </div><!-- .item-list-tabs -->

    <div class="item-list-tabs no-ajax" id="subnav" role="navigation">
        <ul>
            <li class="feed"><a href="<?php bp_sitewide_activity_feed_link() ?>" title="<?php _e('RSS Feed', 'buddypress'); ?>"><?php _e('RSS', 'buddypress'); ?></a></li>

            <?php do_action('bp_activity_syndication_options'); ?>

            <li id="activity-filter-select" class="last">
                <label for="activity-filter-by"><?php _e('Mostrar:', 'buddypress'); ?></label> 
                <select id="activity-filter-by">
                    <option value="-1"><?php _e('Tudo', 'buddypress'); ?></option>
                    <option value="activity_update"><?php _e('Actualizações', 'buddypress'); ?></option>

                    <?php if (bp_is_active('blogs')) : ?>

                        <option value="new_blog_post"><?php _e('Posts', 'buddypress'); ?></option>
                        <option value="new_blog_comment"><?php _e('Comentarios', 'buddypress'); ?></option>

                    <?php endif; ?>

                    <?php if (bp_is_active('forums')) : ?>

                        <option value="new_forum_topic"><?php _e('Topicos do Forum', 'buddypress'); ?></option>
                        <option value="new_forum_post"><?php _e('Respostas do Forum', 'buddypress'); ?></option>

                    <?php endif; ?>

                    <?php if (bp_is_active('groups')) : ?>

                        <option value="created_group"><?php _e('Novo Grupo', 'buddypress'); ?></option>
                        <option value="joined_group"><?php _e('Membros do Grupo', 'buddypress'); ?></option>

                    <?php endif; ?>

                    <?php if (bp_is_active('friends')) : ?>

                        <option value="friendship_accepted,friendship_created"><?php _e('Amizades', 'buddypress'); ?></option>

                    <?php endif; ?>

                    <option value="new_member"><?php _e('Novos Membros', 'buddypress'); ?></option>

                    <?php do_action('bp_activity_filter_options'); ?>

                </select>
            </li>
        </ul>
    </div><!-- .item-list-tabs -->

    <?php do_action('bp_before_directory_activity_list'); ?>

    <div class="activity" role="main">

        <?php locate_template(array('activity/activity-loop.php'), true); ?>

    </div><!-- .activity -->

    <?php do_action('bp_after_directory_activity_list'); ?>

    <?php do_action('bp_directory_activity_content'); ?>

    <?php do_action('bp_after_directory_activity_content'); ?>

    <?php do_action('bp_after_directory_activity'); ?>
</div>
<?php get_template_part('page-footer') ?>