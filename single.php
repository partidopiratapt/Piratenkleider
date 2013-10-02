<?php get_header();    
  global $options;    
?> 
<div class="section content" id="main-content">
  <div class="row">
    <div class="content-primary">
	
        <?php if ( have_posts() ) while ( have_posts() ) : the_post();         
        $custom_fields = get_post_custom();

	    $image_url = '';
	    $image_alt = '';
	    if (has_post_thumbnail()) { 
		$thumbid = get_post_thumbnail_id(get_the_ID());
		 // array($options['bigslider-thumb-width'],$options['bigslider-thumb-height'])
		$image_url_data = wp_get_attachment_image_src( $thumbid, 'full');
		$image_url = $image_url_data[0];
		$image_alt = trim(strip_tags( get_post_meta($thumbid, '_wp_attachment_image_alt', true) ));
			
	    } else {
		if (($options['aktiv-artikelbild']==1) && (isset($options['artikelbild-src']))) {  
		    $image_url = $options['artikelbild-src'];		    
		}
	    }
	    
	    if (isset($image_url) && (strlen($image_url)>4)) { 
		if ($options['artikelbild-size']==1) {
		    echo '<div class="content-header-big">';
		} else {
		    echo '<div class="content-header">';
		}
		?>    		    		    		        
		   <h1 class="post-title"><span><?php the_title(); ?></span></h1>
		   <div class="symbolbild"><img src="<?php echo $image_url ?>" title="">
		   <?php if (isset($image_alt) && (strlen($image_alt)>1)) {
		     echo '<div class="caption">'.$image_alt.'</div>';  
		   }  ?>
		   </div>
		</div>  	
	    <?php } ?>
      
      <div class="skin">
       <?php if (!(isset($image_url) && (strlen($image_url)>4))) { ?>
	    <h1 class="post-title"><span><?php the_title(); ?></span></h1>
	<?php } ?>
 
        <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
  
           <?php 
            if ( (isset($custom_fields['show-post-disclaimer']))
                 && ($custom_fields['show-post-disclaimer'][0]<>'') 
                 && ($options['post_disclaimer']<>'') 
                 && ( ($custom_fields['show-post-disclaimer'][0]==1) || ($custom_fields['show-post-disclaimer'][0]==3)) 
                ) {
                echo '<div class="disclaimer">';
                echo $options['post_disclaimer'];
                echo '</div>';
                }
				
		piratenkleider_post_datumsbox();		
          ?>  
        
            
          
            
          <div class="post-entry">
            <?php the_content(); ?>
          </div>
             <?php 
            if ( (isset($custom_fields['show-post-disclaimer']))
                 &&   ($custom_fields['show-post-disclaimer'][0]<>'') 
                 && ($options['post_disclaimer']<>'') 
                 && ( ($custom_fields['show-post-disclaimer'][0]==2) || ($custom_fields['show-post-disclaimer'][0]==3)) 
                ) {
                echo '<div class="disclaimer">';
                echo $options['post_disclaimer'];
                echo '</div>';
                }
          ?>  
			
          <div class="post-meta"><p>
               <?php 
                piratenkleider_post_pubdateinfo();    
                if ($options['aktiv-autoren']) piratenkleider_post_autorinfo();             
                echo ' ';  
                 piratenkleider_post_taxonominfo();  
                ?>        
              </p>
          </div>
	  
            <div><?php edit_post_link( __( 'Bearbeiten', 'piratenkleider' ), '', '' ); ?></div>
          </div>
	<div class="post-nav">
		<ul>
		<?php 
		 previous_post_link('<li class="back">&#9664; %link</li>', '%title'); 
		 next_post_link('<li class="forward">%link &#9654;</li>', '%title'); 
		 ?>
		</ul>
        </div>
        <hr>

        <div class="post-comments" id="comments">
          <?php comments_template( '', true ); ?>
        </div>

        <div class="post-nav">
            
           <?php if (has_filter( 'related_posts_by_category')) { ?>   
          <h3><?php _e("Weitere Artikel in diesem Themenkreis:", 'piratenkleider'); ?></h3>
          <ul class="related">
            <?php do_action(
            'related_posts_by_category',
            array(
            'orderby' => 'post_date',
            'order' => 'DESC',
            'limit' => 5,
            'echo' => true,
            'before' => '<li>',
            'inside' => '',
            'outside' => '',
            'after' => '</li>',
            'rel' => 'follow',
            'type' => 'post',
            'image' => array(1, 1),
            'message' => __('Keine Treffer', 'piratenkleider')
            )
            ) ?>
          </ul>
          <?php } ?>
        </div>

       
      </div>
        <?php endwhile; // end of the loop. ?>
      </div>

    <div class="content-aside">
      <div class="skin">
       <h1 class="skip"><?php _e( 'Weitere Informationen', 'piratenkleider' ); ?></h1>
       <?php
       
        if (  
		( isset($custom_fields['text']) && isset($custom_fields['image_url']) && 
		   ($custom_fields['image_url'][0]<>'') && ($custom_fields['text'][0]<>''))
		|| (
			(isset($custom_fields['text']) && $custom_fields['text'][0]<>'') && (has_post_thumbnail())))             
            {   ?>
            <div id="steckbrief">   
                <?php
                if (isset($custom_fields['image_url']) &&  $custom_fields['image_url'][0]<>'') {
                    echo wp_get_attachment_image( $custom_fields['image_url'][0], array(300,300) ); 
                } else {
                     the_post_thumbnail(array(300,300));
                } ?>
                
                <div class="text">
                     <?php echo do_shortcode(get_post_meta($post->ID, 'text', $single = true)); ?>
                </div>
           </div>
           <?php 
        }         
       
            piratenkleider_echo_player();
        get_sidebar(); 
        ?>
        </div>
    </div>
  </div>
  <?php  get_piratenkleider_socialmediaicons(2); ?>
</div>
<?php get_footer(); ?>