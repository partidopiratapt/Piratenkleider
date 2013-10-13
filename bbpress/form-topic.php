<?php

/**
 * New/Edit Topic
 *
 * @package bbPress
 * @subpackage Theme
 */
if (!function_exists('piratenkleider_get_form_topic_content')) {
function piratenkleider_get_form_topic_content() {

    // Get _POST data
    if (bbp_is_post_request() && isset($_POST['bbp_topic_content'])) {
        $topic_content = stripslashes($_POST['bbp_topic_content']);

        // Get edit data
    } elseif (bbp_is_topic_edit()) {
        $topic_content = get_post_field('post_content', bbp_get_topic_id());
        // No data
    } else {
        $topic_content = '';
    }

    return apply_filters('bbp_get_form_topic_content', $topic_content);
}
}
if (!function_exists("getTheContent")) {

    function getTheContent($args = array()) {
        // Parse arguments against default values
        $r = bbp_parse_args($args, array(
            'context' => 'topic',
            'before' => '<div class="bbp-the-content-wrapper">',
            'after' => '</div>',
            'wpautop' => true,
            'media_buttons' => false,
            'textarea_rows' => '12',
            'tabindex' => bbp_get_tab_index(),
            'tabfocus_elements' => 'bbp_topic_title,bbp_topic_tags',
            'editor_class' => 'bbp-the-content',
            'tinymce' => false,
            'teeny' => true,
            'quicktags' => true,
            'dfw' => false
                ), 'get_the_content');

        // If using tinymce, remove our escaping and trust tinymce
        if (bbp_use_wp_editor() && ( false !== $r['tinymce'] )) {
            remove_filter('bbp_get_form_forum_content', 'esc_textarea');
            remove_filter('bbp_get_form_topic_content', 'esc_textarea');
            remove_filter('bbp_get_form_reply_content', 'esc_textarea');
        }

        // Assume we are not editing
        $post_content = call_user_func('piratenkleider_get_form_' . $r['context'] . '_content');
        //$post_content = piratenkleider_get_form_reply_content();
        // Start an output buffor
        ob_start();
        // Output something before the editor
        if (!empty($r['before'])) {
            echo $r['before'];
        }
        // Use TinyMCE if available
        if (bbp_use_wp_editor()) :
            // Enable additional TinyMCE plugins before outputting the editor
            add_filter('tiny_mce_plugins', 'bbp_get_tiny_mce_plugins');
            add_filter('teeny_mce_plugins', 'bbp_get_tiny_mce_plugins');
            add_filter('teeny_mce_buttons', 'bbp_get_teeny_mce_buttons');
            add_filter('quicktags_settings', 'bbp_get_quicktags_settings');

            // Output the editor
            wp_editor($post_content, 'bbp_' . $r['context'] . '_content', array(
                'wpautop' => $r['wpautop'],
                'media_buttons' => $r['media_buttons'],
                'textarea_rows' => $r['textarea_rows'],
                'tabindex' => $r['tabindex'],
                'tabfocus_elements' => $r['tabfocus_elements'],
                'editor_class' => $r['editor_class'],
                'tinymce' => $r['tinymce'],
                'teeny' => $r['teeny'],
                'quicktags' => $r['quicktags'],
                'dfw' => $r['dfw'],
            ));

            // Remove additional TinyMCE plugins after outputting the editor
            remove_filter('tiny_mce_plugins', 'bbp_get_tiny_mce_plugins');
            remove_filter('teeny_mce_plugins', 'bbp_get_tiny_mce_plugins');
            remove_filter('teeny_mce_buttons', 'bbp_get_teeny_mce_buttons');
            remove_filter('quicktags_settings', 'bbp_get_quicktags_settings');

        /**
         * Fallback to normal textarea.
         *
         * Note that we do not use esc_textarea() here to prevent double
         * escaping the editable output, mucking up existing content.
         */
        else :
            ?>
            <textarea id="bbp_<?php echo esc_attr($r['context']); ?>_content" class="<?php echo esc_attr($r['editor_class']); ?>" name="bbp_<?php echo esc_attr($r['context']); ?>_content" cols="120" rows="<?php echo esc_attr($r['textarea_rows']+12); ?>" tabindex="<?php echo esc_attr($r['tabindex']); ?>"><?php echo $post_content; ?></textarea>
        <?php
        endif;

        // Output something after the editor
        if (!empty($r['after'])) {
            echo $r['after'];
        }

        // Put the output into a usable variable
        $output = ob_get_clean();
        return apply_filters('bbp_get_the_content', $output, $args, $post_content);
    }

}
?>
<?php if (bbp_is_topic_edit()) : ?>
    <?php bbp_topic_tag_list(bbp_get_topic_id()); ?>
    <?php bbp_single_topic_description(array('topic_id' => bbp_get_topic_id())); ?>
