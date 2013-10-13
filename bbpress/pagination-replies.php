<?php
/**
 * Pagination for pages of replies (when viewing a topic)
 *
 * @package bbPress
 * @subpackage Theme
 */
?>

<?php do_action('bbp_template_before_pagination_loop'); ?>
<div class="pagelinks floatleft">Páginas: <?php bbp_topic_pagination_links(); ?></div>
<div style="float: right;"><a href="#new-post" onclick="toggle_visibility('new-reply');">Nova Resposta</a></div>
<?php do_action('bbp_template_after_pagination_loop'); ?>
