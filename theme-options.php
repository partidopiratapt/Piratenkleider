<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'piratenkleider_options', 'piratenkleider_theme_options', 'theme_options_validate' );
        register_setting( 'piratenkleider_defaultbilder', 'piratenkleider_theme_defaultbilder', 'theme_defaultbilder_validate' );
        register_setting( 'piratenkleider_kontaktinfos', 'piratenkleider_theme_kontaktinfos', 'theme_kontaktinfos_validate' );
        register_setting( 'piratenkleider_designspecials', 'piratenkleider_theme_designspecials', 'theme_designspecials_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Options Set', 'piratenkleider' ), __( 'Options Set', 'piratenkleider' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
        add_theme_page( __( 'Nav Options', 'piratenkleider' ), __( 'Nav Options', 'piratenkleider' ), 'edit_theme_options', 'theme_defaultbilder', 'theme_defaultbilder_do_page' );
        add_theme_page( __( 'Captn & Crew', 'piratenkleider' ), __( 'Captn & Crew', 'piratenkleider' ), 'edit_theme_options', 'theme_kontaktinfos', 'theme_kontaktinfos_do_page' );
        add_theme_page( __( 'Design Options', 'piratenkleider' ), __( 'Design Options', 'piratenkleider' ), 'edit_theme_options', 'theme_designspecials', 'theme_designspecials_do_page' );
}


/**
 * Create the options page
 */
