<?php get_header(); 
 $options = get_option( 'piratenkleider_theme_options' );
  if (!isset($options['src-default-symbolbild-big'])) 
            $options['src-default-symbolbild-big'] = $defaultoptions['src-default-symbolbild-big'];
 ?>

<div class="section content">
  <div class="row">
    <div class="content-primary">
      <div class="content-header-big">
          <h1>Página não encontrada</h1>
         <div class="symbolbild">                   
              <img src="<?php echo $options['src-default-symbolbild-big']?>" alt="" >
               <div class="caption">  
                   <p style="font-size: 2em;" class="bebas">404</p>                  
               </div>   
              <div class="aaarh">
                  <p>AAARH!<br>Vocês não vão encontrá-los!</p>
              </div>
           </div> 
         
      </div>
      <div class="skin">
          <p> 
              A página solicitada não pôde ser encontrada.
          </p>
         <p>
             Gostaria de pesquisar no site?
         </p>    
              
         <?php get_search_form(); ?>
      </div>
    </div>

    <div class="content-aside">
      <div class="skin">
        <h1 class="skip"><?php echo $defaultoptions['default_text_title_sidebar']; ?></h1>
         <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
