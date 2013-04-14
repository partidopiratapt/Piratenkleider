<?php get_template_part( 'page-header' ) ?>       
        <div class="content-header">            
          <h1 id="page-title"><span><?php the_title(); ?></span></h1>
        
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

				<div id="bbp-user-<?php bbp_current_user_id(); ?>" class="bbp-single-user">
					<div class="entry-content">

						<?php bbp_get_template_part( 'bbpress/content', 'single-user-edit'   ); ?>

					</div><!-- .entry-content -->
				</div><!-- #bbp-user-<?php bbp_current_user_id(); ?> -->

			</div>
<?php get_template_part( 'page-footer' ) ?>    