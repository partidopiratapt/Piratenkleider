<?php
/**
 * Pagination for pages of topics (when viewing a forum)
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<?php do_action('bbp_template_before_pagination_loop'); ?>
<div class="pagelinks">Páginas: <?php bbp_forum_pagination_links(); ?></div>
<div style="float: right;">
    <div style="float: left;"><a href="#new-post" onclick="toggle_visibility('new-topic-0');">Novo Tópico</a></div>
<?php do_action('bbp_template_after_pagination_loop'); ?>
</div>