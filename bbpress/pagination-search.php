<?php

/**
 * Pagination for pages of search results 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_pagination_loop' ); ?>
<div class="pagelinks"><?php $links = bbp_get_search_pagination_links(); if(!empty($links)) { ?>Páginas: <?php echo $links; } ?></div>
<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
