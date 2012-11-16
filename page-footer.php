    </div>

    <div class="content-aside">
      <div class="skin">      
          
          <h1 class="skip"><?php _e( 'Weitere Informationen', 'piratenkleider' ); ?></h1>
          
            <?php
            
            if (!isset($options['zeige_subpagesonly'])) 
            $options['zeige_subpagesonly'] = $defaultoptions['zeige_subpagesonly'];
  
            if (!isset($options['zeige_sidebarpagemenu'])) 
            $options['zeige_sidebarpagemenu'] = $defaultoptions['zeige_sidebarpagemenu'];
            get_piratenkleider_seitenmenu($options['zeige_sidebarpagemenu'],$options['zeige_subpagesonly']);
        
        $custom_fields = get_post_custom();
        if ($custom_fields['right_column'][0]<>'') {
            echo $custom_fields['right_column'][0]; 
        }  
         ?>
         <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
  <?php  get_piratenkleider_socialmediaicons(2); ?>

</div>

<?php get_footer(); ?>