function theme_options_do_page() {
	global $defaultoptions;
        global $defaultplakate_textsymbolliste;
        
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
        <style>
                label.description {
                    display: block;
                }
                div.wrap {
                    max-width: 1200px;
                    margin: 20px 0 0 0;
                    background-image: url(<?php echo $defaultoptions['logo']; ?>);
                    background-position: top right;
                    background-repeat: no-repeat;
                    padding: 0;
                }
                div.piratenkleider-optionen {
                    max-width: 1200px;
                    margin: 0;
                    padding-bottom: 0px;
                    background-image: url(<?php echo get_template_directory_uri()?>/images/schiff-welle.gif);
                    background-position: bottom left;
                    background-repeat: no-repeat;
                }
                p.submit {
                    margin-top: 100px;
                    padding-left: 20px;
                }
                .wrap div.updated {
                    margin-right: 300px;                    
                }
            </style>
	<div class="wrap">
            
            <div class="piratenkleider-optionen">  <!-- begin: .piratenkleider-optionen -->    
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Takelage einstellen: Konfiguration ', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options have been saved.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'piratenkleider_options' ); ?>
			<?php $options = get_option( 'piratenkleider_theme_options' ); 
                            if ( ! isset( $options['slider-slideshowSpeed'] ) )
                                $options['slider-slideshowSpeed'] = $defaultoptions['slider-slideshowSpeed']; 
                            if ( ! isset( $options['slider-animationDuration'] ) )
                                $options['slider-animationDuration'] = $defaultoptions['slider-animationDuration'];
                            if ( ! isset( $options['defaultwerbesticker'] ) )
                                $options['defaultwerbesticker'] = $defaultoptions['defaultwerbesticker'];;
                            if ( ! isset( $options['aktiv-autoren'] ) ) 
                                $options['aktiv-autoren'] = $defaultoptions['aktiv-autoren']; 
                            if ( ! isset( $options['newsletter'] ) ) 
                                $options['newsletter'] = $defaultoptions['newsletter'];
                            if ( ! isset( $options['alle-socialmediabuttons'] ) ) 
                                $options['alle-socialmediabuttons'] = $defaultoptions['alle-socialmediabuttons'];
                            if ( ! isset( $options['aktiv-platzhalterbilder-indexseiten'] ) ) 
                                $options['aktiv-platzhalterbilder-indexseiten'] = $defaultoptions['aktiv-platzhalterbilder-indexseiten'];  
                            if ( ! isset( $options['slider-aktiv'] ) ) 
                                $options['slider-aktiv'] = $defaultoptions['slider-aktiv'];
                            if ( ! isset( $options['slider-defaultwerbeplakate'] ) ) 
                                $options['slider-defaultwerbeplakate'] = $defaultoptions['slider-defaultwerbeplakate'];
                            if ( ! isset( $options['slider-numberarticle'] ) ) 
                                $options['slider-numberarticle'] = $defaultoptions['slider-numberarticle']; 
                            if ( ! isset( $options['feed_twitter_numberarticle'] ) )
                                $options['feed_twitter_numberarticle'] = $defaultoptions['feed_twitter_numberarticle']; 
                             if (!isset($options['num-article-startpage-fullwidth'])) 
                                $options['num-article-startpage-fullwidth'] = $defaultoptions['num-article-startpage-fullwidth'];
                            if (!isset($options['num-article-startpage-halfwidth'])) 
                                $options['num-article-startpage-halfwidth'] = $defaultoptions['num-article-startpage-halfwidth']; 

                            if (!isset($options['url-newsletteranmeldung'])) 
                                $options['url-newsletteranmeldung'] = $defaultoptions['url-newsletteranmeldung'];
	                    if (!isset($options['url-mitgliedwerden'])) 
                                $options['url-mitgliedwerden'] = $defaultoptions['url-mitgliedwerden'];
                            if (!isset($options['url-spenden'])) 
                                $options['url-spenden'] = $defaultoptions['url-spenden'];
                            if (!isset($options['aktiv-defaultseitenbild'])) 
                               $options['aktiv-defaultseitenbild'] = $defaultoptions['aktiv-defaultseitenbild'];
                            if (!isset($options['aktiv-suche'])) 
                               $options['aktiv-suche'] = $defaultoptions['aktiv-suche'];
                            
                            if (!isset($options['teaser-title-maxlength'])) 
                               $options['teaser-title-maxlength'] = $defaultoptions['teaser-title-maxlength'];
                            if (!isset($options['teaser-subtitle'])) 
                               $options['teaser-subtitle'] = $defaultoptions['teaser-subtitle'];
                            if (!isset($options['teaser-title-words'])) 
                               $options['teaser-title-words'] = $defaultoptions['teaser-title-words'];

                             if (!isset($options['aktiv-linkmenu'])) 
                               $options['aktiv-linkmenu'] = $defaultoptions['aktiv-linkmenu'];                                                         
                             if (!isset($options['zeige_subpagesonly'])) 
                                $options['zeige_subpagesonly'] = $defaultoptions['zeige_subpagesonly'];
                             if (!isset($options['zeige_sidebarpagemenu'])) 
                                $options['zeige_sidebarpagemenu'] = $defaultoptions['zeige_sidebarpagemenu'];
                             if (!isset($options['anonymize-user'])) 
                                  $options['anonymize-user'] = $defaultoptions['anonymize-user'];
                             if (!isset($options['aktiv-avatar'])) 
                                  $options['aktiv-avatar'] = $defaultoptions['aktiv-avatar'];   
                             
                             
                             if (!isset($options['teaserlink1-title'])) 
                                  $options['teaserlink1-title'] = $defaultoptions['teaserlink1-title'];   
                             if (!isset($options['teaserlink1-untertitel'])) 
                                  $options['teaserlink1-untertitel'] = $defaultoptions['teaserlink1-untertitel'];   
                             if (!isset($options['teaserlink1-url'])) 
                                  $options['teaserlink1-url'] = $defaultoptions['teaserlink1-url'];   
                             if (!isset($options['teaserlink1-symbol'])) 
                                  $options['teaserlink1-symbol'] = $defaultoptions['teaserlink1-symbol'];   
                             
                             if (!isset($options['teaserlink2-title'])) 
                                  $options['teaserlink2-title'] = $defaultoptions['teaserlink2-title'];   
                             if (!isset($options['teaserlink2-untertitel'])) 
                                  $options['teaserlink2-untertitel'] = $defaultoptions['teaserlink2-untertitel'];   
                             if (!isset($options['teaserlink2-url'])) 
                                  $options['teaserlink2-url'] = $defaultoptions['teaserlink2-url'];   
                             if (!isset($options['teaserlink2-symbol'])) 
                                  $options['teaserlink2-symbol'] = $defaultoptions['teaserlink2-symbol'];  
                             
                             if (!isset($options['teaserlink3-title'])) 
                                  $options['teaserlink3-title'] = $defaultoptions['teaserlink3-title'];   
                             if (!isset($options['teaserlink3-untertitel'])) 
                                  $options['teaserlink3-untertitel'] = $defaultoptions['teaserlink3-untertitel'];   
                             if (!isset($options['teaserlink3-url'])) 
                                  $options['teaserlink3-url'] = $defaultoptions['teaserlink3-url'];   
                             if (!isset($options['teaserlink3-symbol'])) 
                                  $options['teaserlink3-symbol'] = $defaultoptions['teaserlink3-symbol'];  
                             
                             
                             if (!isset($options['stickerlink1-content'])) 
                                $options['stickerlink1-content'] = $defaultoptions['stickerlink1-content'];                                
                             if (!isset($options['stickerlink1-url'])) 
                                $options['stickerlink1-url'] = $defaultoptions['stickerlink1-url'];
                          
                            if (!isset($options['stickerlink2-content'])) 
                                $options['stickerlink2-content'] = $defaultoptions['stickerlink2-content'];
                            if (!isset($options['stickerlink2-url'])) 
                                $options['stickerlink2-url'] = $defaultoptions['stickerlink2-url'];
                            if (!isset($options['stickerlink2-content'])) 
                                $options['stickerlink3-content'] = $defaultoptions['stickerlink3-content'];
                            if (!isset($options['stickerlink3-url'])) 
                                $options['stickerlink3-url'] = $defaultoptions['stickerlink3-url'];
                            if (!isset($options['anonymize-user-commententries'])) 
                                $options['anonymize-user-commententries'] = $defaultoptions['anonymize-user-commententries']; 
                            if (!isset($options['aktiv-commentreplylink'])) 
                                $options['aktiv-commentreplylink'] = $defaultoptions['aktiv-commentreplylink'];                            
                        ?>
			<table class="form-table">
                              
                                <tr valign="top"><th scope="row"><?php _e( 'Default images for pages', 'piratenkleider' ); ?></th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-defaultseitenbild]" name="piratenkleider_theme_options[aktiv-defaultseitenbild]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-defaultseitenbild'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-defaultseitenbild]">
                                                    <?php _e( 'Pictures pages for force, who have defined themselves there is no article image. If no article image exists, a default image is shown.', 'piratenkleider' ); ?>
                                                </label>
					</td>
				</tr>
                                <tr valign="top"><th scope="row"><?php _e( 'Placeholder images', 'piratenkleider' ); ?></th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]" name="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-platzhalterbilder-indexseiten'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]">
                                                    <?php _e( 'Placeholder images for index pages to categories, tags, search and archive ',' pirate clothes' ); ?>
                                                    </label>
					</td>
				</tr>
				
                               <tr valign="top">
                                    <th scope="row"><?php _e( 'headboard', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                              <tr valign="top"><th scope="row"><?php _e( 'Linkmenu', 'piratenkleider' ); ?></th>
                                                <td>
						<input id="piratenkleider_theme_options[aktiv-linkmenu]" name="piratenkleider_theme_options[aktiv-linkmenu]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-linkmenu'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-linkmenu]">
                                                    <?php _e( 'Linkmenu top right, show between search and social media icons', 'piratenkleider' ); ?>
                                                    </label>
                                                </td>
                                    	</tr>
                                             <tr valign="top"><th scope="row"><?php _e( 'Search', 'piratenkleider' ); ?></th>
                                                <td>
						<input id="piratenkleider_theme_options[aktiv-suche]" name="piratenkleider_theme_options[aktiv-suche]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-suche'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-suche]">
                                                    <?php _e( 'Show input mask for the top right search', 'piratenkleider' ); ?>
                                                    </label>
                                                </td>
                                            </tr>
                                           <tr valign="top"><th scope="row"><?php _e( 'Sticker', 'piratenkleider' ); ?></th>
                                                <td>
						<input id="piratenkleider_theme_options[defaultwerbesticker]" name="piratenkleider_theme_options[defaultwerbesticker]" type="checkbox" value="1" <?php checked( '1', $options['defaultwerbesticker'] ); ?> />
						<label  for="piratenkleider_theme_options[defaultwerbesticker]">
                                                    <?php _e( 'Show Sitcker', 'piratenkleider' ); ?>
                                                    </label>
                                                </td>
                                          </tr>
                                           <tr valign="top"><th scope="row"><?php _e( 'Sticker 1', 'piratenkleider' ); ?></th>
                                             <td>
                                                <table>                                                    
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[stickerlink1-content]"> <?php _e( 'Content (Inline-HTML)', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  class="regular-text" id="piratenkleider_theme_options[stickerlink1-content]" 
                                                    type="text" name="piratenkleider_theme_options[stickerlink1-content]" 
                                                    value="<?php esc_attr_e( $options['stickerlink1-content'] ); ?>" /></td>               
                                                    </tr>
                                                    
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[stickerlink1-url]"> <?php _e( 'URL', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  class="regular-text" id="piratenkleider_theme_options[stickerlink1-url]" 
                                                    type="text" name="piratenkleider_theme_options[stickerlink1-url]" 
                                                    value="<?php esc_attr_e( $options['stickerlink1-url'] ); ?>" /></td>               
                                                    </tr>
                                                </table>
                                             </td>                                                 
                                         </tr> 
                                          <tr valign="top"><th scope="row"><?php _e( 'Sticker 2', 'piratenkleider' ); ?></th>
                                             <td>
                                                <table>                                                    
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[stickerlink2-content]"> <?php _e( 'Content (Inline-HTML)', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  class="regular-text" id="piratenkleider_theme_options[stickerlink2-content]" 
                                                    type="text" name="piratenkleider_theme_options[stickerlink2-content]" 
                                                    value="<?php esc_attr_e( $options['stickerlink2-content'] ); ?>" /></td>               
                                                    </tr>
                                                    
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[stickerlink2-url]"> <?php _e( 'URL', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  class="regular-text" id="piratenkleider_theme_options[stickerlink2-url]"
                                                    type="text" name="piratenkleider_theme_options[stickerlink2-url]" 
                                                    value="<?php esc_attr_e( $options['stickerlink2-url'] ); ?>" /></td>               
                                                    </tr>
                                                </table>
                                             </td>                                                 
                                         </tr>
                                         <tr valign="top"><th scope="row"><?php _e( 'Sticker 3', 'piratenkleider' ); ?></th>
                                             <td>
                                                <table>                                                    
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[stickerlink3-content]"> <?php _e( 'Content (Inline-HTML)', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  class="regular-text" id="piratenkleider_theme_options[stickerlink3-content]" 
                                                    type="text" name="piratenkleider_theme_options[stickerlink3-content]" 
                                                    value="<?php esc_attr_e( $options['stickerlink3-content'] ); ?>" /></td>               
                                                    </tr>
                                                    
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[stickerlink3-url]"> <?php _e( 'URL', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  class="regular-text" id="piratenkleider_theme_options[stickerlink3-url]" 
                                                    type="text" name="piratenkleider_theme_options[stickerlink3-url]" 
                                                    value="<?php esc_attr_e( $options['stickerlink3-url'] ); ?>" /></td>               
                                                    </tr>
                                                </table>
                                             </td>                                                 
                                         </tr>
                                        </table>
                                </td>
				</tr>                                                                                                  
                                
                                
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Sidebar', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>                                             
                                            <tr valign="top"><th scope="row"><?php _e( 'side box', 'piratenkleider' ); ?></th>
                                                    <td>
                                                            <input id="piratenkleider_theme_options[zeige_subpagesonly]" name="piratenkleider_theme_options[zeige_subpagesonly]" type="checkbox" value="1" <?php checked( '1', $options['zeige_subpagesonly'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[zeige_subpagesonly]">
                                                                <?php _e( ' Show in the display of pages in the sidebar to the right, only the current submenu. When disabled, the full menu is shown. This is for websites with many pages not suitable.', 'piratenkleider' ); ?>
                                                               </label>

                                                            <p><?php _e( 'Alternative Option:', 'piratenkleider' ); ?>:</p>
                                                            <input id="piratenkleider_theme_options[zeige_sidebarpagemenu]" name="piratenkleider_theme_options[zeige_sidebarpagemenu]" type="checkbox" value="1" <?php checked( '1', $options['zeige_sidebarpagemenu'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[zeige_sidebarpagemenu]">
                                                                <?php _e( 'View page in the sidebar menu.', 'piratenkleider' ); ?>                                                                
                                                            </label>

                                                    </td>
                                            </tr>

                                            <tr valign="top"><th scope="row"><?php _e( 'Newsletter', 'piratenkleider' ); ?></th>
                                                    <td>
                                                            <input id="piratenkleider_theme_options[newsletter]" name="piratenkleider_theme_options[newsletter]" type="checkbox" value="1" <?php checked( '1', $options['newsletter'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[newsletter]">
                                                                <?php _e( 'Input Mask Show', 'piratenkleider' ); ?>
                                                                </label>
                                                    </td>
                                            </tr>
                                            
                                            <tr valign="top"><th scope="row"><?php _e( 'Poster Slider activate', 'piratenkleider' ); ?></th>
                                        	<td>
                                            	<input id="piratenkleider_theme_options[slider-defaultwerbeplakate]" name="piratenkleider_theme_options[slider-defaultwerbeplakate]" type="checkbox" value="1" <?php checked( '1', $options['slider-defaultwerbeplakate'] ); ?> />
						<label for="piratenkleider_theme_options[slider-defaultwerbeplakate]">
                                                    <?php _e( 'Slider, the advertising posters (Sidebar right column) are shown.
                                                     <br> selection of poster images can be adjusted to the default images. ',' pirate clothes' ); ?>
                                                    </label>
                                                </td>
                                            </tr>
                                            
                                         <tr valign="top"><th scope="row"><?php _e( 'Teaser link 1', 'piratenkleider' ); ?></th>
                                             <td>

                                                <table>
                                                    <tr>
                                                    <th><label  for="piratenkleider_theme_options[teaserlink1-symbol]"><?php _e( 'Symbol', 'piratenkleider' ); ?>:</label></th>
                                                    <td><select name="piratenkleider_theme_options[teaserlink1-symbol]">
                                                    <?php
                                                    foreach($defaultplakate_textsymbolliste as $i => $value) {
                                                    echo '<option style="font-size: 18px; width: 24px; text-align: center;" value="'.$i.'"';
                                                    if ($i == $options['teaserlink1-symbol']) {
                                                    echo ' selected="selected"'; 
                                                    }
                                                    echo '>&#x'.$value.';</option>';
                                                    } 
                                                    ?>
                                                    </select></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[teaserlink1-title]"> <?php _e( 'Title', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  style="width: 20em;" id="piratenkleider_theme_options[teaserlink1-title]" maxlength="40"
                                                    type="text" name="piratenkleider_theme_options[teaserlink1-title]" 
                                                    value="<?php esc_attr_e( $options['teaserlink1-title'] ); ?>" /></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label  for="piratenkleider_theme_options[teaserlink1-untertitel]">
                                                    <?php _e( 'Subtitle', 'piratenkleider' ); ?>:
                                                    </label></th>
                                                    <td> <input style="width: 20em;" id="piratenkleider_theme_options[teaserlink1-untertitel]" maxlength="40"
                                                    type="text" name="piratenkleider_theme_options[teaserlink1-untertitel]" 
                                                    value="<?php esc_attr_e( $options['teaserlink1-untertitel'] ); ?>" /></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[teaserlink1-url]"> <?php _e( 'URL', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  class="regular-text" id="piratenkleider_theme_options[teaserlink1-url]" 
                                                    type="text" name="piratenkleider_theme_options[teaserlink1-url]" 
                                                    value="<?php esc_attr_e( $options['teaserlink1-url'] ); ?>" /></td>               
                                                    </tr>
                                                </table>
                                             </td>                                                 
                                         </tr>     

                                          <tr valign="top"><th scope="row"><?php _e( 'Teaser link 2', 'piratenkleider' ); ?></th>
                                             <td>

                                                <table>
                                                    <tr>
                                                    <th><label  for="piratenkleider_theme_options[teaserlink2-symbol]"><?php _e( 'Symbol', 'piratenkleider' ); ?>:</label></th>
                                                    <td><select name="piratenkleider_theme_options[teaserlink2-symbol]">
                                                    <?php
                                                    foreach($defaultplakate_textsymbolliste as $i => $value) {
                                                    echo '<option style="font-size: 18px; width: 24px; text-align: center;" value="'.$i.'"';
                                                    if ($i == $options['teaserlink2-symbol']) {
                                                    echo ' selected="selected"'; 
                                                    }
                                                    echo '>&#x'.$value.';</option>';
                                                    } 
                                                    ?>
                                                    </select></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[teaserlink2-title]"> <?php _e( 'Title', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input style="width: 20em;" id="piratenkleider_theme_options[teaserlink2-title]" maxlength="40"
                                                    type="text" name="piratenkleider_theme_options[teaserlink2-title]" 
                                                    value="<?php esc_attr_e( $options['teaserlink2-title'] ); ?>" /></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label  for="piratenkleider_theme_options[teaserlink2-untertitel]">
                                                    <?php _e( 'Subtitle', 'piratenkleider' ); ?>:
                                                    </label></th>
                                                    <td> <input style="width: 20em;" id="piratenkleider_theme_options[teaserlink2-untertitel]"  maxlength="40"
                                                    type="text" name="piratenkleider_theme_options[teaserlink2-untertitel]" 
                                                    value="<?php esc_attr_e( $options['teaserlink2-untertitel'] ); ?>" /></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[teaserlink2-url]"> <?php _e( 'URL', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input id="piratenkleider_theme_options[teaserlink2-url]" 
                                                    type="text"  class="regular-text" name="piratenkleider_theme_options[teaserlink2-url]" 
                                                    value="<?php esc_attr_e( $options['teaserlink2-url'] ); ?>" /></td>               
                                                    </tr>
                                                </table>
                                             </td>                                                 
                                         </tr> 
                                          <tr valign="top"><th scope="row"><?php _e( 'Teaser link 3', 'piratenkleider' ); ?></th>
                                             <td>

                                                <table>
                                                    <tr>
                                                    <th><label  for="piratenkleider_theme_options[teaserlink3-symbol]"><?php _e( 'Symbol', 'piratenkleider' ); ?>:</label></th>
                                                    <td><select name="piratenkleider_theme_options[teaserlink3-symbol]">
                                                    <?php
                                                    foreach($defaultplakate_textsymbolliste as $i => $value) {
                                                    echo '<option style="font-size: 18px; width: 24px; text-align: center;" value="'.$i.'"';
                                                    if ($i == $options['teaserlink3-symbol']) {
                                                    echo ' selected="selected"'; 
                                                    }
                                                    echo '>&#x'.$value.';</option>';
                                                    } 
                                                    ?>
                                                    </select></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[teaserlink3-title]"> <?php _e( 'Title', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input style="width: 20em;" id="piratenkleider_theme_options[teaserlink3-title]" maxlength="40"
                                                    type="text" name="piratenkleider_theme_options[teaserlink3-title]" 
                                                    value="<?php esc_attr_e( $options['teaserlink3-title'] ); ?>" /></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label  for="piratenkleider_theme_options[teaserlink3-untertitel]">
                                                    <?php _e( 'Subtitle', 'piratenkleider' ); ?>:
                                                    </label></th>
                                                    <td> <input  style="width: 20em;" id="piratenkleider_theme_options[teaserlink3-untertitel]"  maxlength="40"
                                                    type="text" name="piratenkleider_theme_options[teaserlink3-untertitel]" 
                                                    value="<?php esc_attr_e( $options['teaserlink3-untertitel'] ); ?>" /></td>               
                                                    </tr>
                                                    <tr>
                                                    <th><label for="piratenkleider_theme_options[teaserlink3-url]"> <?php _e( 'URL', 'piratenkleider' ); ?>:</label></th>
                                                    <td><input  class="regular-text" id="piratenkleider_theme_options[teaserlink3-url]"
                                                    type="text" name="piratenkleider_theme_options[teaserlink3-url]" 
                                                    value="<?php esc_attr_e( $options['teaserlink3-url'] ); ?>" /></td>               
                                                    </tr>
                                                </table>
                                             </td>                                                 
                                         </tr> 


 
                                        </table>
                                </td>
				</tr>  
                                
                                
				<tr valign="top">
                                    <th scope="row"><?php _e( 'Home', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                            <tr valign="top"><th scope="row"><?php _e( 'Contributions over full width', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[num-article-startpage-fullwidth]">
                                                        <?php
                                                                    $selected = $options['num-article-startpage-fullwidth'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="0" <?php if ($selected == '0') { echo 'selected="selected"'; }?>>0</option>
                                                        <option style="padding-right: 10px;" value="1" <?php if ($selected == '1') { echo 'selected="selected"'; }?>>1</option>
                                                        <option style="padding-right: 10px;" value="2" <?php if ($selected == '2') { echo 'selected="selected"'; }?>>2</option>
                                                        <option style="padding-right: 10px;" value="3" <?php if ($selected == '3') { echo 'selected="selected"'; }?>>3</option>
                                                        <option style="padding-right: 10px;" value="4" <?php if ($selected == '4') { echo 'selected="selected"'; }?>>4</option>
                                                        <option style="padding-right: 10px;" value="5" <?php if ($selected == '5') { echo 'selected="selected"'; }?>>5</option>
                                                       						
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[num-article-startpage-fullwidth]">
                                                       <?php _e( 'Number of posts that go over the entire width of content.', 'piratenkleider' ); ?> 
                                                    </label>
                                            </td>
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Posts about half the width', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[num-article-startpage-halfwidth]">
                                                        <?php
                                                                    $selected = $options['num-article-startpage-halfwidth'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="0" <?php if ($selected == '0') { echo 'selected="selected"'; }?>>0</option>
                                                        <option style="padding-right: 10px;" value="2" <?php if ($selected == '2') { echo 'selected="selected"'; }?>>2</option>                                                        
                                                        <option style="padding-right: 10px;" value="4" <?php if ($selected == '4') { echo 'selected="selected"'; }?>>4</option>
                                                        <option style="padding-right: 10px;" value="6" <?php if ($selected == '6') { echo 'selected="selected"'; }?>>6</option>
                                                        <option style="padding-right: 10px;" value="8" <?php if ($selected == '8') { echo 'selected="selected"'; }?>>8</option>                                                       					
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[num-article-startpage-halfwidth]">
                                                        <?php _e( 'Number of posts that are displayed in columns, each with two articles side by side.', 'piratenkleider' ); ?>
                                                        
                                                    </label>
                                            </td>
                                            </tr>
                                        </table>
                                    </td>
                                 </tr>
				 <tr valign="top">
                                    <th scope="row"><?php _e( 'Social Media', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                            <tr valign="top"><th scope="row"><?php _e( 'Social Media Buttons', 'piratenkleider' ); ?></th>
                                        	<td>
						<input id="piratenkleider_theme_options[alle-socialmediabuttons]" name="piratenkleider_theme_options[alle-socialmediabuttons]" type="checkbox" value="1" <?php checked( '1', $options['alle-socialmediabuttons'] ); ?> />
						<label for="piratenkleider_theme_options[alle-socialmediabuttons]">
                                                    <?php _e( ' Show buttons. <br> Note: It will be shown only the buttons are defined for which the following entry fields addresses.', 'piratenkleider' ); ?>                                                   
                                                </label>
                                                </td>
                                            </tr>  
                                            
                                            
                                          <tr valign="top"><th scope="row">Facebook</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_facebook]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_facebook]" value="<?php esc_attr_e( $options['social_facebook'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_facebook]">
                                                <?php _e( 'URL including http:// for Facebook <br> For example: <code> http://www.facebook.com/PiratenparteiDeutschland </code>', 'piratenkleider' ); ?>
                                   
                                                    
                                                </label>
                                                
					</td>					
                                        </tr>
                                        
                                        
                                        <tr valign="top"><th scope="row">Twitter</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_twitter]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_twitter]" value="<?php esc_attr_e( $options['social_twitter'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_twitter]">
                                                <?php _e( 'URL including http:// Twitter page for <br> For example: # <code> https://twitter.com/ / pirate party </code>', 'piratenkleider' ); ?>
                                                    
                                                </label>
					</td>					
                                        </tr>
                                        
                                        <tr valign="top"><th scope="row">YouTube</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_youtube]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_youtube]" value="<?php esc_attr_e( $options['social_youtube'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_youtube]">
                                                <?php _e( 'URL including http:// YouTube page to <br> For example: <code> http://www.youtube.com/user/piratenpartei </code>', 'piratenkleider' ); ?>
                                                    
                                                </label>
					</td>					
                                        </tr>
                                      
                                        <tr valign="top"><th scope="row">G+</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_gplus]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_gplus]" value="<?php esc_attr_e( $options['social_gplus'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_gplus]">
                                                <?php _e( 'URL including http:// for G + page <br> For example: <code> https://plus.google.com/u/0/107862983960150496076/posts </code>', 'piratenkleider' ); ?>
                                               
                                                </label>
					</td>					
                                        </tr>
                                        
                                         <tr valign="top"><th scope="row">Diaspora</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_diaspora]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_diaspora]" value="<?php esc_attr_e( $options['social_diaspora'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_diaspora]">
                                                <?php _e( 'URL including http:// diaspora to page <br> For example: <code> https://joindiaspora.com/u/piratenpartei </code>', 'piratenkleider' ); ?>
                                                   
                                                </label>
                                            </td>					
                                            </tr>

                                            <tr valign="top"><th scope="row">Identica</th>
                                            <td>
                                            <input id="piratenkleider_theme_options[social_identica]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_identica]" value="<?php esc_attr_e( $options['social_identica'] ); ?>" />
                                            <label class="description" for="piratenkleider_theme_options[social_identica]">
                                            <?php _e( 'URL including http:// Identica on page <br> For example: <code> http://identi.ca/piratenpartei </code>   ', 'piratenkleider' ); ?>
                                               
                                            </label>
                                            </td>					
                                             </tr>
                                             <tr valign="top"><th scope="row">Flickr</th>
                                            <td>
                                            <input id="piratenkleider_theme_options[social_flickr]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_flickr]" value="<?php esc_attr_e( $options['social_flickr'] ); ?>" />
                                            <label class="description" for="piratenkleider_theme_options[social_flickr]">
                                            <?php _e( 'URL including http:// to Flickr page', 'piratenkleider' ); ?>                                                
                                            </label>
                                            </td>					
                                             </tr>
                                             <tr valign="top"><th scope="row">Delicious</th>
                                            <td>
                                            <input id="piratenkleider_theme_options[social_delicious]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_delicious]" value="<?php esc_attr_e( $options['social_delicious'] ); ?>" />
                                            <label class="description" for="piratenkleider_theme_options[social_delicious]">
                                            <?php _e( 'URL including http:// page to Delicious', 'piratenkleider' ); ?>
                                            </label>
                                            </td>					
                                             </tr>
                                        </table>                                                                                
                                    </td>                                    
                                </tr>                                   
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Twitter Feed', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
			
                                        
                                         <tr valign="top"><th scope="row"><?php _e( 'Twitter Username', 'piratenkleider' ); ?></th>
                                          <td>
						<input id="piratenkleider_theme_options[feed_twitter]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[feed_twitter]" value="<?php esc_attr_e( $options['feed_twitter'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[feed_twitter]"><?php _e( 'The pure Twitter username', 'piratenkleider' ); ?></label>
					</td>					
                                        </tr>
                                         <tr valign="top"><th scope="row"><?php _e( 'Maximum number of Twitter messages', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[feed_twitter_numberarticle]">
                                                        <?php
                                                                    $selected = $options['feed_twitter_numberarticle'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="2" <?php if ($selected ==2) { echo 'selected="selected"'; }?>>2</option>
                                                        <option style="padding-right: 10px;" value="3" <?php if ($selected ==3) { echo 'selected="selected"'; }?>>3</option>
                                                        <option style="padding-right: 10px;" value="4" <?php if ($selected ==4) { echo 'selected="selected"'; }?>>4</option>
                                                        <option style="padding-right: 10px;" value="5" <?php if ($selected ==5) { echo 'selected="selected"'; }?>>5</option>
                                                        <option style="padding-right: 10px;" value="6" <?php if ($selected ==6) { echo 'selected="selected"'; }?>>6</option>							
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[feed_twitter_numberarticle]"><?php _e( 'How many Twitter messages are to be shown up', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>             

                                         </table>                                                                                
                                    </td>                                    
                                </tr>                            
				
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Slider', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                             <tr valign="top"><th scope="row"><?php _e( 'Slider activate', 'piratenkleider' ); ?></th>
                                        	<td>
                                            	<input id="piratenkleider_theme_options[slider-aktiv]" name="piratenkleider_theme_options[slider-aktiv]" type="checkbox" value="1" <?php checked( '1', $options['slider-aktiv'] ); ?> />
						<label for="piratenkleider_theme_options[slider-aktiv]">
                                                    <?php _e( ' Slider in the teaser section on the home turn.
                                                   <br> selection of poster images can be adjusted to the default images.', 'piratenkleider' ); ?>
                                                   </label>
                                                </td>
                                            </tr>
                                             
                                             <tr valign="top"><th scope="row"><?php _e( 'Category', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[slider-catid]">
                                                        <?php
                                                         $selected = $options['slider-catid'];      
                                                         if (!isset($selected) ) $selected ="Slider";  
                                                        $args=array(
                                                        'orderby' => 'name',
                                                        'order' => 'ASC'
                                                        );
                                                        
                                                        $categories=get_categories($args);
                                                        foreach($categories as $category) {
                                                            echo '<option value="'.$category->cat_ID.'"';
                                                            if ($category->cat_ID == $selected) {
                                                                 echo ' selected="selected"'; 
                                                            }
                                                            echo '>'.$category->name.' ('.$category->count.' Eintr&auml;ge)</option>';
                                                        } 
                                                        ?>
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[slider-catid]"><?php _e( 'The slider which category is to be taken', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>

                                            <tr valign="top"><th scope="row"><?php _e( 'Maximum number of items', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[slider-numberarticle]">
                                                        <?php
                                                                    $selected = $options['slider-numberarticle'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="2" <?php if ($selected ==2) { echo 'selected="selected"'; }?>>2</option>
                                                        <option style="padding-right: 10px;" value="3" <?php if ($selected ==3) { echo 'selected="selected"'; }?>>3</option>
                                                        <option style="padding-right: 10px;" value="4" <?php if ($selected ==4) { echo 'selected="selected"'; }?>>4</option>
                                                        <option style="padding-right: 10px;" value="5" <?php if ($selected ==5) { echo 'selected="selected"'; }?>>5</option>
                                                        <option style="padding-right: 10px;" value="6" <?php if ($selected ==6) { echo 'selected="selected"'; }?>>6</option>							
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[slider-numberarticle]">
                                                        <?php _e( 'How many slides are to be shown up', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Animation type', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[slider-animationType]">
                                                        <?php
                                                                    $selected = $options['slider-animationType'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="fade" <?php if ($selected == 'fade') { echo 'selected="selected"'; }?>>fade</option>
                                                        <option style="padding-right: 10px;" value="slide" <?php if ($selected == 'slide') { echo 'selected="selected"'; }?>>slide</option>
                                                       						
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[slider-animationType]">
                                                        <?php _e( 'How to change the slideshow look visually', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Direction', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[slider-Direction]">
                                                        <?php
                                                                    $selected = $options['slider-Direction'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="horizontal" <?php if ($selected == 'horizontal') { echo 'selected="selected"'; }?>>horizontal</option>
                                                        <option style="padding-right: 10px;" value="vertical" <?php if ($selected == 'vertical') { echo 'selected="selected"'; }?>>vertical</option>
                                                       						
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[slider-Direction]"><?php _e( 'Where images are to appear', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>                                            
                                            <tr valign="top"><th scope="row"><?php _e( 'Time frame rates', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 5em;"  id="piratenkleider_theme_options[slider-slideshowSpeed]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[slider-slideshowSpeed]" value="<?php esc_attr_e( $options['slider-slideshowSpeed'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[slider-slideshowSpeed]"><?php _e( 'Speed of the image change in milliseconds', 'piratenkleider' ); ?></label>
                                                    </td>

                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Animation duration', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 5em;" id="piratenkleider_theme_options[slider-animationDuration]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[slider-animationDuration]" value="<?php esc_attr_e( $options['slider-animationDuration'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[slider-animationDuration]"><?php _e( 'Speed of the animation / image fading during transition in milliseconds', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>

                                            
                                            <tr valign="top"><th scope="row"><?php _e( 'Significantly title for teaser', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 15em;" id="piratenkleider_theme_options[teaser-subtitle]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-subtitle]" value="<?php esc_attr_e( $options['teaser-subtitle'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-subtitle]"><?php _e( 'This text appears above the title', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Maximum text length of the song in the teaser', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 3em;" id="piratenkleider_theme_options[teaser-title-maxlength]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-title-maxlength]" value="<?php esc_attr_e( $options['teaser-title-maxlength'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-title-maxlength]"><?php _e( 'As the title may be long in total, before being cut', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Number of words in the title Teaser', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 3em;" id="piratenkleider_theme_options[teaser-title-words]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-title-words]" value="<?php esc_attr_e( $options['teaser-title-words'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-title-words]"><?php _e( 'Number of words in the teaser, the maximum text length limits this value.', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            
                                            
                                                         
                                        </table>                                                                                
                                    </td>                                    
                                </tr>    
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Special', 'piratenkleider' ); ?></th>
                                    <td>

                                        <table>                                
                                     
                                        <tr valign="top"><th scope="row"><?php _e( 'Newsletter', 'piratenkleider' ); ?></th>
                                          <td>
						<input style="width: 40em;" id="piratenkleider_theme_options[url-newsletteranmeldung]" class="regular-text" type="text"  name="piratenkleider_theme_options[url-newsletteranmeldung]" value="<?php esc_attr_e( $options['url-newsletteranmeldung'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[url-newsletteranmeldung]">                                                   
                                                    <?php _e( ' URL, including http://, to the side on which one can be added to newsletter.', 'piratenkleider' ); ?>
                                                    Default: <code><?php echo $defaultoptions['url-newsletteranmeldung']; ?></code>
                                                </label>
					</td>					
                                        </tr>
                                       </table>  
                                       
                                            
                                            
                                    </td>                                    
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Meta-data', 'piratenkleider' ); ?></th>
                                    <td>

                                        <table>                                
                                         <tr valign="top"><th scope="row"><?php _e( 'Author', 'piratenkleider' ); ?></th>
                                              <td>
                                                        <input id="piratenkleider_theme_options[meta-author]" class="regular-text" type="text"  name="piratenkleider_theme_options[meta-author]" value="<?php esc_attr_e( $options['meta-author'] ); ?>" />
                                                        <label class="description" for="piratenkleider_theme_options[meta-author]"><?php _e( 'Optional author-specified in the meta tag of each page', 'piratenkleider' ); ?></label>
                                                </td>					
                                        </tr>
                                         <tr valign="top"><th scope="row"><?php _e( 'Description', 'piratenkleider' ); ?></th>
                                              <td>
                                                        <input id="piratenkleider_theme_options[meta-description]" class="regular-text" type="text"  name="piratenkleider_theme_options[meta-description]" value="<?php esc_attr_e( $options['meta-description'] ); ?>" />
                                                        <label class="description" for="piratenkleider_theme_options[meta-description]"><?php _e( 'Optional description text in the meta tag of each page (for all). If more than 140 characters long, if set.', 'piratenkleider' ); ?></label>
                                                </td>					
                                        </tr>
                                        <tr valign="top"><th scope="row"><?php _e( 'Keywords', 'piratenkleider' ); ?></th>
                                          <td>
						<input id="piratenkleider_theme_options[meta-keywords]" class="regular-text" type="text" name="piratenkleider_theme_options[meta-keywords]" value="<?php esc_attr_e( $options['meta-keywords'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[meta-keywords]"><?php _e( 'Optional key words in the Meta tag of each page (for all). Separated by commas. Key words should actually occur.', 'piratenkleider' ); ?></label>
					</td>					
                                        </tr>
                                       </table>  
                                        <p>
                                            <?php _e(  'Note: These figures appear on all pages and articles from the site. this
                                             is not always useful (especially for keywords and description).
                                             Should also SEO plug-ins, such as wpSEO o.a. be in use,
                                             These figures should also remain unfilled.  ', 'piratenkleider' ); ?>
                                                                                                                                                                             
                                        </p>
                                    </td>                                    
                                </tr>    
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Security & Anonymity', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                        <tr valign="top"><th scope="row"><?php _e( 'Authors show', 'piratenkleider' ); ?></th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-autoren]" name="piratenkleider_theme_options[aktiv-autoren]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-autoren'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-autoren]"><?php _e( 'n the display of articles and the authors show link.', 'piratenkleider' ); ?></label>
					</td>
                                        </tr>
                                        <tr valign="top"><th scope="row"><?php _e( 'Anonymous user comments', 'piratenkleider' ); ?></th>
					<td>
						<input id="piratenkleider_theme_options[anonymize-user]" name="piratenkleider_theme_options[anonymize-user]" type="checkbox" value="1" <?php checked( '1', $options['anonymize-user'] ); ?> />
						<label  for="piratenkleider_theme_options[anonymize-user]"><?php _e( 'IP address and user agent string empty, the entry of e-mail addresses will be prevented', 'piratenkleider' ); ?></label>

                                                <p> <?php _e( '<b> Note: </ b> This option also disables the Avatar and Display
                                                     sets the comment setting in Settings-talk so
                                                     users to enter a name and e-mail addresses have more.', 'piratenkleider' ); ?></p>
                                                
                                                <p><?php _e( 'In this case, offered comment fields:', 'piratenkleider' ); ?>
                                                  
                                                </p>   
                                                <select name="piratenkleider_theme_options[anonymize-user-commententries]">
                                                        <?php 
                                                                    $selected = $options['anonymize-user-commententries'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="0" <?php if ($selected == '0') { echo 'selected="selected"'; }?>>Name, URL,  E-Mail (Wordpress-Default)</option>					
                                                        <option style="padding-right: 10px;" value="1" <?php if ($selected == '1') { echo 'selected="selected"'; }?>>Name</option>
                                                        <option style="padding-right: 10px;" value="2" <?php if ($selected == '2') { echo 'selected="selected"'; }?>>Name, URL</option>
                                                       	
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[anonymize-user-commententries]"><?php _e( 'Offers commentary on voluntary input fields', 'piratenkleider' ); ?></label>

					</td>
                                        </tr>
                                        <tr valign="top"><th scope="row">Avatare anzeigen</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-avatar]" name="piratenkleider_theme_options[aktiv-avatar]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-avatar'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-avatar]"><?php _e( 'If you have comments avatar images are retrieved using Gravatar and other services. However, theoretically this allows a tracking of these services', 'piratenkleider' ); ?></label>
					</td>
                                        </tr>                                        
                                       </table>                                         
                                    </td>                                    
                                </tr>    
                                  <tr valign="top">
                                    <th scope="row"><?php _e( 'Other', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                        <tr valign="top"><th scope="row"><?php _e( 'Reply to comments Links', 'piratenkleider' ); ?></th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-commentreplylink]" name="piratenkleider_theme_options[aktiv-commentreplylink]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-commentreplylink'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-commentreplylink]"><?php _e( 'In the display of comments, among them a separate comment link is added, which allows the answers to the comment. This can lead to use of this area as a forum in which it is last but not about the actual post.', 'piratenkleider' ); ?></label>
					</td>
                                        </tr>
                                </table>                                         
                                    </td>                                    
                                </tr>             
                                        
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'piratenkleider' ); ?>" />
			</p>
		</form>               
	</div>
            
        </div> <!-- end: .piratenkleider-optionen -->      
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
    global $defaultoptions;

	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['defaultwerbesticker'] ) )
		$input['defaultwerbesticker'] = 0;
	$input['defaultwerbesticker'] = ( $input['defaultwerbesticker'] == 1 ? 1 : 0 );    
        
        if ( ! isset( $input['aktiv-defaultseitenbild'] ) )
		$input['aktiv-defaultseitenbild'] = 0;
	$input['aktiv-defaultseitenbild'] = ( $input['aktiv-defaultseitenbild'] == 1 ? 1 : 0 );    
        if ( ! isset( $input['aktiv-suche'] ) )
		$input['aktiv-suche'] = 0;
	$input['aktiv-suche'] = ( $input['aktiv-suche'] == 1 ? 1 : 0 ); 
        if ( ! isset( $input['aktiv-linkmenu'] ) )
		$input['aktiv-linkmenu'] = 0;
	$input['aktiv-linkmenu'] = ( $input['aktiv-linkmenu'] == 1 ? 1 : 0 );
        
        if ( ! isset( $input['aktiv-commentreplylink'] ) )
		$input['aktiv-commentreplylink'] = 0;
	$input['aktiv-commentreplylink'] = ( $input['aktiv-commentreplylink'] == 1 ? 1 : 0 );
        if ( ! isset( $input['anonymize-user'] ) )
		$input['anonymize-user'] = 0;
	$input['anonymize-user'] = ( $input['anonymize-user'] == 1 ? 1 : 0 );
            
        
        if ( ! isset( $input['aktiv-autoren'] ) )
		$input['aktiv-autoren'] = 0;
	$input['aktiv-autoren'] = ( $input['aktiv-autoren'] == 1 ? 1 : 0 );    

         if ( ! isset( $input['aktiv-avatar'] ) )
		$input['aktiv-avatar'] = 0;
	$input['aktiv-avatar'] = ( $input['aktiv-avatar'] == 1 ? 1 : 0 );    
        
        if ($input['anonymize-user']==1) {
            $input['aktiv-avatar'] = 0;
        }
        $options = get_option( 'piratenkleider_theme_options' );
        if (!isset($options['anonymize-user'])) 
            $options['anonymize-user'] = $defaultoptions['anonymize-user'];
     
                               
        if (($input['anonymize-user']==0) && ($options['anonymize-user']==1)) {
            // Zurücksetzen der Sicherheitsoption
             update_option('require_name_email',1);
        }
         if ( ! isset( $input['anonymize-user-commententries'] ) )
		$input['anonymize-user-commententries'] = 0;
	$input['anonymize-user-commententries'] = wp_filter_nohtml_kses( $input['anonymize-user-commententries'] );    
        
	if ( ! isset( $input['zeige_sidebarpagemenu'] ) )
		$input['zeige_sidebarpagemenu'] = 0;
	$input['zeige_sidebarpagemenu'] = ( $input['zeige_sidebarpagemenu'] == 1 ? 1 : 0 );
	if ( ! isset( $input['zeige_subpagesonly'] ) )
		$input['zeige_subpagesonly'] = 0;
	$input['zeige_subpagesonly'] = ( $input['zeige_subpagesonly'] == 1 ? 1 : 0 );        
        
        
	if ( ! isset( $input['newsletter'] ) )
		$input['newsletter'] = 0;
	$input['newsletter'] = ( $input['newsletter'] == 1 ? 1 : 0 );
	if ( ! isset( $input['alle-socialmediabuttons'] ) )
		$input['alle-socialmediabuttons'] = 0;
	$input['alle-socialmediabuttons'] = ( $input['alle-socialmediabuttons'] == 1 ? 1 : 0 );
        
        if ( ! isset( $input['aktiv-platzhalterbilder-indexseiten'] ) )
		$input['aktiv-platzhalterbilder-indexseiten'] = 0;
	$input['aktiv-platzhalterbilder-indexseiten'] = ( $input['aktiv-platzhalterbilder-indexseiten'] == 1 ? 1 : 0 );       
        
        if ( ! isset( $input['slider-aktiv'] ) )
		$input['slider-aktiv'] = 0;
	$input['slider-aktiv'] = ( $input['slider-aktiv'] == 1 ? 1 : 0 );        
         if ( ! isset( $input['slider-defaultwerbeplakate'] ) )
		$input['slider-defaultwerbeplakate'] = 0;
	$input['slider-defaultwerbeplakate'] = ( $input['slider-defaultwerbeplakate'] == 1 ? 1 : 0 );        
        
        if ( ! isset( $input['slider-numberarticle'] ) )
		$input['slider-numberarticle'] = 3;
		
	if ( ! isset( $input['feed_twitter_numberarticle'] ) )
		$input['feed_twitter_numberarticle'] = 3;
		
        $input['slider-slideshowSpeed'] = wp_filter_nohtml_kses( $input['slider-slideshowSpeed'] );
        if ( ! isset( $input['slider-slideshowSpeed'] ) )
		$input['slider-slideshowSpeed'] = 8000;
         $input['slider-animationDuration'] = wp_filter_nohtml_kses( $input['slider-animationDuration'] );
        if ( ! isset( $input['slider-animationDuration'] ) )
		$input['slider-animationDuration'] = 600;       
        $input['slider-catid'] = wp_filter_nohtml_kses( $input['slider-catid'] );
        $input['slider-Direction'] = wp_filter_nohtml_kses( $input['slider-Direction'] );
        $input['slider-animationType'] = wp_filter_nohtml_kses( $input['slider-animationType'] );   
        
        $input['teaser-title-maxlength'] = wp_filter_nohtml_kses( $input['teaser-title-maxlength'] );
        $input['teaser-subtitle'] = wp_filter_nohtml_kses( $input['teaser-subtitle'] );
        $input['teaser-title-words'] = wp_filter_nohtml_kses( $input['teaser-title-words'] );
        
        
        $input['meta-keywords'] = wp_filter_nohtml_kses( $input['meta-keywords'] );
        $input['meta-author'] = wp_filter_nohtml_kses( $input['meta-author'] );
        $input['meta-description'] = wp_filter_nohtml_kses( $input['meta-description'] );
        $input['social_facebook'] = wp_filter_nohtml_kses( $input['social_facebook'] );
        $input['social_twitter'] = wp_filter_nohtml_kses( $input['social_twitter'] );
        $input['social_youtube'] = wp_filter_nohtml_kses( $input['social_youtube'] );
        $input['social_gplus'] = wp_filter_nohtml_kses( $input['social_gplus'] );
        $input['social_diaspora'] = wp_filter_nohtml_kses( $input['social_diaspora'] );
        $input['social_identica'] = wp_filter_nohtml_kses( $input['social_identica'] );
        $input['social_flickr'] = wp_filter_nohtml_kses( $input['social_flickr'] );
        $input['social_delicious'] = wp_filter_nohtml_kses( $input['social_delicious'] );        
        
        
        
        $input['feed_twitter'] = wp_filter_nohtml_kses( $input['feed_twitter'] );
	
        $input['url-newsletteranmeldung'] = esc_url( $input['url-newsletteranmeldung'] );
        $input['url-mitgliedwerden'] = esc_url( $input['url-mitgliedwerden'] );
        $input['url-spenden'] = esc_url( $input['url-spenden'] );
 
        
        
         $input['teaserlink1-title'] =  wp_filter_nohtml_kses( $input['teaserlink1-title'] );                          
         $input['teaserlink1-untertitel'] = wp_filter_nohtml_kses( $input['teaserlink1-untertitel'] );                      
         $input['teaserlink1-url'] = wp_filter_nohtml_kses( $input['teaserlink1-url'] );                 
         $input['teaserlink1-symbol'] = wp_filter_nohtml_kses( $input['teaserlink1-symbol'] );
         
         $input['teaserlink2-title'] =  wp_filter_nohtml_kses( $input['teaserlink2-title'] );                          
         $input['teaserlink2-untertitel'] = wp_filter_nohtml_kses( $input['teaserlink2-untertitel'] );                      
         $input['teaserlink2-url'] = wp_filter_nohtml_kses( $input['teaserlink2-url'] );                 
         $input['teaserlink2-symbol'] = wp_filter_nohtml_kses( $input['teaserlink2-symbol'] );
         
         $input['teaserlink3-title'] =  wp_filter_nohtml_kses( $input['teaserlink3-title'] );                          
         $input['teaserlink3-untertitel'] = wp_filter_nohtml_kses( $input['teaserlink3-untertitel'] );                      
         $input['teaserlink3-url'] = wp_filter_nohtml_kses( $input['teaserlink3-url'] );                 
         $input['teaserlink3-symbol'] = wp_filter_nohtml_kses( $input['teaserlink3-symbol'] );
        
         
         
       

         $input['stickerlink1-url'] = wp_filter_nohtml_kses( $input['stickerlink1-url'] );
         $input['stickerlink2-url'] = wp_filter_nohtml_kses( $input['stickerlink2-url'] );
         $input['stickerlink3-url'] = wp_filter_nohtml_kses( $input['stickerlink3-url'] );

        
	return $input;
}


/**
 * Defaultbilder Optionen
 */
function theme_defaultbilder_do_page() {
   global $defaultbilder_liste;
   global $defaultplakate_liste;
   global $defaultoptions;
   
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
        <style>
                label.description {
                    display: block;
                }
                div.wrap {
                    max-width: 1200px;
                    margin: 20px 0 0 0;
                    background-image: url(<?php echo get_template_directory_uri()?>/images/logo.png);
                    background-position: top right;
                    background-repeat: no-repeat;
                    padding: 0;
                }
                div.piratenkleider-optionen {
                    max-width: 1200px;
                    margin: 0;
                    padding-bottom: 0px;
                    background-image: url(<?php echo get_template_directory_uri()?>/images/schiff-welle.gif);
                    background-position: bottom left;
                    background-repeat: no-repeat;
                }
                p.submit {
                    margin-top: 100px;
                    padding-left: 20px;
                }
                .wrap div.updated {
                    margin-right: 300px;                    
                }
                label.tile {
                    width: 320px;
                    height: 150px;
                    float: left;
                    border: 1px solid #ccc;                    
                    padding: 1px;
                    margin: 5px;
                }
                label.tile:hover {
                    background-color: #eee;
                }
                label.plakattile {
                    width: 160px;
                    height: 250px;
                    float: left;
                    border: 1px solid #ccc;                    
                    padding: 1px;
                    margin: 5px;
                }
                label.plakattile:hover {
                    background-color: #eee;
                }                
            </style>
	<div class="wrap">
            
            <div class="piratenkleider-optionen">  <!-- begin: .piratenkleider-optionen -->    
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Segel setzen: Defaultbilder ', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Default images were stored.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
                    <?php settings_fields( 'piratenkleider_defaultbilder' ); ?>
                    <?php $options = get_option( 'piratenkleider_theme_defaultbilder' ); 
                        $defaultbildsrc = $options['slider-defaultbildsrc']; 
                        $defaultseitenbildsrc = $options['seiten-defaultbildsrc']; 
                      
                        if ( ! isset( $options['plakate-url'] ) )
                          $options['plakate-url'] = $defaultoptions['plakate-url']; 
                        if ( ! isset( $options['plakate-title'] ) )
                          $options['plakate-title'] = $defaultoptions['plakate-title'];                         
                    ?>
                    <table class="form-table">
                     <tr valign="top">
                        <th scope="row"><?php _e( 'Default images for slider', 'piratenkleider' ); ?></th>
                        <td>

                            <?php 
                                if ( ! isset( $checked ) ) $checked = '';
                                foreach ( $defaultbilder_liste as $option ) {


                                        if ( '' != $defaultbildsrc ) {
                                                if ( $defaultbildsrc == $option['src'] ) {
                                                        $checked = "checked=\"checked\"";
                                                } else {
                                                        $checked = '';
                                                }
                                        }
                                        ?>
                                        <label class="tile">                                                                                          
                                               <input type="radio" name="piratenkleider_theme_defaultbilder[slider-defaultbildsrc]" value="<?php esc_attr_e( $option['src'] ); ?>" <?php echo $checked; ?> />                                                                                                 
                                            <?php echo $option['label']?>
                                               <br> 
                                            <img src="<?php echo $option['src'] ?>" style="margin: 5px auto; width: 320px; height: auto;">
                                        </label>
                                <?php } ?>        
                                <br style="clear: left;">     
                                <h3><?php _e( 'Alternate Slider image as a URL', 'piratenkleider' ); ?></h3>
                                 <input id="piratenkleider_theme_defaultbilder[slider-alternativesrc]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[slider-alternativesrc]" value="<?php esc_attr_e( $options['slider-alternativesrc'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[slider-alternativesrc]">
                                <?php _e( 'URL including http:// to the image. This may also have been previously uploaded to the media dialogue.', 'piratenkleider' ); ?>
                                <br>
                                       <?php _e( 'The images should have the following dimensions: ', 'piratenkleider' ); ?>
                                    <?php echo $defaultoptions['thumb-width'].'x'.$defaultoptions['thumb-height'].' Pixel' ?>
                            </label>
                                 <br />
                            </td>
                        </tr>  
                    
                     <tr valign="top">
                        <th scope="row"><?php _e( 'Default images for pages', 'piratenkleider' ); ?></th>
                        <td>

                            <?php 
                                if ( ! isset( $checked ) ) $checked = '';
                                foreach ( $defaultbilder_liste as $option ) {
                                        if ( '' != $defaultseitenbildsrc ) {
                                                if ( $defaultseitenbildsrc == $option['src'] ) {
                                                        $checked = "checked=\"checked\"";
                                                } else {
                                                        $checked = '';
                                                }
                                        }
                                        ?>
                                        <label class="tile">
                                            <input type="radio" name="piratenkleider_theme_defaultbilder[seiten-defaultbildsrc]" value="<?php esc_attr_e( $option['src'] ); ?>" <?php echo $checked; ?> />                                                     
                                            <?php echo $option['label']?>
                                            <br> 
                                            <img src="<?php echo $option['src'] ?>" style="width: 320px; height: auto;">

                                        </label>
                                <?php } ?>        
                                <br style="clear: left;">   
                                <h3><?php _e( 'Alternative page image as the URL', 'piratenkleider' ); ?></h3>
                                <input id="piratenkleider_theme_defaultbilder[seiten-alternativesrc]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[seiten-alternativesrc]" value="<?php esc_attr_e( $options['seiten-alternativesrc'] ); ?>" />
                               <label class="description" for="piratenkleider_theme_defaultbilder[seiten-alternativesrc]">
                                   <?php _e( 'URL including http:// to the image. This may also have been previously uploaded to the media dialogue. ', 'piratenkleider' ); ?>                              
                                <br>

                                <?php _e( 'The images should have the following dimensions: ', 'piratenkleider' ); ?>
                                    <?php echo $defaultoptions['thumb-width'].'x'.$defaultoptions['thumb-height'].' Pixel' ?>
                                   
                              </label>
                                 <br />
                            </td>
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Default posters for Sidebar', 'piratenkleider' ); ?></th>
                        <td>                                                      
                            <?php                                                                                     
                                if ( ! isset( $checked ) ) $checked = '';
                                foreach ( $defaultplakate_liste as $option ) {    
                                    $checked = '';
                                    if (is_array($options['plakate-src'])) {
                                        foreach ($options['plakate-src'] as $current) {                                                                                      
                                            if ($current == $option['src']) {
                                                 $checked = "checked=\"checked\"";                                                                                            
                                                 break;
                                            }                                           ;
                                        }
                                    }                                    
                                     ?>       
                                    <label class="plakattile">
                                        <div style="height: 40px; width: 100%; margin:0 auto; background-color: #F28900; color: white; display: block;">  
                                        <input type="checkbox" name="piratenkleider_theme_defaultbilder[plakate-src][]" value="<?php esc_attr_e( $option['src'] ); ?>" <?php echo $checked; ?> />                                                     
                                        <?php echo $option['label']?>
                                        </div>
                                        <div style="height: 200px; overflow: hidden; margin: 5px auto; width: 150px; padding: 0;">
                                        <img src="<?php echo $option['src'] ?>" style="width: 150px; height: auto;  ">
                                        </div>
                                    </label>
                               <?php } ?>        
                                <br style="clear: left;"> 
                                <p><?php _e( ' These images are shown in the sidebar to the right, if this is about the options (see Slider) also turned on.', 'piratenkleider' ); ?></p>
                                <table>
                                    <tr>
                                        <th><?php _e( 'Optional replacement title', 'piratenkleider' ); ?></th>
                                        <td> <input id="piratenkleider_theme_defaultbilder[plakate-title]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[plakate-title]" value="<?php esc_attr_e( $options['plakate-title'] ); ?>" />
                                        <label class="description" for="piratenkleider_theme_defaultbilder[plakate-title]">
                                           <?php _e( 'This title is used as an alternate text. <br>
                                        As long as no linking occurs, this information is optional, as the poster images then
                                        only "jewelry pictures" and is included on the no side-related content.', 'piratenkleider' ); ?>
                                         </label></td>
                                    </tr>
                                    <tr>
                                        <th><?php _e( 'Optional URL', 'piratenkleider' ); ?></th>
                                        <td> <input id="piratenkleider_theme_defaultbilder[plakate-url]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[plakate-url]" value="<?php esc_attr_e( $options['plakate-url'] ); ?>" />
                                        <label class="description" for="piratenkleider_theme_defaultbilder[plakate-url]">
                                           <?php _e( 'Optional web address to link the posters with an information page', 'piratenkleider' ); ?>
                                         </label></td>
                                    </tr>
                                </table>    
                                
                                
                                <h3><?php _e( 'Own Design Specials:', 'piratenkleider' ); ?></h3>
                                
                                <textarea id="piratenkleider_theme_defaultbilder[plakate-altadressen]" class="large-text" cols="30" rows="5" name="piratenkleider_theme_defaultbilder[plakate-altadressen]"><?php echo esc_textarea( $options['plakate-altadressen'] ); ?></textarea>
				<label class="description" for="piratenkleider_theme_defaultbilder[plakate-altadressen]"><?php _e( 'Addresses alternative poster images', 'piratenkleider' ); ?></label>

                                <p>    
                                    <?php _e( 'Specifying the URL to the image including http://. If there are several, are
                                  each address separated by line breaks. ', 'piratenkleider' ); ?>
                                    <br>
                                    <?php _e( 'The images should have the following dimensions: ', 'piratenkleider' ); ?>
                                    <?php echo $defaultoptions['plakate-width'].'x'.$defaultoptions['plakate-height'].' Pixel' ?>
                                   </p><p>
                                 <?php _e( 'If the images are also provided with a separate title and a web address
                                      This will appear with the "|" character separately in the following order: <code> image URL | Title | Url Webpage </code>', 'piratenkleider' ); ?>
                                <br>
                                    <?php _e( 'example: ', 'piratenkleider' ); ?></p>
                                    <pre>http://www.piratenpartei.de/wp-content/uploads/2012/05/UrheberplakatSH283.jpg|Rechte f&uuml;r Urheber und Nutzer|http://www.kein-programm.de</pre>
                                    <p>
                                <?php _e( 'Default If above posters are clicked, these images also appear.
                                 These images may also have been previously uploaded to the media dialogue.', 'piratenkleider' ); ?>
                                
                                 </p>      
                              </label>
                                 <br />
                            </td>                            
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Icon image for 404 page', 'piratenkleider' ); ?></th>
                        <td>
                            <input id="piratenkleider_theme_defaultbilder[src-default-symbolbild-404]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[src-default-symbolbild-404]" value="<?php esc_attr_e( $options['src-default-symbolbild-404'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[src-default-symbolbild-404]">
                              <?php _e( 'URL for its own 404-page image.', 'piratenkleider' ); ?>
                               <br>
                               <?php _e( 'Default:', 'piratenkleider' ); ?><br>
                               <code><?php echo $defaultoptions['src-default-symbolbild-404']?></code>
                             </label>

                        </td>
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Symbol for category page', 'piratenkleider' ); ?></th>
                        <td>
                            <input id="piratenkleider_theme_defaultbilder[src-default-symbolbild-category]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[src-default-symbolbild-category]" value="<?php esc_attr_e( $options['src-default-symbolbild-category'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[src-default-symbolbild-category]">
                              <?php _e( 'URL for a separate category page image.', 'piratenkleider' ); ?>
                               <br>
                               <?php _e( 'Default:', 'piratenkleider' ); ?><br>
                               <code><?php echo $defaultoptions['src-default-symbolbild-category']?></code>
                             </label>

                        </td>
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Symbolic day side', 'piratenkleider' ); ?></th>
                        <td>
                            <input id="piratenkleider_theme_defaultbilder[src-default-symbolbild-tag]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[src-default-symbolbild-tag]" value="<?php esc_attr_e( $options['src-default-symbolbild-tag'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[src-default-symbolbild-tag]">
                              <?php _e( 'URL for a custom tag page image.', 'piratenkleider' ); ?>
                               <br>
                               <?php _e( 'Default:', 'piratenkleider' ); ?><br>
                               <code><?php echo $defaultoptions['src-default-symbolbild-tag']?></code>
                             </label>

                        </td>
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Symbol for authors page', 'piratenkleider' ); ?></th>
                        <td>
                            <input id="piratenkleider_theme_defaultbilder[src-default-symbolbild-author]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[src-default-symbolbild-author]" value="<?php esc_attr_e( $options['src-default-symbolbild-author'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[src-default-symbolbild-author]">
                              <?php _e( 'URL for its own author page image.', 'piratenkleider' ); ?>
                               <br>
                               <?php _e( 'Default:', 'piratenkleider' ); ?><br>
                               <code><?php echo $defaultoptions['src-default-symbolbild-author']?></code>
                             </label>

                        </td>
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Symbol for archive page', 'piratenkleider' ); ?></th>
                        <td>
                            <input id="piratenkleider_theme_defaultbilder[src-default-symbolbild-archive]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[src-default-symbolbild-archive]" value="<?php esc_attr_e( $options['src-default-symbolbild-archive'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[src-default-symbolbild-archive]">
                              <?php _e( 'URL for an archive page image.', 'piratenkleider' ); ?>
                               <br>
                               <?php _e( 'Default:', 'piratenkleider' ); ?><br>
                               <code><?php echo $defaultoptions['src-default-symbolbild-archive']?></code>
                             </label>

                        </td>
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Symbol for search results page', 'piratenkleider' ); ?></th>
                        <td>
                            <input id="piratenkleider_theme_defaultbilder[src-default-symbolbild-search]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[src-default-symbolbild-search]" value="<?php esc_attr_e( $options['src-default-symbolbild-search'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[src-default-symbolbild-search]">
                              <?php _e( 'URL for a custom search result page image.', 'piratenkleider' ); ?>
                               <br>
                               <?php _e( 'Default:', 'piratenkleider' ); ?><br>
                               <code><?php echo $defaultoptions['src-default-symbolbild-search']?></code>
                             </label>

                        </td>
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Symbol for Template sites', 'piratenkleider' ); ?></th>
                        <td>
                            <input id="piratenkleider_theme_defaultbilder[src-default-symbolbild]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[src-default-symbolbild]" value="<?php esc_attr_e( $options['src-default-symbolbild'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[src-default-symbolbild]">
                              <?php _e( 'URL for a page template image.', 'piratenkleider' ); ?>
                               <br>
                               <?php _e( 'Default:', 'piratenkleider' ); ?><br>
                               <code><?php echo $defaultoptions['src-default-symbolbild']?></code>
                             </label>

                        </td>
                        </tr>
             </table>

            <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'piratenkleider' ); ?>" />
            </p>
        </form>               
	</div>
            
        </div> <!-- end: .piratenkleider-optionen -->      
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_defaultbilder_validate( $input ) {
	global $defaultbilder_liste;
        global $defaultplakate_liste;
	global $defaultoptions;
        
        $input['slider-alternativesrc'] = wp_filter_nohtml_kses( $input['slider-alternativesrc'] );            
              
        
        $input['slider-defaultbildsrc'] = wp_filter_nohtml_kses( $input['slider-defaultbildsrc'] );       
        if ($input['slider-alternativesrc'] != '') {            
            $input['slider-defaultbildsrc'] = $input['slider-alternativesrc'];
        }
        $input['seiten-alternativesrc'] = wp_filter_nohtml_kses( $input['seiten-alternativesrc'] );            
        $input['seiten-defaultbildsrc'] = wp_filter_nohtml_kses( $input['seiten-defaultbildsrc'] );       
        if ($input['seiten-alternativesrc'] != '') {            
            $input['seiten-defaultbildsrc'] = $input['seiten-alternativesrc'];
        }
        $input['plakate-altadressen'] = wp_filter_post_kses( $input['plakate-altadressen'] );
        $input['plakate-url'] = wp_filter_nohtml_kses( $input['plakate-url'] );        
        $input['plakate-title'] = wp_filter_nohtml_kses( $input['plakate-title'] );  
        
        $input['src-default-symbolbild-404'] = wp_filter_nohtml_kses( $input['src-default-symbolbild-404'] ); 
        $input['src-default-symbolbild-archive'] = wp_filter_nohtml_kses( $input['src-default-symbolbild-archive'] );
        $input['src-default-symbolbild-author'] = wp_filter_nohtml_kses( $input['src-default-symbolbild-author'] );
        $input['src-default-symbolbild-category'] = wp_filter_nohtml_kses( $input['src-default-symbolbild-category'] );
        $input['src-default-symbolbild-tag'] = wp_filter_nohtml_kses( $input['src-default-symbolbild-tag'] );
        $input['src-default-symbolbild-search'] = wp_filter_nohtml_kses( $input['src-default-symbolbild-search'] );
        $input['src-default-symbolbild'] = wp_filter_nohtml_kses( $input['src-default-symbolbild'] );   
     
        if (strlen(trim($input['src-default-symbolbild-404']))<5) {
            $input['src-default-symbolbild-404'] = $defaultoptions['src-default-symbolbild-404'];
        }
        if (strlen(trim($input['src-default-symbolbild-archive']))<5) {
            $input['src-default-symbolbild-archive'] = $defaultoptions['src-default-symbolbild-archive'];
        }
        if (strlen(trim($input['src-default-symbolbild-author']))<5) {
            $input['src-default-symbolbild-author'] = $defaultoptions['src-default-symbolbild-author'];
        }
        if (strlen(trim($input['src-default-symbolbild-category']))<5) {
            $input['src-default-symbolbild-category'] = $defaultoptions['src-default-symbolbild-category'];
        }
        if (strlen(trim($input['src-default-symbolbild-tag']))<5) {
            $input['src-default-symbolbild-tag'] = $defaultoptions['src-default-symbolbild-tag'];
        }
        if (strlen(trim($input['src-default-symbolbild-search']))<5) {
            $input['src-default-symbolbild-search'] = $defaultoptions['src-default-symbolbild-search'];
        }
        if (strlen(trim($input['src-default-symbolbild']))<5) {
            $input['src-default-symbolbild'] = $defaultoptions['src-default-symbolbild'];
        }
        
	return $input;
}




/**
 * Kontaktinfos  Optionen
 */
function theme_kontaktinfos_do_page() {
   
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
        <style>
                label.description {
                    display: block;
                }
                div.wrap {
                    max-width: 1200px;
                    margin: 20px 0 0 0;
                    background-image: url(<?php echo get_template_directory_uri()?>/images/logo.png);
                    background-position: top right;
                    background-repeat: no-repeat;
                    
                }
                div.piratenkleider-optionen {
                    max-width: 1200px;
                    margin: 0;
                    padding-top: 20px;
                    padding-bottom: 0px;
                    background-image: url(<?php echo get_template_directory_uri()?>/images/schiff-welle.gif);
                    background-position: bottom left;
                    background-repeat: no-repeat;
                }
                p.submit {
                    margin-top: 100px;
                    padding-left: 20px;
                }
                .wrap div.updated {
                    margin-right: 300px;                    
                }
                label.tile {
                    width: 320px;
                    height: 150px;
                    float: left;
                    border: 1px solid #ccc;                    
                    padding: 1px;
                    margin: 5px;
                }
                label.tile:hover {
                    background-color: #eee;
                }
                label.plakattile {
                    width: 160px;
                    height: 250px;
                    float: left;
                    border: 1px solid #ccc;                    
                    padding: 1px;
                    margin: 5px;
                }
                label.plakattile:hover {
                    background-color: #eee;
                }                
            </style>
	<div class="wrap">
            
            <div class="piratenkleider-optionen">  <!-- begin: .piratenkleider-optionen -->    
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Captn & Crew: Kontaktinformationen setzen ', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Contact information has been saved.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
                    <?php settings_fields( 'piratenkleider_kontaktinfos' ); ?>
                    <?php $options = get_option( 'piratenkleider_theme_kontaktinfos' ); 
                        
                        
                    ?>
                    <table class="form-table">
                       <tr valign="top"><th scope="row"><?php _e( 'Legal information', 'piratenkleider' ); ?></th>
			<td>
                            <table>                                
                            <tr valign="top"><th scope="row"><?php _e( 'Responsible', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[impressumperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[impressumperson]" value="<?php esc_attr_e( $options['impressumperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[impressumperson]">
                                        <?php _e( 'Responsible in accordance with 5 TMG. <br>
                                        For example: <code> Martin Smith </ code>', 'piratenkleider' ); ?>
                                        
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row"><?php _e( 'Text label service provider', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]" value="<?php esc_attr_e( $options['impressumdienstanbieter'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]">
                                        <?php _e( 'Text description of the service provider of the website. <br>
                                         Example: <code> Kreisverband model city of the Pirate Party of Germany
                                             represented by the Board Martin Smith, Doris Fischer and Florian Meister. </code>', 'piratenkleider' ); ?>
                                        
                                    </label>
                                </td>					
                            </tr>
                            </table>
			</td>
		       </tr>
                       <tr valign="top"><th scope="row"><?php _e( 'Official Mailing Address', 'piratenkleider' ); ?></th>
			<td>
                            
                        <table>                                
                            <tr valign="top"><th scope="row"><?php _e( 'Name or Title', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[posttitel]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[posttitel]" value="<?php esc_attr_e( $options['posttitel'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[posttitel]">
                                        ><?php _e( ' Address: Title (first row). <br>
                                         For example: <code> Pirate Party </code>', 'piratenkleider' ); ?>
                                       
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row"><?php _e( 'The attention', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[postperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[postperson]" value="<?php esc_attr_e( $options['postperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[postperson]">
                                        <?php _e( 'Address: Optional personal information ("hands on") <br>
                                         For example: <code> Martin Smith </ code>', 'piratenkleider' ); ?>
                                       
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row"><?php _e( 'Street or PO Box', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[poststrasse]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[poststrasse]" value="<?php esc_attr_e( $options['poststrasse'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[poststrasse]">
                                        <?php _e( 'Address: Street name and number or post office box, or giving free <br>
                                         For example: <code> Unbesonnenheitsweg 123b </ code>', 'piratenkleider' ); ?>
                                        
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row"><?php _e( 'Postal code and city', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[poststadt]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[poststadt]" value="<?php esc_attr_e( $options['poststadt'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[poststadt]">
                                        <?php _e( 'Address: Zip <br> followed by city
                                         For example: Ankh-Morpork <code> 12 345 </code>', 'piratenkleider' ); ?>
                                        
                                    </label>
                                </td>					
                            </tr>
                        </table>  	
                            
                            
			</td>
		       </tr>
                       <tr valign="top"><th scope="row"><?php _e( 'Address for service charge', 'piratenkleider' ); ?></th>
			<td>
                            
				<p><?php _e( 'Optional information for cases. If this information is released, the
                                     Data used in the mailing address.', 'piratenkleider' ); ?></p>
                                 <table>                                
                            <tr valign="top"><th scope="row"><?php _e( 'Name or Title', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungtitel]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungtitel]" value="<?php esc_attr_e( $options['ladungtitel'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungtitel]">
                                        <?php _e( 'Address: Title (first row). <br>
                                         For example: <code> Pirate Party </code>', 'piratenkleider' ); ?>
                                        
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row"><?php _e( 'The attention', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungperson]" value="<?php esc_attr_e( $options['ladungperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungperson]">
                                        <?php _e( ' Address: Optional personal information ("hands on"). Should be the same person, as a rule,
                                         the above is defined as the person responsible for the imprint. <br>
                                         For example: <code> Martin Smith </code>', 'piratenkleider' ); ?>
                                       
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row"><?php _e( 'Street or PO Box', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungstrasse]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungstrasse]" value="<?php esc_attr_e( $options['ladungstrasse'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungstrasse]">
                                        <?php _e( ' Address: Street name and number or post office box, or giving free <br>
                                         For example: <code> Unbesonnenheitsweg 123b </code>', 'piratenkleider' ); ?>
                                       
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row"><?php _e( 'Postal code and city', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungstadt]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungstadt]" value="<?php esc_attr_e( $options['ladungstadt'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungstadt]">
                                        <?php _e( 'Address: Zip code followed by city <br> For example: Ankh-Morpork <code> 12 345 </code>', 'piratenkleider' ); ?>
                                       
                                    </label>
                                </td>					
                            </tr>
                        </table>  
			</td>
		       </tr>
                        <tr valign="top"><th scope="row"><?php _e( 'Official e-mail address', 'piratenkleider' ); ?></th>
			<td>
				<input id="piratenkleider_theme_kontaktinfos[kontaktemail]" class="regular-text" type="text" length="5" name="piratenkleider_theme_kontaktinfos[kontaktemail]" value="<?php esc_attr_e( $options['kontaktemail'] ); ?>" />
				<label class="description" for="piratenkleider_theme_kontaktinfos[kontaktemail]">
                                    <?php _e( 'Fixed mail address for official contacts <br> For example.: ', 'piratenkleider' ); ?>
                                    <code><?php echo bloginfo('admin_email'); ?></code>
                                </label>
			</td>
		       </tr>
                       
                       <tr valign="top"><th scope="row"><?php _e( 'Data Protection Officer', 'piratenkleider' ); ?></th>
			<td>
				<p>
                                    <?php _e( 'Optional information to a data protection officer. If this is not specified, the e-mail address of the Federal Privacy Commissioner is given.', 'piratenkleider' ); ?></p>
                                 <table>                                

                            <tr valign="top"><th scope="row"><?php _e( 'Name', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[dsbperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[dsbperson]" value="<?php esc_attr_e( $options['dsbperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[dsbperson]">
                                        <?php _e( 'Name of the DSB <br> For example: <code> Martin Smith </code>', 'piratenkleider' ); ?>
                                       
                                    </label>
                                </td>					
                            </tr>
                             <tr><th scope="row"><?php _e( 'E-mail Address', 'piratenkleider' ); ?></th>
                            <td>
				<input id="piratenkleider_theme_kontaktinfos[dsbemail]" class="regular-text" type="text" length="5" name="piratenkleider_theme_kontaktinfos[dsbemail]" value="<?php esc_attr_e( $options['dsbemail'] ); ?>" />
				<label class="description" for="piratenkleider_theme_kontaktinfos[dsbemail]">
                                    <?php _e( 'Fixed mail address for official contacts <br> For example:. <code> Bundesbeauftragter@piraten-dsb.de </code>', 'piratenkleider' ); ?>
                                    
                                </label>
			</td>
                          </tr>
                            
                        </table>  
			</td>
		       </tr>
                       
                       <tr valign="top"><th scope="row"><?php _e( 'Donation forms', 'piratenkleider' ); ?></th>
			<td>
				<p><?php _e( 'Optional information for donation forms that are created with the page template "donations".', 'piratenkleider' ); ?>
                                    <br>
                                    <?php _e( '<strong> Note: </ strong> This does not replace the correct entry form. The form is
                                     zBmit <em> the plugin Contact Form 7 </ em> created and then added as a macro in the text of the page.
                                     <br>
                                     The following information is only used to build the table for the fixed information.', 'piratenkleider' ); ?>
                                    
                                </p>
                                 <table>                                

                            <tr valign="top"><th scope="row"><?php _e( 'Receiver', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenempfaenger]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenempfaenger]" value="<?php esc_attr_e( $options['spendenempfaenger'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenempfaenger]">
                                        <?php _e( ' Name of recipient / donations account for the transfers. ', 'piratenkleider' ); ?>                                     
                                    </label>
                                </td>					
                            </tr>
                              <tr valign="top"><th scope="row"><?php _e( 'Account number', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenkonto]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenkonto]" value="<?php esc_attr_e( $options['spendenkonto'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenkonto]">
                                        <?php _e( ' Account number of recipient', 'piratenkleider' ); ?>
                                     
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row"><?php _e( 'BLZ', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenblz]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenblz]" value="<?php esc_attr_e( $options['spendenblz'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenblz]">
                                        <?php _e( ' The bank routing number.', 'piratenkleider' ); ?>
                                    
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row"><?php _e( 'Bank', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenbank]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenbank]" value="<?php esc_attr_e( $options['spendenbank'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenbank]">
                                        <?php _e( 'A full textual name of the bank', 'piratenkleider' ); ?>                                     
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row"><?php _e( 'IBAN', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendeniban]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendeniban]" value="<?php esc_attr_e( $options['spendeniban'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendeniban]">
                                     <?php _e( 'Internationale Bank Account Nummer', 'piratenkleider' ); ?>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row"><?php _e( 'BIC', 'piratenkleider' ); ?></th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenbic]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenbic]" value="<?php esc_attr_e( $options['spendenbic'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenbic]">
                                    <?php _e( 'Business Identifier Code', 'piratenkleider' ); ?>
                                    </label>
                                </td>					
                            </tr>
                        </table>  
			</td>
		       </tr>
                    </table>

            <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e( 'Save', 'piratenkleider' ); ?>" />
            </p>
        </form>               
	</div>
            
        </div> <!-- end: .piratenkleider-optionen -->      
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_kontaktinfos_validate( $input ) {
        $input['posttitel'] = wp_kses_normalize_entities( $input['posttitel'] );   
        $input['postperson'] = wp_kses_normalize_entities( $input['postperson'] );   
	$input['postsstrasse'] = wp_kses_normalize_entities( $input['poststrasse'] );   
        $input['poststadt'] = wp_kses_normalize_entities( $input['poststadt'] );  
        
        $input['ladungtitel'] = wp_kses_normalize_entities( $input['ladungtitel'] );   
        $input['ladungperson'] = wp_kses_normalize_entities( $input['ladungperson'] );   
	$input['ladungstrasse'] = wp_kses_normalize_entities( $input['ladungstrasse'] );   
        $input['ladungstadt'] = wp_kses_normalize_entities( $input['ladungstadt'] );      
        
        $input['kontaktemail'] = sanitize_email( $input['kontaktemail'] ); 
        $input['dsbemail'] = sanitize_email( $input['dsbemail'] ); 
        $input['dsbperson'] = wp_filter_nohtml_kses( $input['dsbperson'] );   
	return $input;
}




/**
 * Defaultbilder Optionen
 */
function theme_designspecials_do_page() {
    global $defaultoptions;
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
        <style>
                label.description {
                    display: block;
                }
                div.wrap {
                    max-width: 1200px;
                    margin: 20px 0 0 0;
                    background-image: url(<?php echo get_template_directory_uri()?>/images/logo.png);
                    background-position: top right;
                    background-repeat: no-repeat;
                    
                }
                div.piratenkleider-optionen {
                    max-width: 1200px;
                    margin: 0;
                    padding-top: 20px;
                    padding-bottom: 0px;
                    background-image: url(<?php echo get_template_directory_uri()?>/images/schiff-welle.gif);
                    background-position: bottom left;
                    background-repeat: no-repeat;
                }
                p.submit {
                    margin-top: 100px;
                    padding-left: 20px;
                }
                .wrap div.updated {
                    margin-right: 300px;                    
                }
                label.tile {
                    width: 320px;
                    height: 150px;
                    float: left;
                    border: 1px solid #ccc;                    
                    padding: 1px;
                    margin: 5px;
                }
                label.tile:hover {
                    background-color: #eee;
                }
                label.plakattile {
                    width: 160px;
                    height: 250px;
                    float: left;
                    border: 1px solid #ccc;                    
                    padding: 1px;
                    margin: 5px;
                }
                label.plakattile:hover {
                    background-color: #eee;
                }                
            </style>
	<div class="wrap">
            
            <div class="piratenkleider-optionen">  <!-- begin: .piratenkleider-optionen -->    
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Kl&uuml;verbaum: Erweiterte Designeinstellungen ', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Design settings have been saved.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>
                
                <p> <?php _e( '<b> Note: </ b> These settings should be changed only in exceptional cases. in one
                 improper use can damage the input design of the website.', 'piratenkleider' ); ?>           
                </p>
                
		<form method="post" action="options.php">
                    <?php settings_fields( 'piratenkleider_designspecials' ); ?>
                    <?php $options = get_option( 'piratenkleider_theme_designspecials' ); 
                        
                        
                     if ( ! isset( $options['css-default-header-height'] ) ) 
                            $options['css-default-header-height'] = $defaultoptions['css-default-header-height'];
                     if ( ! isset( $options['css-default-branding-padding-top'] ) ) 
                            $options['css-default-branding-padding-top'] = $defaultoptions['css-default-branding-padding-top'];

                    ?>
                    <table class="form-table">
                        <tr valign="top"><th scope="row"><?php _e( 'Countries to enable color', 'piratenkleider' ); ?></th>
                        <td>
                
                                
                        <select name="piratenkleider_theme_designspecials[css-colorfile]">
                            <option value="" <?php if ( $options['css-colorfile'] == '') echo ' selected="selected"'; ?>><?php _e( 'Deutschland (Orange)', 'piratenkleider' ); ?></option>
                            <option value="colors_lu.css" <?php if ( $options['css-colorfile'] == 'colors_lu.css') echo ' selected="selected"'; ?>><?php _e( 'Luxemburg (Violett)', 'piratenkleider' ); ?></option>
                            <option value="colors_tk.css" <?php if ( $options['css-colorfile'] == 'colors_tk.css') echo ' selected="selected"'; ?>><?php _e( 'T&uuml;rkei (Cyan)', 'piratenkleider' ); ?></option>
							<option value="colors_pt.css" <?php if ( $options['css-colorfile'] == 'colors_pt.css') echo ' selected="selected"'; ?>><?php _e( 'Portuguese (Green)', 'piratenkleider' ); ?></option>
                        </select>   


                        <label class="description" for="piratenkleider_theme_designspecials[css-colorfile]">
                            <?php _e( 'Choice of which country-specific color variation is to be activated.', 'piratenkleider' ); ?>
                        </label>

                        </td>					                           
		       </tr>
                       
                       <tr valign="top"><th scope="row">Height of the head region (. Header)</th>
                        <td>
                            <input id="piratenkleider_theme_designspecials[css-default-header-height]" type="text" 
                                   name="piratenkleider_theme_designspecials[css-default-header-height]" 
                                    style="width: 5em;"
                                   value="<?php esc_attr_e( $options['css-default-header-height'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_designspecials[css-default-header-height]">
                               If this value from the default setting of
                               <?php echo $defaultoptions['css-default-header-height']; ?> pixels from
                                The CSS file piratenkleider.css (line 1926)
                                differs, it is a later inline CSS
                                in the header of the HTML Documents changed. <br>
                                <b> Note: </ b> The reduction of the height of the header is
                                not harmless. It should be noted that the head part
                                also at a magnification of the text to 200% even
                                must have enough space!

                            </label>
                        </td>					                           
		       </tr>
                        <tr valign="top"><th scope="row">Distance of the branding area (=) top (. Header. Branding)</th>
                        <td>
                            <input id="piratenkleider_theme_designspecials[css-default-branding-padding-top]" type="text" 
                                   name="piratenkleider_theme_designspecials[css-default-branding-padding-top]" 
                                   style="width: 5em;"
                                   value="<?php esc_attr_e( $options['css-default-branding-padding-top'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_designspecials[css-default-branding-padding-top]">
                               The logo has a distance to the top. This can be reduced by this specification.
                                                               If this value from the default setting of
                               <?php echo $defaultoptions['css-default-branding-padding-top']; ?> pixels from
                                The CSS file piratenkleider.css
                                differs, it is a later inline CSS
                                in the header of the HTML Documents changed. <br>
                               
                                <b> Note: </ b> If social media icons and Linkmenu above also appear
                                 this distance should not be too small because these icons and the text of links
                                 with increasing size of the logo to the left and it moves so Überlapplungen
                                 could occur.

                            </label>
                        </td>					                           
		       </tr>
                       

                       <tr valign="top"><th scope="row">Hintergrund-Einstellungen im Kopfteil ( .header )</th>
                           <td>
                               <table>
                                   <tr>
                                       <th>background-color</th>
                                       <td>
                                           <input id="piratenkleider_theme_designspecials[css-default-header-background-color]" type="text" 
                                           name="piratenkleider_theme_designspecials[css-default-header-background-color]" 
                                          style="width: 35em;"
                                           value="<?php esc_attr_e( $options['css-default-header-background-color'] ); ?>" />
                                           <label class="description" for="piratenkleider_theme_designspecials[css-default-header-background-color]">
                                                  If set, change the background image.
                                            </label>
                                       </td>                                                                              
                                   </tr>
                                   <tr>
                                       <th>background-image</th>
                                       <td>
                                          <input id="piratenkleider_theme_designspecials[css-default-header-background-image]" type="text" 
                                           name="piratenkleider_theme_designspecials[css-default-header-background-image]" 
                                          style="width: 35em;"
                                           value="<?php esc_attr_e( $options['css-default-header-background-image'] ); ?>" />
                                           <label class="description" for="piratenkleider_theme_designspecials[css-default-header-background-image]">
                                                   Wenn gesetzt, &auml;ndert  das Hintergrundbild.
                                            </label>
                                           
                                       </td>                                                                              
                                   </tr>
                                   <tr>
                                       <th>background-position</th>
                                       <td>
                                            <input id="piratenkleider_theme_designspecials[css-default-header-background-position]" type="text" 
                                           name="piratenkleider_theme_designspecials[css-default-header-background-position]" 
                                          style="width: 35em;"
                                           value="<?php esc_attr_e( $options['css-default-header-background-position'] ); ?>" />
                                           <label class="description" for="piratenkleider_theme_designspecials[css-default-header-background-position]">
                                                  If set, change the position of the background image.
                                            </label>
                                           
                                       </td>                                                                              
                                   </tr>
                                   <tr>
                                       <th>background-repeat</th>
                                       <td>
                                            <input id="piratenkleider_theme_designspecials[css-default-header-background-repeat]" type="text" 
                                           name="piratenkleider_theme_designspecials[css-default-header-background-repeat]" 
                                          style="width: 35em;"
                                           value="<?php esc_attr_e( $options['css-default-header-background-repeat'] ); ?>" />
                                           <label class="description" for="piratenkleider_theme_designspecials[css-default-header-background-repeat]">
                                                  If set, change the repeat feature of the background image.
                                            </label>
                                           
                                       </td>                                                                              
                                   </tr>
                               </table> 
                               
                               
                           </td>    
                       </tr>
                      
                       
                        <tr valign="top"><th scope="row">My CSS instructions</th>
                        <td>
                            <textarea id="piratenkleider_theme_designspecials[css-eigene-anweisungen]" 
                                      class="large-text" cols="30" rows="10" 
                                      name="piratenkleider_theme_designspecials[css-eigene-anweisungen]"><?php echo esc_textarea( $options['css-eigene-anweisungen'] ); ?></textarea>
                            <label class="description" 
                                   for="piratenkleider_theme_designspecials[css-eigene-anweisungen]">
                                       <?php _e( 'Be your own CSS statements that line in the header of the documents completed', 'piratenkleider' ); ?></label>

                        </td>					                           
		       </tr>
                       
                         <tr valign="top"><th scope="row">My HTML instructions</th>
                        <td>
                            <textarea id="piratenkleider_theme_designspecials[html-eigene-anweisungen]" 
                                      class="large-text" cols="30" rows="10" 
                                      name="piratenkleider_theme_designspecials[html-eigene-anweisungen]"><?php echo esc_textarea( $options['html-eigene-anweisungen'] ); ?></textarea>
                            <label class="description" 
                                   for="piratenkleider_theme_designspecials[html-eigene-anweisungen]">
                                       <?php _e( 'My HTML instructions that are placed at the end of the site, before the last </ body &gt; </ html>', 'piratenkleider' ); ?></label>
                            <p> <b> Note: </ b> Invalid HTML, JavaScript or CSS at this point
                                 can lead to a non-functioning of the whole site! <br />
                                 The code will not be filtered or monitored.
                            </p>
                        </td>					                           
		       </tr>
                       
                    </table>

            <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e( 'Save', 'piratenkleider' ); ?>" />
            </p>
        </form>               
	</div>
            
        </div> <!-- end: .piratenkleider-optionen -->      
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_designspecials_validate( $input ) {
        $input['css-default-branding-padding-top'] = wp_kses_normalize_entities( $input['css-default-branding-padding-top'] );   
        $input['css-default-header-height'] = wp_kses_normalize_entities( $input['css-default-header-height'] );   
        $input['css-eigene-anweisungen'] = wp_filter_post_kses( $input['css-eigene-anweisungen'] );
        $input['css-default-header-background-color'] = wp_filter_post_kses( $input['css-default-header-background-color'] );
        $input['css-default-header-background-image'] = wp_filter_post_kses( $input['css-default-header-background-image'] );
        $input['css-default-header-background-position'] = wp_filter_post_kses( $input['css-default-header-background-position'] );
        $input['css-default-header-background-repeat'] = wp_filter_post_kses( $input['css-default-header-background-repeat'] );
        $input['css-colorfile'] = wp_filter_post_kses( $input['css-colorfile'] );
   
	return $input;
}