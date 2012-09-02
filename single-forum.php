<?php get_template_part( 'page-header' ) ?>    
        <div class="content-header">            
          <h1 id="page-title"><span><?php bbp_forum_title(); ?></span></h1>
        
        <?php if (has_post_thumbnail()) { 
            echo '<div class="symbolbild">';
              the_post_thumbnail(); 
            echo '</div>';  
        } else {            
           if ($options['aktiv-defaultseitenbild']==1) {   
                $bilderoptions = get_option( 'piratenkleider_theme_defaultbilder' ); 
                $defaultbildsrc = $bilderoptions['seiten-defaultbildsrc'];     
 if (isset($defaultbildsrc) && (strlen($defaultbildsrc)>4)) {
                 echo '<div class="symbolbild">';
                 echo '<img src="'.$defaultbildsrc.'"  alt="">';                        
                 echo '</div>';  
           }            
        }   
}
         ?>
      </div>
      <div class="skin">

				<?php do_action( 'bbp_template_notices' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php if ( bbp_user_can_view_forum() ) : ?>

						<div id="forum-<?php bbp_forum_id(); ?>" class="bbp-forum-info">
							<h1 class="entry-title"><?php bbp_forum_title(); ?></h1>
							<div class="entry-content">

								<?php bbp_get_template_part( 'bbpress/content', 'single-forum' ); ?>

							</div>
						</div><!-- #forum-<?php bbp_forum_id(); ?> -->

					<?php else : // Forum exists, user no access ?>

						<?php bbp_get_template_part( 'bbpress/feedback', 'no-access' ); ?>

					<?php endif; ?>

				<?php endwhile; ?>

			</div>
<?php get_template_part( 'page-footer' ) ?>    