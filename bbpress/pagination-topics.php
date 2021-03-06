<?php
/**
 * Pagination for pages of topics (when viewing a forum)
 *
 * @package bbPress
 * @subpackage Theme
 */
?>
<?php do_action('bbp_template_before_pagination_loop'); ?>
<div class="pagelinks"><?php $links = bbp_get_forum_pagination_links(); if(!empty($links)) { ?>Páginas: <?php echo $links; } ?></div>
<div style="float: right;">
    <div style="float: left;"><a href="#new-post" onclick="toggle_visibility('new-topic-0');">Novo Tópico</a></div>
<?php do_action('bbp_template_after_pagination_loop'); ?>
</div>