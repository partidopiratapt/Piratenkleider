<div class="first-footer-widget-area">
    <div class="skin">
        <?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) { ?>
            <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
        <?php } else { ?>
            
        <h2>Movimento Partido Pirata Português</h2>
        <p class="titelurl"><a href="http://www.partidopiratapt.eu">www.partidopiratapt.eu</a></p>
            <ul>            
            <?php 
            $args = array(
    'orderby'          => 'name',
    'order'            => 'ASC',
    'show_images '     => 1,
    'category_orderby' => 'name',
    'category_order'   => 'ASC',
    'category_before'  => '<li>',
    'category_after'   => '</li>' );
            wp_list_bookmarks( $args ); ?>   
            </ul>
        <?php } ?>    
    </div>
</div>
