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
	add_theme_page( __( 'Options', 'piratenkleider' ), __( 'Options', 'piratenkleider' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
        add_theme_page( __( 'Banners & Sliders', 'piratenkleider' ), __( 'Bilder', 'piratenkleider' ), 'edit_theme_options', 'theme_defaultbilder', 'theme_defaultbilder_do_page' );
        add_theme_page( __( 'Captn & Crew', 'piratenkleider' ), __( 'Captn & Crew', 'piratenkleider' ), 'edit_theme_options', 'theme_kontaktinfos', 'theme_kontaktinfos_do_page' );
        add_theme_page( __( 'Design Specials', 'piratenkleider' ), __( 'Design Specials', 'piratenkleider' ), 'edit_theme_options', 'theme_designspecials', 'theme_designspecials_do_page' );
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
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Options Configuration ', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options Saved.', 'piratenkleider' ); ?></strong></p></div>
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
                             
                             
                             if (!isset($options['stickerlink1-content'])  || (strlen(trim($options['stickerlink1-content']))<1 )) 
                                $options['stickerlink1-content'] = $defaultoptions['stickerlink1-content'];                                
                             if (!isset($options['stickerlink1-url'])  || (strlen(trim($options['stickerlink1-url']))<1 )) 
                                $options['stickerlink1-url'] = $defaultoptions['stickerlink1-url'];
                          
                            if (!isset($options['stickerlink2-content']) || (strlen(trim($options['stickerlink2-content']))<1 )) 
                                $options['stickerlink2-content'] = $defaultoptions['stickerlink2-content'];
                            if (!isset($options['stickerlink2-url'])  || (strlen(trim($options['stickerlink2-url']))<1 )) 
                                $options['stickerlink2-url'] = $defaultoptions['stickerlink2-url'];
                            if (!isset($options['stickerlink2-content']) || (strlen(trim($options['stickerlink3-content']))<1 )) 
                                $options['stickerlink3-content'] = $defaultoptions['stickerlink3-content'];
                            if (!isset($options['stickerlink3-url'])  || (strlen(trim($options['stickerlink3-url']))<1 )) 
                                $options['stickerlink3-url'] = $defaultoptions['stickerlink3-url'];
                            if (!isset($options['anonymize-user-commententries'])) 
                                $options['anonymize-user-commententries'] = $defaultoptions['anonymize-user-commententries']; 
                            if (!isset($options['aktiv-commentreplylink'])) 
                                $options['aktiv-commentreplylink'] = $defaultoptions['aktiv-commentreplylink'];                            
                        ?>
			<table class="form-table">
                                    
                            
                              
                              
                                <tr valign="top"><th scope="row">Default Pages Images</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-defaultseitenbild]" name="piratenkleider_theme_options[aktiv-defaultseitenbild]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-defaultseitenbild'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-defaultseitenbild]">If no image, default will be used.</label>
					</td>
				</tr>
                                <tr valign="top"><th scope="row">Reserved Images</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]" name="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-platzhalterbilder-indexseiten'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]">Placeholder images for index pages to categories, tags, search and archive</label>
					</td>
				</tr>
				
                               <tr valign="top">
                                    <th scope="row">Head menu</th>
                                    <td>
                                        <table>
                                              <tr valign="top"><th scope="row">Link menu</th>
                                                <td>
						<input id="piratenkleider_theme_options[aktiv-linkmenu]" name="piratenkleider_theme_options[aktiv-linkmenu]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-linkmenu'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-linkmenu]">Show Linkmenu upper right, between social media icons and search</label>
                                                </td>
                                    	</tr>
                                             <tr valign="top"><th scope="row">Search</th>
                                                <td>
						<input id="piratenkleider_theme_options[aktiv-suche]" name="piratenkleider_theme_options[aktiv-suche]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-suche'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-suche]">Show input mask for the top right search</label>
                                                </td>
                                            </tr>
                                           <tr valign="top"><th scope="row">Promotional Stickers</th>
                                                <td>
						<input id="piratenkleider_theme_options[defaultwerbesticker]" name="piratenkleider_theme_options[defaultwerbesticker]" type="checkbox" value="1" <?php checked( '1', $options['defaultwerbesticker'] ); ?> />
						<label  for="piratenkleider_theme_options[defaultwerbesticker]">Show Stickers</label>
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
                                    <th scope="row">Sidebar</th>
                                    <td>
                                        <table>                                             
                                            <tr valign="top"><th scope="row">Side box</th>
                                                    <td>
                                                            <input id="piratenkleider_theme_options[zeige_subpagesonly]" name="piratenkleider_theme_options[zeige_subpagesonly]" type="checkbox" value="1" <?php checked( '1', $options['zeige_subpagesonly'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[zeige_subpagesonly]">Show in the display of pages in the sidebar to the right, only the current submenu. When disabled, the full menu is shown. This is for websites with many pages not suitable.</label>

                                                            <p>Alternative:</p>
                                                            <input id="piratenkleider_theme_options[zeige_sidebarpagemenu]" name="piratenkleider_theme_options[zeige_sidebarpagemenu]" type="checkbox" value="1" <?php checked( '1', $options['zeige_sidebarpagemenu'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[zeige_sidebarpagemenu]">View page in the sidebar menu.</label>

                                                    </td>
                                            </tr>

                                            <tr valign="top"><th scope="row">Newsletter</th>
                                                    <td>
                                                            <input id="piratenkleider_theme_options[newsletter]" name="piratenkleider_theme_options[newsletter]" type="checkbox" value="1" <?php checked( '1', $options['newsletter'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[newsletter]">Input Mask Show</label>
                                                    </td>
                                            </tr>
                                            
                                            <tr valign="top"><th scope="row"><?php _e( 'Activate poster slider', 'piratenkleider' ); ?></th>
                                        	<td>
                                            	<input id="piratenkleider_theme_options[slider-defaultwerbeplakate]" name="piratenkleider_theme_options[slider-defaultwerbeplakate]" type="checkbox" value="1" <?php checked( '1', $options['slider-defaultwerbeplakate'] ); ?> />
						<label for="piratenkleider_theme_options[slider-defaultwerbeplakate]">Slider, the advertising posters (Sidebar right column) are shown.
                                                     <br> selection of poster images can be adjusted to the default images.</label>
                                                </td>
                                            </tr>
                                            
                                         <tr valign="top"><th scope="row"><?php _e( 'Teaserlink 1', 'piratenkleider' ); ?></th>
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
                                                    <?php _e( 'Untertitel', 'piratenkleider' ); ?>:
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

                                          <tr valign="top"><th scope="row"><?php _e( 'Teaserlink 2', 'piratenkleider' ); ?></th>
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
                                                    <?php _e( 'Untertitel', 'piratenkleider' ); ?>:
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
                                          <tr valign="top"><th scope="row"><?php _e( 'Teaserlink 3', 'piratenkleider' ); ?></th>
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
                                                    <?php _e( 'Untertitel', 'piratenkleider' ); ?>:
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
                                    <th scope="row">Home</th>
                                    <td>
                                        <table>
                                            <tr valign="top"><th scope="row">Contributions over full width</th>
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
                                                        Number of posts that go over the entire width of content.
                                                    </label>
                                            </td>
                                            </tr>
                                            <tr valign="top"><th scope="row">Posts with half the width</th>
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
                                                        Number of posts that are displayed in columns, each with two articles side by side.                                                    </label>
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
                                                    Show buttons. <br> Note: It will be shown only the buttons, which addresses the following input fields
                                                     are defined.                                                </label>
                                                </td>
                                            </tr>  
                                            
                                            
                                          <tr valign="top"><th scope="row">Facebook</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_facebook]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_facebook]" value="<?php esc_attr_e( $options['social_facebook'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_facebook]">
                                                <?php _e( 'URL inkl. http:// zur Facebook Seite', 'piratenkleider' ); ?>
                                                    <br>For example: <code>http://www.facebook.com/Piratenpartei</code>
                                                </label>
                                                
					</td>					
                                        </tr>
                                        
                                        
                                        <tr valign="top"><th scope="row">Twitter</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_twitter]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_twitter]" value="<?php esc_attr_e( $options['social_twitter'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_twitter]">
                                                <?php _e( 'URL inkl. http:// zur Twitter Seite', 'piratenkleider' ); ?>
                                                    <br>For example: <code>https://twitter.com/#!/piratenpartei</code>
                                                </label>
					</td>					
                                        </tr>
                                        
                                        <tr valign="top"><th scope="row">YouTube</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_youtube]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_youtube]" value="<?php esc_attr_e( $options['social_youtube'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_youtube]">
                                                <?php _e( 'URL inkl. http:// zur YouTube Seite', 'piratenkleider' ); ?>
                                                    <br>For example: <code>http://www.youtube.com/user/piratenpartei</code>
                                                </label>
					</td>					
                                        </tr>
                                      
                                        <tr valign="top"><th scope="row">G+</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_gplus]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_gplus]" value="<?php esc_attr_e( $options['social_gplus'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_gplus]">
                                                <?php _e( 'URL inkl. http:// zur G+ Seite', 'piratenkleider' ); ?>
                                                <br>For example: <code>https://plus.google.com/u/0/107862983960150496076/posts</code>
                                                </label>
					</td>					
                                        </tr>
                                        
                                         <tr valign="top"><th scope="row">Diaspora</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_diaspora]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_diaspora]" value="<?php esc_attr_e( $options['social_diaspora'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_diaspora]">
                                                <?php _e( 'URL inkl. http:// zur Diaspora Seite', 'piratenkleider' ); ?>
                                                    <br>For example: <code>https://joindiaspora.com/u/piratenpartei</code>
                                                </label>
                                            </td>					
                                            </tr>

                                            <tr valign="top"><th scope="row">Identica</th>
                                            <td>
                                            <input id="piratenkleider_theme_options[social_identica]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_identica]" value="<?php esc_attr_e( $options['social_identica'] ); ?>" />
                                            <label class="description" for="piratenkleider_theme_options[social_identica]">
                                            <?php _e( 'URL inkl. http:// zur Identica Seite', 'piratenkleider' ); ?>
                                                <br>For example:  <code>http://identi.ca/piratenpartei</code>   
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
			
                                        
                                         <tr valign="top"><th scope="row">Twitter Username:</th>
                                          <td>
						<input id="piratenkleider_theme_options[feed_twitter]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[feed_twitter]" value="<?php esc_attr_e( $options['feed_twitter'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[feed_twitter]"><?php _e( 'Twitter Username', 'piratenkleider' ); ?></label>
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
                                                    <label class="description" for="piratenkleider_theme_options[feed_twitter_numberarticle]"><?php _e( 'How many Twitter messages to be shown up', 'piratenkleider' ); ?></label>
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
						<label for="piratenkleider_theme_options[slider-aktiv]">Slider in the teaser section on the home turn.
                                                 <br> selection of poster images can be adjusted to the default images.</label>
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
                                                    <label class="description" for="piratenkleider_theme_options[slider-catid]"><?php _e( 'Slider Categories', 'piratenkleider' ); ?></label>
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
                                                    <label class="description" for="piratenkleider_theme_options[slider-numberarticle]"><?php _e( 'How many slides are to be shown up items', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Animation Type', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[slider-animationType]">
                                                        <?php
                                                                    $selected = $options['slider-animationType'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="fade" <?php if ($selected == 'fade') { echo 'selected="selected"'; }?>>fade</option>
                                                        <option style="padding-right: 10px;" value="slide" <?php if ($selected == 'slide') { echo 'selected="selected"'; }?>>slide</option>
                                                       						
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[slider-animationType]"><?php _e( 'How to change the slideshow look visually', 'piratenkleider' ); ?></label>
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
                                                            <label class="description" for="piratenkleider_theme_options[slider-slideshowSpeed]"><?php _e( 'Speed ​​of the image change in milliseconds', 'piratenkleider' ); ?></label>
                                                    </td>

                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Animation Duration', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 5em;" id="piratenkleider_theme_options[slider-animationDuration]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[slider-animationDuration]" value="<?php esc_attr_e( $options['slider-animationDuration'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[slider-animationDuration]"><?php _e( 'Speed ​​of the animation / image fading during transition in milliseconds', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>

                                            
                                            <tr valign="top"><th scope="row"><?php _e( 'Significantly title for teaser', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 15em;" id="piratenkleider_theme_options[teaser-subtitle]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-subtitle]" value="<?php esc_attr_e( $options['teaser-subtitle'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-subtitle]"><?php _e( 'This text appears above the title', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Maximum text length of the title in the teaser', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 3em;" id="piratenkleider_theme_options[teaser-title-maxlength]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-title-maxlength]" value="<?php esc_attr_e( $options['teaser-title-maxlength'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-title-maxlength]"><?php _e( 'The title may be longer', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Number of words in the Teaser title', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 3em;" id="piratenkleider_theme_options[teaser-title-words]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-title-words]" value="<?php esc_attr_e( $options['teaser-title-words'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-title-words]"><?php _e( 'Number of words in the teaser, the maximum text length is limited by this value', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            
                                            
                                                         
                                        </table>                                                                                
                                    </td>                                    
                                </tr>    
                                <tr valign="top">
                                    <th scope="row">Special</th>
                                    <td>

                                        <table>                                
                                     
                                        <tr valign="top"><th scope="row">Newsletter</th>
                                          <td>
						<input style="width: 40em;" id="piratenkleider_theme_options[url-newsletteranmeldung]" class="regular-text" type="text"  name="piratenkleider_theme_options[url-newsletteranmeldung]" value="<?php esc_attr_e( $options['url-newsletteranmeldung'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[url-newsletteranmeldung]">URL, including http://, to the side on which one can be added to newsletter. default: <code><?php echo $defaultoptions['url-newsletteranmeldung']; ?></code></label>
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
                                            Note: These figures appear on all pages and articles from the site. this
                                             is not always useful (especially for keywords and description).
                                             Should also SEO plug-ins, such as wpSEO o.a. be in use,
                                             These figures should also remain unfilled.                                                                                                                            
                                        </p>
                                    </td>                                    
                                </tr>    
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Security & Anonymity', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                        <tr valign="top"><th scope="row">authors show</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-autoren]" name="piratenkleider_theme_options[aktiv-autoren]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-autoren'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-autoren]"><?php _e( 'Show link in the display of articles and the authors.', 'piratenkleider' ); ?></label>
					</td>
                                        </tr>
                                        <tr valign="top"><th scope="row">Anonymous user comments</th>
					<td>
						<input id="piratenkleider_theme_options[anonymize-user]" name="piratenkleider_theme_options[anonymize-user]" type="checkbox" value="1" <?php checked( '1', $options['anonymize-user'] ); ?> />
						<label  for="piratenkleider_theme_options[anonymize-user]"><?php _e( 'IP address and user agent string empty, the entry of e-mail addresses will be prevented', 'piratenkleider' ); ?></label>
                                                <p><b> Note: </ b> This option also disables the Avatar and Display
                                                     sets the comment setting in Settings-talk so let
                                                     users to enter a name and e-mail addresses if they have more than one.</p>
                                                
                                                <p>
                                                   In this case, offered comment fields:
                                                </p>   
                                                <select name="piratenkleider_theme_options[anonymize-user-commententries]">
                                                        <?php 
                                                                    $selected = $options['anonymize-user-commententries'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="0" <?php if ($selected == '0') { echo 'selected="selected"'; }?>>Name, URL und E-Mail (Wordpress-Default)</option>					
                                                        <option style="padding-right: 10px;" value="1" <?php if ($selected == '1') { echo 'selected="selected"'; }?>>Name</option>
                                                        <option style="padding-right: 10px;" value="2" <?php if ($selected == '2') { echo 'selected="selected"'; }?>>Name und URL</option>
                                                       	
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[anonymize-user-commententries]"><?php _e( 'Offers commentary on voluntary input fields', 'piratenkleider' ); ?></label>

					</td>
                                        </tr>
                                        <tr valign="top"><th scope="row">Avatars View</th>
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
                                        <tr valign="top"><th scope="row">Reply to comments Links</th>
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
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( 'Options set: Default Pictures ', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Default images were stored.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
                    <?php settings_fields( 'piratenkleider_defaultbilder' ); ?>
                    <?php $options = get_option( 'piratenkleider_theme_defaultbilder' ); 
                        $defaultbildsrc = $options['slider-defaultbildsrc']; 
                        $defaultseitenbildsrc = $options['seiten-defaultbildsrc']; 
                        
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
                                <h3>Alternative Slider image as an URL</h3>
                                 <input id="piratenkleider_theme_defaultbilder[slider-alternativesrc]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[slider-alternativesrc]" value="<?php esc_attr_e( $options['slider-alternativesrc'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[slider-alternativesrc]">
                                URL including http:// to the image. This may also have been previously uploaded to the media dialogue.                        
                                <br>
                                The image should not be wider than 705 pixels and its essential characteristics of a
                                 Height of 240 pixels show. The appearance of the page is cut from 240 pixels down.
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
                                <h3>Alternative page image with URL</h3>
                                <input id="piratenkleider_theme_defaultbilder[seiten-alternativesrc]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[seiten-alternativesrc]" value="<?php esc_attr_e( $options['seiten-alternativesrc'] ); ?>" />
                               <label class="description" for="piratenkleider_theme_defaultbilder[seiten-alternativesrc]">
                                URL including http:// to the image. This may also have been previously uploaded to the media dialogue.                               
                                <br>
                                The image should not be wider than 705 pixels and its essential characteristics of a
                                 Height of 150 pixels show. The appearance of the page is cut from 150 pixels down.
                                   
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
                                <p>
                                    These images are shown in the sidebar to the right, if this is about the options (see Slider) also turned on.                                    
                                </p>
                                    
                                    
                                
                                <h3>Own post images (!?):</h3>
                                
                                <textarea id="piratenkleider_theme_defaultbilder[plakate-altadressen]" class="large-text" cols="30" rows="5" name="piratenkleider_theme_defaultbilder[plakate-altadressen]"><?php echo esc_textarea( $options['plakate-altadressen'] ); ?></textarea>
				<label class="description" for="piratenkleider_theme_defaultbilder[plakate-altadressen]"><?php _e( 'Addresses alternative poster images', 'piratenkleider' ); ?></label>

                                <p>    
                                Specifying the URL to the image including http://. If there are several, are
                                 the addresses with a comma or wrap separately.
                                 Default If above posters are clicked, these images also appear.
                                 These images may also have been previously uploaded to the media dialogue.
                                 <br>
                                 The images should be exactly 277x391 pixels in size each.
                                 </p>      
                              </label>
                                 <br />
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
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( 'Captn & Crew: Contact Information', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Contact information has been saved.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
                    <?php settings_fields( 'piratenkleider_kontaktinfos' ); ?>
                    <?php $options = get_option( 'piratenkleider_theme_kontaktinfos' ); 
                        
                        
                    ?>
                    <table class="form-table">
                       <tr valign="top"><th scope="row">Legal information</th>
			<td>
                            <table>                                
                            <tr valign="top"><th scope="row">Responsible</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[impressumperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[impressumperson]" value="<?php esc_attr_e( $options['impressumperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[impressumperson]">
                                        Verantwortliche/r gem&auml;&szlig; &sect; 5 TMG. <br>
                                       For example: <code> Martin Smith </ code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">Text label service provider</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]" value="<?php esc_attr_e( $options['impressumdienstanbieter'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]">
                                       Text description of the service provider of the website. <br>
                                         Example: <code> Kreisverband model city of the Pirate Party of Germany
                                             represented by the Board Martin Smith, Doris Fischer and Florian Meister. </ code>
                                    </label>
                                </td>					
                            </tr>
                            </table>
			</td>
		       </tr>
                       <tr valign="top"><th scope="row">Offizielle Postanschrift</th>
			<td>
                            
                        <table>                                
                            <tr valign="top"><th scope="row">Name oder Titel</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[posttitel]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[posttitel]" value="<?php esc_attr_e( $options['posttitel'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[posttitel]">
                                        Address: Title (first row). <br>
                                         For example: <code> Pirate Party </ code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">the attention</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[postperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[postperson]" value="<?php esc_attr_e( $options['postperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[postperson]">
                                       Address: Optional personal information ("hands on") <br>
                                         For example: <code> Martin Smith </ code>
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row">Street or PO Box</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[poststrasse]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[poststrasse]" value="<?php esc_attr_e( $options['poststrasse'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[poststrasse]">
                                       Address: Street name and number or post office box, or giving free <br>
                                         For example: <code> Unbesonnenheitsweg 123b </ code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">PLZ und Stadt</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[poststadt]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[poststadt]" value="<?php esc_attr_e( $options['poststadt'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[poststadt]">
                                       Address: Street name and number or post office box, or giving free <br>
                                          For example: <code> Unbesonnenheitsweg 123b </ code>
                                    </label>
                                </td>					
                            </tr>
                        </table>  	
                            
                            
			</td>
		       </tr>
                       <tr valign="top"><th scope="row">Address for service charge</th>
			<td>
				<p>Optional information for cases. If this information is released, the
                                     Data used in the mailing address. </p>
                                 <table>                                
                            <tr valign="top"><th scope="row">Name oder Title</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungtitel]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungtitel]" value="<?php esc_attr_e( $options['ladungtitel'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungtitel]">
                                        Address: Title (first row). <br>
                                         For example: <code> Pirate Party </ code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">zu H&auml;nden</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungperson]" value="<?php esc_attr_e( $options['ladungperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungperson]">
                                       Address: Optional personal information ("hands on"). Should be the same person, as a rule,
                                         the above is defined as the person responsible for the imprint. <br>
                                         For example: <code> Martin Smith </ code>
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row">Street or PO Box</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungstrasse]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungstrasse]" value="<?php esc_attr_e( $options['ladungstrasse'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungstrasse]">
                                        Address: Street name and number or post office box, or giving free <br>
                                         For example: <code> Unbesonnenheitsweg 123b </code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">Postal code and city</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungstadt]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungstadt]" value="<?php esc_attr_e( $options['ladungstadt'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungstadt]">
                                      Address: Zip <br> followed by city
                                         For example: Ankh-Morpork <code> 12 345 </code>
                                    </label>
                                </td>					
                            </tr>
                        </table>  
			</td>
		       </tr>
                        <tr valign="top"><th scope="row">Official e-mail address</th>
			<td>
				<input id="piratenkleider_theme_kontaktinfos[kontaktemail]" class="regular-text" type="text" length="5" name="piratenkleider_theme_kontaktinfos[kontaktemail]" value="<?php esc_attr_e( $options['kontaktemail'] ); ?>" />
				<label class="description" for="piratenkleider_theme_kontaktinfos[kontaktemail]">
                                    Fixed mail address for official contacts.
                                     <br> For example:<code><?php echo bloginfo('admin_email'); ?></code>
                                </label>
			</td>
		       </tr>
                       
                       <tr valign="top"><th scope="row">Data Protection Officer</th>
			<td>
				<p>Optional information to a data protection officer. If this is not specified,
                                 the e-mail address of the Federal Privacy Commissioner indicated.</p>
                                 <table>                                

                            <tr valign="top"><th scope="row">Name</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[dsbperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[dsbperson]" value="<?php esc_attr_e( $options['dsbperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[dsbperson]">
                                     Name of the DSB <br>
                                         For example: <code> Martin Smith </ code>   
                                    </label>
                                </td>					
                            </tr>
                             <tr><th scope="row">E-Mail</th>
                            <td>
				<input id="piratenkleider_theme_kontaktinfos[dsbemail]" class="regular-text" type="text" length="5" name="piratenkleider_theme_kontaktinfos[dsbemail]" value="<?php esc_attr_e( $options['dsbemail'] ); ?>" />
				<label class="description" for="piratenkleider_theme_kontaktinfos[dsbemail]">
                                   Fixed mail address for official contacts.
                                     <br> For example: <code> bundesbeauftragter@piraten-dsb.de </code>
                                </label>
			</td>
                          </tr>
                            
                        </table>  
			</td>
		       </tr>
                       
                       <tr valign="top"><th scope="row">donation forms</th>
			<td>
				<p>Optional information for donation forms that are created with the page template "donations".
                                    <br>
                                    <strong> Note: </ strong> This does not replace the
                                     correct entry form. The form is
                                     zBmit <em> the plugin Contact Form 7 </ em> and then created
                                     added as a macro in the text of the page.
                                     <br>
                                     The following information is only used to
                                     build the table for the fixed information.
                                </p>
                                 <table>                                

                            <tr valign="top"><th scope="row">Empf&auml;nger</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenempfaenger]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenempfaenger]" value="<?php esc_attr_e( $options['spendenempfaenger'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenempfaenger]">
                                      Name of recipient / donations account for the transfers. 
                                    </label>
                                </td>					
                            </tr>
                              <tr valign="top"><th scope="row">Account number</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenkonto]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenkonto]" value="<?php esc_attr_e( $options['spendenkonto'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenkonto]">
                                     Account number of recipient
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row">BLZ</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenblz]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenblz]" value="<?php esc_attr_e( $options['spendenblz'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenblz]">
                                     The bank routing number.
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">Bank</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenbank]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenbank]" value="<?php esc_attr_e( $options['spendenbank'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenbank]">
                                     A full textual name of the bank
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row">IBAN</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendeniban]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendeniban]" value="<?php esc_attr_e( $options['spendeniban'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendeniban]">
                                     International Bank Account Nummer
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">BIC</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenbic]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenbic]" value="<?php esc_attr_e( $options['spendenbic'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenbic]">
                                    Business Identifier Code
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
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Advanced Design Settings', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Design settings have been saved.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>
                <p> <b> Note: </ b> These settings should be changed only in exceptional cases. in one
                 improper use can damage the input design of the website. <br>
                 In other words, Jo <em> min Jun. Dat wat you here Doust, dat de geit full uff
                 Basansegel. Jo pass you up! </ Em>
                 </ p>
                
		<form method="post" action="options.php">
                    <?php settings_fields( 'piratenkleider_designspecials' ); ?>
                    <?php $options = get_option( 'piratenkleider_theme_designspecials' ); 
                        
                        
                     if ( ! isset( $options['css-default-header-height'] ) ) 
                            $options['css-default-header-height'] = $defaultoptions['css-default-header-height'];
                     if ( ! isset( $options['css-default-branding-padding-top'] ) ) 
                            $options['css-default-branding-padding-top'] = $defaultoptions['css-default-branding-padding-top'];

                    ?>
                    <table class="form-table">
                       <tr valign="top"><th scope="row">Height of the head region ( .header )</th>
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
                        <tr valign="top"><th scope="row">Distance of the branding area (=) top ( .header .branding )</th>
                        <td>
                            <input id="piratenkleider_theme_designspecials[css-default-branding-padding-top]" type="text" 
                                   name="piratenkleider_theme_designspecials[css-default-branding-padding-top]" 
                                   style="width: 5em;"
                                   value="<?php esc_attr_e( $options['css-default-branding-padding-top'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_designspecials[css-default-branding-padding-top]">
                              The logo has a distance to the top. This can be reduced by this specification.
                                                               If this value from the default setting of
                                <php echo $ default options ['css-default-branding-padding-top'];?> pixels from
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
                       

                       <tr valign="top"><th scope="row">Background Settings in the header ( .header )</th>
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
                                                   If set, change from the default background color.
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
                                                  If set, change the background image.
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
                             </ p>
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

    
    
    
	return $input;
}