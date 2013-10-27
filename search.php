<?php get_header();    
global $options;
global $wp_query;
$cat_obj = $wp_query->get_queried_object();
$thisCat = $cat_obj->term_id;
$thisCatName = get_cat_name($thisCat);
?> 
<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">
	
	
	
	
            <?php
            $image_url = '';
            if (($options['aktiv-platzhalterbilder-indexseiten'] == 1) && (isset($options['src-default-symbolbild-search']))) {
                $image_url = $options['src-default-symbolbild-search'];
            }

            if (isset($image_url) && (strlen($image_url) > 4)) {
                if ($options['indexseitenbild-size'] == 1) {
                    echo '<div class="content-header-big">';
                } else {
                    echo '<div class="content-header">';
                }
                ?>    		    		    		        
            <h1 class="post-title"><span><?php printf(__('Suchergebnisse f&uuml;r %s', 'piratenkleider'), '' . get_search_query() . ''); ?></span></h1>
            <div class="symbolbild"><img src="<?php echo $image_url ?>" title="">		  
            </div>
        </div>                                 
        <?php } ?>           
	
        <div class="skin">
	  
            <?php if (!(isset($image_url) && (strlen($image_url) > 4))) { ?>
                <h1 class="post-title"><span><?php printf(__('Suchergebnisse f&uuml;r %s', 'piratenkleider'), '' . get_search_query() . ''); ?></span></h1>
            <?php }


	    if ( have_posts() ) : ?>
                <?php
                /* Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called loop-search.php and that will be used instead.
                 */


                $i = 0;
                $col = 0;

                $numentries = $options['category-num-article-fullwidth'] + $options['category-num-article-halfwidth'];
                $col_count = 3;
                $cols = array();

                global $query_string;
                query_posts($query_string . '&cat=$thisCat');

                while (have_posts() && $i < $numentries) : the_post();
                    $i++;
                    ob_start();
      if (( isset($options['category-num-article-fullwidth']))
                && ($options['category-num-article-fullwidth']>=$i )) {
                        piratenkleider_post_teaser($options['category-teaser-titleup'], $options['category-teaser-datebox'], $options['category-teaser-dateline'], $options['category-teaser-maxlength'], $options['teaser-thumbnail_fallback'], $options['category-teaser-floating']);
                    } else {
                        piratenkleider_post_teaser($options['category-teaser-titleup-halfwidth'], $options['category-teaser-datebox-halfwidth'], $options['category-teaser-dateline-halfwidth'], $options['category-teaser-maxlength-halfwidth'], $options['teaser-thumbnail_fallback'], $options['category-teaser-floating-halfwidth']);
                    }
                    $output = ob_get_contents();
                    ob_end_clean();
                    if (isset($output)) {
                        $cols[$col++] = $output;
                    }
                endwhile;
                ?>



                <div class="columns">
                    <?php
                    $z = 1;
                    foreach ($cols as $key => $col) {
            if (( isset($options['category-num-article-fullwidth']))
                && ($options['category-num-article-fullwidth']>$key )) {
                            echo $col;
                        } else {
                     if (( isset($options['category-num-article-fullwidth']))
                            && ($options['category-num-article-fullwidth']==$key )
                            && ($options['category-num-article-fullwidth']>0) ) {
                                echo '<hr>';
                            }
                            echo '<div class="column' . $z . '">' . $col . '</div>';
                            $z++;
                            if ($z > 2) {
                                $z = 1;
                                echo '<hr style="clear: both;">';
                            }
                        }
                    }
                    ?>
                </div>

    <?php if ($wp_query->max_num_pages > 1) : ?>
                    <div class="archiv-nav"><p>
                    <?php next_posts_link(__('&larr; &Auml;ltere Beitr&auml;ge', 'piratenkleider')); ?>
                            <?php previous_posts_link(__('Neuere Beitr&auml;ge &rarr;', 'piratenkleider')); ?>
                        </p></div> 
                        <?php endif; ?>                      



<?php else : ?>
                <h2><?php _e("Nichts gefunden", 'piratenkleider'); ?></h2>
                <p>
    <?php _e("Es konnten keine Seiten oder Artikel gefunden werden, die zu der Sucheingabe passten. Bitte versuchen Sie es nochmal mit einer  anderen Suche.", 'piratenkleider'); ?>

                </p>
    <?php get_search_form(); ?>

                <p>
    <?php _e("Alternativ verwenden Sie einen der folgenden Links.", 'piratenkleider'); ?>

                </p>

                <div class="widget">
                    <h3><?php _e("Archiv nach Monaten", 'piratenkleider'); ?></h3>                           
    <?php wp_get_archives('type=monthly'); ?>               
                </div>

                <div  class="widget">
                    <h3><?php _e("Artikel nach Schlagworten", 'piratenkleider'); ?></h3>    
                    <div class="tagcloud">
    <?php wp_tag_cloud(array('format' => 'list', 'smallest' => 12, 'largest' => 28)); ?>
                    </div>
                </div>
                <div class="widget">
                    <h3><?php _e("&Uuml;bersicht aller Kategorien", 'piratenkleider'); ?></h3>
                    <ul>                            
    <?php wp_list_categories('title_li='); ?>                               
                    </ul>
                </div>
                        
                        
            <?php endif; ?>

        </div>
    </div>

    <div class="content-aside">
        <div class="skin">        
            <h1 class="skip"><?php _e('Weitere Informationen', 'piratenkleider'); ?></h1>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_piratenkleider_socialmediaicons(2); ?>
</div>

<?php get_footer(); ?>
