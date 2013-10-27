<?php
/**
 * Pagination for pages of replies (when viewing a topic)
 *
 * @package bbPress
 * @subpackage Theme
 */
?>

<?php do_action('bbp_template_before_pagination_loop'); ?>
<div class="pagelinks floatleft"><?php $links = bbp_get_topic_pagination_links(); if(!empty($links)) { ?>Páginas: <?php echo $links; } ?></div>
<?php do_action('bbp_template_after_pagination_loop'); ?>