<?php endif; ?>
        <?php if (bbp_current_user_can_access_create_topic_form()) : $id = bbp_get_topic_id(); ?>
    <div id="new-topic-<?php echo $id; ?>" class="bbp-topic-form" style="">
        <form id="new-post" name="new-post" method="post" action="<?php the_permalink(); ?>">
                    <?php do_action('bbp_theme_before_topic_form'); ?>
            <fieldset class="bbp-form">
                <legend>
                    <?php
                    if (bbp_is_topic_edit())
                        printf(__('Now Editing &ldquo;%s&rdquo;', 'bbpress'), bbp_get_topic_title());
                    else
                        bbp_is_single_forum() ? printf(__('Create New Topic in &ldquo;%s&rdquo;', 'bbpress'), bbp_get_forum_title()) : _e('Create New Topic', 'bbpress');
                    ?>
                </legend>
    <?php do_action('bbp_theme_before_topic_form_notices'); ?>
    <?php if (!bbp_is_topic_edit() && bbp_is_forum_closed()) : ?>
                    <div class="bbp-template-notice">
                        <p><?php _e('This forum is marked as closed to new topics, however your posting capabilities still allow you to do so.', 'bbpress'); ?></p>
                    </div>
    <?php endif; ?>
    <?php if (current_user_can('unfiltered_html')) : ?>
                    <div class="bbp-template-notice">
                        <p><?php _e('Your account has the ability to post unrestricted HTML content.', 'bbpress'); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php do_action('bbp_template_notices'); ?>
                <div>
    <?php bbp_get_template_part('form', 'anonymous'); ?>
    <?php do_action('bbp_theme_before_topic_form_title'); ?>
                    <p>
                        <label for="bbp_topic_title"><?php printf(__('Topic Title (Maximum Length: %d):', 'bbpress'), bbp_get_title_max_length()); ?></label><br />
                        <input type="text" id="bbp_topic_title" value="<?php bbp_form_topic_title(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_title" maxlength="<?php bbp_title_max_length(); ?>" />
                    </p>
                    <?php do_action('bbp_theme_after_topic_form_title'); ?>
                    <?php do_action('bbp_theme_before_topic_form_content'); ?>
                    <?php /* getTheContent(array('context' => 'topic'));*/ ?>
                    <div class="bbp-the-content-wrapper">
                    <textarea id="bbp_<?php echo esc_attr('topic'); ?>_content" class="<?php echo esc_attr('bbp-the-content'); ?>" name="bbp_<?php echo esc_attr('topic'); ?>_content" cols="120" rows="<?php echo esc_attr('24'); ?>" tabindex="<?php echo esc_attr('107'); ?>" style="width: 100%;"><?php echo piratenkleider_get_form_topic_content(); ?></textarea>
                    </div>
    <?php do_action('bbp_theme_after_topic_form_content'); ?>
    <?php if (!( bbp_use_wp_editor() || current_user_can('unfiltered_html') )) : ?>
                        <p class="form-allowed-tags">
                            <label><?php _e('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'bbpress'); ?></label><br />
                            <code><?php bbp_allowed_tags(); ?></code>
                        </p>
                    <?php endif; ?>
    <?php if (bbp_allow_topic_tags() && current_user_can('assign_topic_tags')) : ?>
        <?php do_action('bbp_theme_before_topic_form_tags'); ?>
                        <p>
                            <label for="bbp_topic_tags"><?php _e('Topic Tags:', 'bbpress'); ?></label><br />
                            <input type="text" value="<?php bbp_form_topic_tags(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_tags" id="bbp_topic_tags" <?php disabled(bbp_is_topic_spam()); ?> />
                        </p>
                        <?php do_action('bbp_theme_after_topic_form_tags'); ?>
                    <?php endif; ?>
    <?php if (!bbp_is_single_forum()) : ?>
                            <?php do_action('bbp_theme_before_topic_form_forum'); ?>
                        <p>
                            <label for="bbp_forum_id"><?php _e('Forum:', 'bbpress'); ?></label><br />
                        <?php bbp_dropdown(array('selected' => bbp_get_form_topic_forum())); ?>
                        </p>
                        <?php do_action('bbp_theme_after_topic_form_forum'); ?>
                    <?php endif; ?>
    <?php if (current_user_can('moderate')) : ?>
                            <?php do_action('bbp_theme_before_topic_form_type'); ?>
                        <p>
                            <label for="bbp_stick_topic"><?php _e('Topic Type:', 'bbpress'); ?></label><br />
                        <?php bbp_form_topic_type_dropdown(); ?>
                        </p>
        <?php do_action('bbp_theme_after_topic_form_type'); ?>
                            <?php do_action('bbp_theme_before_topic_form_status'); ?>
                        <p>
                            <label for="bbp_topic_status"><?php _e('Topic Status:', 'bbpress'); ?></label><br />
                        <?php bbp_form_topic_status_dropdown(); ?>
                        </p>
                        <?php do_action('bbp_theme_after_topic_form_status'); ?>
                    <?php endif; ?>
    <?php if (bbp_is_subscriptions_active() && !bbp_is_anonymous() && (!bbp_is_topic_edit() || ( bbp_is_topic_edit() && !bbp_is_topic_anonymous() ) )) : ?>
                            <?php do_action('bbp_theme_before_topic_form_subscriptions'); ?>
                        <p>
                            <input name="bbp_topic_subscription" id="bbp_topic_subscription" type="checkbox" value="bbp_subscribe" <?php bbp_form_topic_subscribed(); ?> tabindex="<?php bbp_tab_index(); ?>" />
                            <?php if (bbp_is_topic_edit() && ( bbp_get_topic_author_id() !== bbp_get_current_user_id() )) : ?>
                                <label for="bbp_topic_subscription"><?php _e('Notify the author of follow-up replies via email', 'bbpress'); ?></label>
                            <?php else : ?>
                                <label for="bbp_topic_subscription"><?php _e('Notify me of follow-up replies via email', 'bbpress'); ?></label>
                        <?php endif; ?>
                        </p>
                        <?php do_action('bbp_theme_after_topic_form_subscriptions'); ?>
                    <?php endif; ?>
    <?php if (bbp_allow_revisions() && bbp_is_topic_edit()) : ?>
        <?php do_action('bbp_theme_before_topic_form_revisions'); ?>
                        <fieldset class="bbp-form">
                            <legend>
                                <input name="bbp_log_topic_edit" id="bbp_log_topic_edit" type="checkbox" value="1" <?php bbp_form_topic_log_edit(); ?> tabindex="<?php bbp_tab_index(); ?>" />
                                <label for="bbp_log_topic_edit"><?php _e('Keep a log of this edit:', 'bbpress'); ?></label><br />
                            </legend>
                            <div>
                                <label for="bbp_topic_edit_reason"><?php printf(__('Optional reason for editing:', 'bbpress'), bbp_get_current_user_name()); ?></label><br />
                                <input type="text" value="<?php bbp_form_topic_edit_reason(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_topic_edit_reason" id="bbp_topic_edit_reason" />
                            </div>
                        </fieldset>
                        <?php do_action('bbp_theme_after_topic_form_revisions'); ?>
                        <?php endif; ?>
                        <?php do_action('bbp_theme_before_topic_form_submit_wrapper'); ?>
                    <div class="bbp-submit-wrapper">
                        <?php do_action('bbp_theme_before_topic_form_submit_button'); ?>
                        <button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_topic_submit" name="bbp_topic_submit" class="button submit"><?php _e('Submit', 'bbpress'); ?></button>
                    <?php do_action('bbp_theme_after_topic_form_submit_button'); ?>
                    </div>
                <?php do_action('bbp_theme_after_topic_form_submit_wrapper'); ?>
                </div>
            <?php bbp_topic_form_fields(); ?>
            </fieldset>
    <?php do_action('bbp_theme_after_topic_form'); ?>
        </form>
    </div>
<?php elseif (bbp_is_forum_closed()) : ?>
    <div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
        <div class="bbp-template-notice">
            <p><?php printf(__('The forum &#8216;%s&#8217; is closed to new topics and replies.', 'bbpress'), bbp_get_forum_title()); ?></p>
        </div>
    </div>
<?php else : ?>
    <div id="no-topic-<?php bbp_topic_id(); ?>" class="bbp-no-topic">
        <div class="bbp-template-notice">
            <p><?php is_user_logged_in() ? _e('You cannot create new topics.', 'bbpress') : _e('You must be logged in to create new topics.', 'bbpress'); ?></p>
        </div>
    </div>
<?php endif; ?>
<?php if (!bbp_is_single_forum()) : ?>
    </div>
<?php endif; ?>