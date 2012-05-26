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
	add_theme_page( __( 'Takelage einstellen', 'piratenkleider' ), __( 'Takelage einstellen', 'piratenkleider' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
        add_theme_page( __( 'Segel setzen', 'piratenkleider' ), __( 'Segel setzen', 'piratenkleider' ), 'edit_theme_options', 'theme_defaultbilder', 'theme_defaultbilder_do_page' );
        add_theme_page( __( 'Captn & Crew', 'piratenkleider' ), __( 'Captn & Crew', 'piratenkleider' ), 'edit_theme_options', 'theme_kontaktinfos', 'theme_kontaktinfos_do_page' );
        add_theme_page( __( 'Kl&uuml;verbaum', 'piratenkleider' ), __( 'Kl&uuml;verbaum', 'piratenkleider' ), 'edit_theme_options', 'theme_designspecials', 'theme_designspecials_do_page' );
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
		<div class="updated fade"><p><strong><?php _e( 'Optionen wurden gespeichert.', 'piratenkleider' ); ?></strong></p></div>
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
                                    
                            
                              
                              
                                <tr valign="top"><th scope="row">Defaultbilder f&uuml;r Seiten</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-defaultseitenbild]" name="piratenkleider_theme_options[aktiv-defaultseitenbild]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-defaultseitenbild'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-defaultseitenbild]">Bilder f&uuml;r Seiten erzwingen, die von sich aus kein Artikelbild definiert haben. Wenn kein Artikelbild vorhanden ist,
                                                wird ein Defaultbild gezeigt.</label>
					</td>
				</tr>
                                <tr valign="top"><th scope="row">Platzhalterbilder</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]" name="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-platzhalterbilder-indexseiten'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-platzhalterbilder-indexseiten]">Platzhalterbilder bei Indexseiten zu Kategorien, Tags, Suche und Archiv anzeigen</label>
					</td>
				</tr>
				
                               <tr valign="top">
                                    <th scope="row">Kopfteil</th>
                                    <td>
                                        <table>
                                              <tr valign="top"><th scope="row">Linkmenu</th>
                                                <td>
						<input id="piratenkleider_theme_options[aktiv-linkmenu]" name="piratenkleider_theme_options[aktiv-linkmenu]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-linkmenu'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-linkmenu]">Linkmenu oben rechts, zwischen Social media Icons und Suchmaske anzeigen</label>
                                                </td>
                                    	</tr>
                                             <tr valign="top"><th scope="row">Suchmaske</th>
                                                <td>
						<input id="piratenkleider_theme_options[aktiv-suche]" name="piratenkleider_theme_options[aktiv-suche]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-suche'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-suche]">Eingabemaske f&uuml;r Suche oben rechts anzeigen</label>
                                                </td>
                                            </tr>
                                           <tr valign="top"><th scope="row">Werbesticker</th>
                                                <td>
						<input id="piratenkleider_theme_options[defaultwerbesticker]" name="piratenkleider_theme_options[defaultwerbesticker]" type="checkbox" value="1" <?php checked( '1', $options['defaultwerbesticker'] ); ?> />
						<label  for="piratenkleider_theme_options[defaultwerbesticker]">Sticker anzeigen.</label>
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
                                            <tr valign="top"><th scope="row">Seitenmenu</th>
                                                    <td>
                                                            <input id="piratenkleider_theme_options[zeige_subpagesonly]" name="piratenkleider_theme_options[zeige_subpagesonly]" type="checkbox" value="1" <?php checked( '1', $options['zeige_subpagesonly'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[zeige_subpagesonly]">Bei der Anzeige von Seiten rechts in der Sidebar nur das aktuelle Submenu zeigen. Bei Deaktivierung wird das vollst&auml;ndige Men&uuml; gezeigt. Dies ist f&uuml;r Webauftritte mit vielen Seiten nicht geeignet.</label>

                                                            <p>Alternativ:</p>
                                                            <input id="piratenkleider_theme_options[zeige_sidebarpagemenu]" name="piratenkleider_theme_options[zeige_sidebarpagemenu]" type="checkbox" value="1" <?php checked( '1', $options['zeige_sidebarpagemenu'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[zeige_sidebarpagemenu]">Seitenmen&uuml; in der Sidebar anzeigen.</label>

                                                    </td>
                                            </tr>

                                            <tr valign="top"><th scope="row">Piraten-Newsletter</th>
                                                    <td>
                                                            <input id="piratenkleider_theme_options[newsletter]" name="piratenkleider_theme_options[newsletter]" type="checkbox" value="1" <?php checked( '1', $options['newsletter'] ); ?> />
                                                            <label  for="piratenkleider_theme_options[newsletter]">Eingabemaske anzeigen</label>
                                                    </td>
                                            </tr>
                                            
                                            <tr valign="top"><th scope="row"><?php _e( 'Plakatslider aktivieren', 'piratenkleider' ); ?></th>
                                        	<td>
                                            	<input id="piratenkleider_theme_options[slider-defaultwerbeplakate]" name="piratenkleider_theme_options[slider-defaultwerbeplakate]" type="checkbox" value="1" <?php checked( '1', $options['slider-defaultwerbeplakate'] ); ?> />
						<label for="piratenkleider_theme_options[slider-defaultwerbeplakate]">Slider der Werbeplakate (rechte Sidebar-Spalte) werden angezeigt. 
                                                    <br>Die Auswahl der Plakatbilder kann unter den Defaultbildern angepasst werden.</label>
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
                                                    <th><label for="piratenkleider_theme_options[teaserlink1-title]"> <?php _e( 'Titel', 'piratenkleider' ); ?>:</label></th>
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
                                                    <th><label for="piratenkleider_theme_options[teaserlink2-title]"> <?php _e( 'Titel', 'piratenkleider' ); ?>:</label></th>
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
                                                    <th><label for="piratenkleider_theme_options[teaserlink3-title]"> <?php _e( 'Titel', 'piratenkleider' ); ?>:</label></th>
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
                                    <th scope="row">Startseite</th>
                                    <td>
                                        <table>
                                            <tr valign="top"><th scope="row">Beitr&auml;ge &uuml;ber ganze Breite</th>
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
                                                        Zahl der Beitr&auml;ge, die &uuml;ber die gesamte Inhaltsbreite gehen.
                                                    </label>
                                            </td>
                                            </tr>
                                            <tr valign="top"><th scope="row">Beitr&auml;ge &uuml;ber halbe Breite</th>
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
                                                        Zahl der Beitr&auml;ge, die in Spalten mit je zwei Beitr&auml;gen nebeneinander, angezeigt werden.
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
                                                    Buttons anzeigen. <br>Hinweis: Es werden nur die Buttons gezeigt, bei denen in den folgenden Eingabefeldern Adressen
                                                    definiert sind.
                                                </label>
                                                </td>
                                            </tr>  
                                            
                                            
                                          <tr valign="top"><th scope="row">Facebook</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_facebook]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_facebook]" value="<?php esc_attr_e( $options['social_facebook'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_facebook]">
                                                <?php _e( 'URL inkl. http:// zur Facebook Seite', 'piratenkleider' ); ?>
                                                    <br>Zum Beispiel: <code>http://www.facebook.com/PiratenparteiDeutschland</code>
                                                </label>
                                                
					</td>					
                                        </tr>
                                        
                                        
                                        <tr valign="top"><th scope="row">Twitter</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_twitter]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_twitter]" value="<?php esc_attr_e( $options['social_twitter'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_twitter]">
                                                <?php _e( 'URL inkl. http:// zur Twitter Seite', 'piratenkleider' ); ?>
                                                    <br>Zum Beispiel: <code>https://twitter.com/#!/piratenpartei</code>
                                                </label>
					</td>					
                                        </tr>
                                        
                                        <tr valign="top"><th scope="row">YouTube</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_youtube]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_youtube]" value="<?php esc_attr_e( $options['social_youtube'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_youtube]">
                                                <?php _e( 'URL inkl. http:// zur YouTube Seite', 'piratenkleider' ); ?>
                                                    <br>Zum Beispiel: <code>http://www.youtube.com/user/piratenpartei</code>
                                                </label>
					</td>					
                                        </tr>
                                      
                                        <tr valign="top"><th scope="row">G+</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_gplus]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_gplus]" value="<?php esc_attr_e( $options['social_gplus'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_gplus]">
                                                <?php _e( 'URL inkl. http:// zur G+ Seite', 'piratenkleider' ); ?>
                                                <br>Zum Beispiel: <code>https://plus.google.com/u/0/107862983960150496076/posts</code>
                                                </label>
					</td>					
                                        </tr>
                                        
                                         <tr valign="top"><th scope="row">Diaspora</th>
                                          <td>
						<input id="piratenkleider_theme_options[social_diaspora]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_diaspora]" value="<?php esc_attr_e( $options['social_diaspora'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[social_diaspora]">
                                                <?php _e( 'URL inkl. http:// zur Diaspora Seite', 'piratenkleider' ); ?>
                                                    <br>Zum Beispiel: <code>https://joindiaspora.com/u/piratenpartei</code>
                                                </label>
                                            </td>					
                                            </tr>

                                            <tr valign="top"><th scope="row">Identica</th>
                                            <td>
                                            <input id="piratenkleider_theme_options[social_identica]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[social_identica]" value="<?php esc_attr_e( $options['social_identica'] ); ?>" />
                                            <label class="description" for="piratenkleider_theme_options[social_identica]">
                                            <?php _e( 'URL inkl. http:// zur Identica Seite', 'piratenkleider' ); ?>
                                                <br>Zum Beispiel:  <code>http://identi.ca/piratenpartei</code>   
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
			
                                        
                                         <tr valign="top"><th scope="row">Twitter Benutzername</th>
                                          <td>
						<input id="piratenkleider_theme_options[feed_twitter]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[feed_twitter]" value="<?php esc_attr_e( $options['feed_twitter'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[feed_twitter]"><?php _e( 'Der reine Twitter Benutzername', 'piratenkleider' ); ?></label>
					</td>					
                                        </tr>
                                         <tr valign="top"><th scope="row"><?php _e( 'Maximale Anzahl der Twittermeldungen', 'piratenkleider' ); ?></th>
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
                                                    <label class="description" for="piratenkleider_theme_options[feed_twitter_numberarticle]"><?php _e( 'Wieviele Twittermeldungen sollen maximal gezeigt werden', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>             

                                         </table>                                                                                
                                    </td>                                    
                                </tr>                            
				
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Slider', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                             <tr valign="top"><th scope="row"><?php _e( 'Slider aktivieren', 'piratenkleider' ); ?></th>
                                        	<td>
                                            	<input id="piratenkleider_theme_options[slider-aktiv]" name="piratenkleider_theme_options[slider-aktiv]" type="checkbox" value="1" <?php checked( '1', $options['slider-aktiv'] ); ?> />
						<label for="piratenkleider_theme_options[slider-aktiv]">Slider im Teaserbereich auf der Startseite aktivieren.
                                                <br>Die Auswahl der Plakatbilder kann unter den Defaultbildern angepasst werden.</label>
                                                </td>
                                            </tr>
                                             
                                             <tr valign="top"><th scope="row"><?php _e( 'Kategorie', 'piratenkleider' ); ?></th>
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
                                                    <label class="description" for="piratenkleider_theme_options[slider-catid]"><?php _e( 'Aus welcher Artikelkategorie sollen die Slider genommen werden', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>

                                            <tr valign="top"><th scope="row"><?php _e( 'Maximale Anzahl der Artikel', 'piratenkleider' ); ?></th>
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
                                                    <label class="description" for="piratenkleider_theme_options[slider-numberarticle]"><?php _e( 'Wieviele Slides sollen maximal gezeigt werden', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Animationstyp', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[slider-animationType]">
                                                        <?php
                                                                    $selected = $options['slider-animationType'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="fade" <?php if ($selected == 'fade') { echo 'selected="selected"'; }?>>fade</option>
                                                        <option style="padding-right: 10px;" value="slide" <?php if ($selected == 'slide') { echo 'selected="selected"'; }?>>slide</option>
                                                       						
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[slider-animationType]"><?php _e( 'Wie soll der Slidewechsel optisch aussehen', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Richtung', 'piratenkleider' ); ?></th>
                                            <td>
                                                    <select name="piratenkleider_theme_options[slider-Direction]">
                                                        <?php
                                                                    $selected = $options['slider-Direction'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="horizontal" <?php if ($selected == 'horizontal') { echo 'selected="selected"'; }?>>horizontal</option>
                                                        <option style="padding-right: 10px;" value="vertical" <?php if ($selected == 'vertical') { echo 'selected="selected"'; }?>>vertical</option>
                                                       						
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[slider-Direction]"><?php _e( 'Von wo sollen Bilder erscheinen', 'piratenkleider' ); ?></label>
                                            </td>
                                            </tr>                                            
                                            <tr valign="top"><th scope="row"><?php _e( 'Dauer Bildwechsel', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 5em;"  id="piratenkleider_theme_options[slider-slideshowSpeed]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[slider-slideshowSpeed]" value="<?php esc_attr_e( $options['slider-slideshowSpeed'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[slider-slideshowSpeed]"><?php _e( 'Geschwindigkeit des Bildwechsels in Milisekunden', 'piratenkleider' ); ?></label>
                                                    </td>

                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Animationsdauer', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 5em;" id="piratenkleider_theme_options[slider-animationDuration]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[slider-animationDuration]" value="<?php esc_attr_e( $options['slider-animationDuration'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[slider-animationDuration]"><?php _e( 'Geschwindigkeit der Animation/Fading beim Bild&uuml;bergang in Milisekunden', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>

                                            
                                            <tr valign="top"><th scope="row"><?php _e( 'Bezeichnender Titel f&uuml;r Teaser', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 15em;" id="piratenkleider_theme_options[teaser-subtitle]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-subtitle]" value="<?php esc_attr_e( $options['teaser-subtitle'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-subtitle]"><?php _e( 'Dieser Text wird oberhalb der Titel angezeigt', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Maximale Textl&auml;nge des Titels im Teaser', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 3em;" id="piratenkleider_theme_options[teaser-title-maxlength]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-title-maxlength]" value="<?php esc_attr_e( $options['teaser-title-maxlength'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-title-maxlength]"><?php _e( 'Wie lang darf der Titel insgesamt sein, bevor er gek&uuml;rzt wird', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            <tr valign="top"><th scope="row"><?php _e( 'Wortzahl des Titels im Teaser', 'piratenkleider' ); ?></th>
                                                  <td>
                                                            <input style="width: 3em;" id="piratenkleider_theme_options[teaser-title-words]" class="regular-text" type="text" length="5" name="piratenkleider_theme_options[teaser-title-words]" value="<?php esc_attr_e( $options['teaser-title-words'] ); ?>" />
                                                            <label class="description" for="piratenkleider_theme_options[teaser-title-words]"><?php _e( 'Zahl der Worte im Teaser; Die maximale Textl&auml;nge begrenzt diesen Wert jedoch.', 'piratenkleider' ); ?></label>
                                                    </td>					
                                            </tr>
                                            
                                            
                                                         
                                        </table>                                                                                
                                    </td>                                    
                                </tr>    
                                <tr valign="top">
                                    <th scope="row">Spezialseiten</th>
                                    <td>

                                        <table>                                
                                     
                                        <tr valign="top"><th scope="row">Newsletter</th>
                                          <td>
						<input style="width: 40em;" id="piratenkleider_theme_options[url-newsletteranmeldung]" class="regular-text" type="text"  name="piratenkleider_theme_options[url-newsletteranmeldung]" value="<?php esc_attr_e( $options['url-newsletteranmeldung'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[url-newsletteranmeldung]">URL, inkl. http://, zur Seite auf der man sich in Newsletter eingetragen werden kann. Default: <code><?php echo $defaultoptions['url-newsletteranmeldung']; ?></code></label>
					</td>					
                                        </tr>
                                       </table>  
                                       
                                            
                                            
                                    </td>                                    
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Meta-Angaben', 'piratenkleider' ); ?></th>
                                    <td>

                                        <table>                                
                                         <tr valign="top"><th scope="row"><?php _e( 'Author', 'piratenkleider' ); ?></th>
                                              <td>
                                                        <input id="piratenkleider_theme_options[meta-author]" class="regular-text" type="text"  name="piratenkleider_theme_options[meta-author]" value="<?php esc_attr_e( $options['meta-author'] ); ?>" />
                                                        <label class="description" for="piratenkleider_theme_options[meta-author]"><?php _e( 'Optionale Autor-Angabe in dem Meta-Tag jeder Seite', 'piratenkleider' ); ?></label>
                                                </td>					
                                        </tr>
                                         <tr valign="top"><th scope="row"><?php _e( 'Description', 'piratenkleider' ); ?></th>
                                              <td>
                                                        <input id="piratenkleider_theme_options[meta-description]" class="regular-text" type="text"  name="piratenkleider_theme_options[meta-description]" value="<?php esc_attr_e( $options['meta-description'] ); ?>" />
                                                        <label class="description" for="piratenkleider_theme_options[meta-description]"><?php _e( 'Optionale Beschreibungstext in dem Meta-Tag jeder Seite (f&uuml;r alle gleich). Sollte nicht mehr als 140 Zeichen lang sein, wenn gesetzt.', 'piratenkleider' ); ?></label>
                                                </td>					
                                        </tr>
                                        <tr valign="top"><th scope="row"><?php _e( 'Keywords', 'piratenkleider' ); ?></th>
                                          <td>
						<input id="piratenkleider_theme_options[meta-keywords]" class="regular-text" type="text" name="piratenkleider_theme_options[meta-keywords]" value="<?php esc_attr_e( $options['meta-keywords'] ); ?>" />
						<label class="description" for="piratenkleider_theme_options[meta-keywords]"><?php _e( 'Optionale Schl&uuml;sselworte in dem Meta-Tag jeder Seite (f&uuml;r alle gleich). Durch Komma getrennt. Schl&uuml;sselworte sollten tats&auml;chlich vorkommen.', 'piratenkleider' ); ?></label>
					</td>					
                                        </tr>
                                       </table>  
                                        <p>
                                            Hinweis: Diese Angaben wirken auf alle Seiten und Artikel der Site. Dies
                                            ist jedoch nicht immer sinnvoll (insbes. bei Keywords und Description). 
                                            Sollten zudem SEO-Plugins, wie bspw. wpSEO o.a. im Einsatz sein,
                                            sollten diese Angaben ebenfalls unausgef&uuml;llt bleiben.                                                                                                                                    
                                        </p>
                                    </td>                                    
                                </tr>    
                                <tr valign="top">
                                    <th scope="row"><?php _e( 'Sicherheit &amp; Anonymit&auml;t', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                        <tr valign="top"><th scope="row">Autoren anzeigen</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-autoren]" name="piratenkleider_theme_options[aktiv-autoren]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-autoren'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-autoren]"><?php _e( 'Bei der Anzeige von Artikeln den Autoren anzeigen und verlinken.', 'piratenkleider' ); ?></label>
					</td>
                                        </tr>
                                        <tr valign="top"><th scope="row">Kommentarbenutzer anonymisieren</th>
					<td>
						<input id="piratenkleider_theme_options[anonymize-user]" name="piratenkleider_theme_options[anonymize-user]" type="checkbox" value="1" <?php checked( '1', $options['anonymize-user'] ); ?> />
						<label  for="piratenkleider_theme_options[anonymize-user]"><?php _e( 'IP-Adresse und der User-Agent-String geleert, die Eingabe von E-Mail-Adressen wird verhindert', 'piratenkleider' ); ?></label>
                                                <p><b>Achtung:</b> Diese Option deaktiviert auch die Avatar-Anzeige und
                                                    setzt die Kommentareinstellung unter Einstellungen-Diskussion so,
                                                    dass Benutzer keinen Namen und E-Mail-Adressen mehr eingeben m&uuml;ssen.</p>
                                                
                                                <p>
                                                   In diesem Fall angebotene Kommentarfelder:
                                                </p>   
                                                <select name="piratenkleider_theme_options[anonymize-user-commententries]">
                                                        <?php 
                                                                    $selected = $options['anonymize-user-commententries'];
                                                        ?>            
                                                        <option style="padding-right: 10px;" value="0" <?php if ($selected == '0') { echo 'selected="selected"'; }?>>Name, URL und E-Mail (Wordpress-Default)</option>					
                                                        <option style="padding-right: 10px;" value="1" <?php if ($selected == '1') { echo 'selected="selected"'; }?>>Name</option>
                                                        <option style="padding-right: 10px;" value="2" <?php if ($selected == '2') { echo 'selected="selected"'; }?>>Name und URL</option>
                                                       	
                                                    </select>
                                                    <label class="description" for="piratenkleider_theme_options[anonymize-user-commententries]"><?php _e( 'Angebote Kommentarfelder zur freiwilligen Eingabe', 'piratenkleider' ); ?></label>

					</td>
                                        </tr>
                                        <tr valign="top"><th scope="row">Avatare anzeigen</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-avatar]" name="piratenkleider_theme_options[aktiv-avatar]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-avatar'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-avatar]"><?php _e( 'Bei Kommentaren werden Avatar-Bilder mit Hilfe von Gravatar oder anderen Diensten abgerufen. Dies erm&ouml;glicht allerdings theoretisch ein Tracking durch diese Dienste', 'piratenkleider' ); ?></label>
					</td>
                                        </tr>                                        
                                       </table>                                         
                                    </td>                                    
                                </tr>    
                                  <tr valign="top">
                                    <th scope="row"><?php _e( 'Sonstiges', 'piratenkleider' ); ?></th>
                                    <td>
                                        <table>
                                        <tr valign="top"><th scope="row">Antwortlinks auf Kommentare</th>
					<td>
						<input id="piratenkleider_theme_options[aktiv-commentreplylink]" name="piratenkleider_theme_options[aktiv-commentreplylink]" type="checkbox" value="1" <?php checked( '1', $options['aktiv-commentreplylink'] ); ?> />
						<label  for="piratenkleider_theme_options[aktiv-commentreplylink]"><?php _e( 'Bei der Anzeige von Kommentaren, wird unter diesen ein eigener Kommentarlink eingebaut, der das Antworten auf den Kommentar erlaubt. Dies kann zu einer Nutzung des Kommentarbereiches wie bei einem Forum f&uuml;hren, bei dem es zuletzt aber nicht mehr um den eigentlichen Beitrag geht.', 'piratenkleider' ); ?></label>
					</td>
                                        </tr>
                                </table>                                         
                                    </td>                                    
                                </tr>             
                                        
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Optionen speichern', 'piratenkleider' ); ?>" />
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
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Segel setzen: Defaultbilder ', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Defaultbilder wurden gespeichert.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
                    <?php settings_fields( 'piratenkleider_defaultbilder' ); ?>
                    <?php $options = get_option( 'piratenkleider_theme_defaultbilder' ); 
                        $defaultbildsrc = $options['slider-defaultbildsrc']; 
                        $defaultseitenbildsrc = $options['seiten-defaultbildsrc']; 
                        
                    ?>
                    <table class="form-table">
                     <tr valign="top">
                        <th scope="row"><?php _e( 'Defaultbilder f&uuml;r Slider', 'piratenkleider' ); ?></th>
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
                                <h3>Alternatives Sliderbild als URL</h3>
                                 <input id="piratenkleider_theme_defaultbilder[slider-alternativesrc]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[slider-alternativesrc]" value="<?php esc_attr_e( $options['slider-alternativesrc'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_defaultbilder[slider-alternativesrc]">
                                URL inkl. http:// zum Bild. Dieses kann auch vorher &uuml;ber den Mediendialog hochgeladen worden sein.                        
                                <br>
                                Das Bild sollte nicht breiter als 705 Pixel sein und seine wesentlichen Merkmale auf einer
                                H&ouml;he von 240 Pixel zeigen. In der Darstellung der Seite wird ab 240 Pixel nach unten abgeschnitten.
                            </label>
                                 <br />
                            </td>
                        </tr>  
                    
                     <tr valign="top">
                        <th scope="row"><?php _e( 'Defaultbilder f&uuml;r Seiten', 'piratenkleider' ); ?></th>
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
                                <h3>Alternatives Seitenbild als URL</h3>
                                <input id="piratenkleider_theme_defaultbilder[seiten-alternativesrc]" class="regular-text" type="text" name="piratenkleider_theme_defaultbilder[seiten-alternativesrc]" value="<?php esc_attr_e( $options['seiten-alternativesrc'] ); ?>" />
                               <label class="description" for="piratenkleider_theme_defaultbilder[seiten-alternativesrc]">
                                URL inkl. http:// zum Bild. Dieses kann auch vorher &uuml;ber den Mediendialog hochgeladen worden sein.                               
                                <br>
                                Das Bild sollte nicht breiter als 705 Pixel sein und seine wesentlichen Merkmale auf einer
                                H&ouml;he von 150 Pixel zeigen. In der Darstellung der Seite wird ab 150 Pixel nach unten abgeschnitten.
                                   
                              </label>
                                 <br />
                            </td>
                        </tr>
                        <tr valign="top">
                        <th scope="row"><?php _e( 'Defaultplakate f&uuml;r Sidebar', 'piratenkleider' ); ?></th>
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
                                    Diese Bilder werden in der Sidebar rechts gezeigt, sofern dieses &uuml;ber die Optionen (vgl. Slider) auch eingeschaltet ist.                                    
                                </p>
                                    
                                    
                                
                                <h3>Eigene Plaktbilder:</h3>
                                
                                <textarea id="piratenkleider_theme_defaultbilder[plakate-altadressen]" class="large-text" cols="30" rows="5" name="piratenkleider_theme_defaultbilder[plakate-altadressen]"><?php echo esc_textarea( $options['plakate-altadressen'] ); ?></textarea>
				<label class="description" for="piratenkleider_theme_defaultbilder[plakate-altadressen]"><?php _e( 'Adressen alternativer Plakatbilder', 'piratenkleider' ); ?></label>

                                <p>    
                                Angabe der URLs inkl. http:// zum Bild. Wenn es mehrere sind, werden
                                die einzelnen Adressen durch ein Komma oder Umbruch getrennt. 
                                Wenn oben Defaultplakate angeklickt sind, erscheinen diese Bilder zus&auml;tzlich.
                                Diese Bilder k&ouml;nnen auch vorher &uuml;ber den Mediendialog hochgeladen worden sein.                               
                                <br>
                                Die Bilder sollten jeweils exakt 277x391 Pixel gro&szlig; sein.
                                 </p>      
                              </label>
                                 <br />
                            </td>
                        </tr>
             </table>

            <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e( 'Optionen speichern', 'piratenkleider' ); ?>" />
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
		<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Captn & Crew: Kontaktinformationen setzen ', 'piratenkleider' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Kontaktinformationen wurden gespeichert.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
                    <?php settings_fields( 'piratenkleider_kontaktinfos' ); ?>
                    <?php $options = get_option( 'piratenkleider_theme_kontaktinfos' ); 
                        
                        
                    ?>
                    <table class="form-table">
                       <tr valign="top"><th scope="row">Impressumsangaben</th>
			<td>
                            <table>                                
                            <tr valign="top"><th scope="row">Verantwortliche/r</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[impressumperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[impressumperson]" value="<?php esc_attr_e( $options['impressumperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[impressumperson]">
                                        Verantwortliche/r gem&auml;&szlig; &sect; 5 TMG. <br>
                                       Zum Beispiel: <code>Martin Mustermann</code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">Textbezeichnung Dienstanbieter</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]" value="<?php esc_attr_e( $options['impressumdienstanbieter'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[impressumdienstanbieter]">
                                        Textbezeichnung des Dienstanbieter des Webauftritts.<br>
                                        Beispiel: <code>Kreisverband Musterstadt der Piratenpartei Deutschland 
                                            vertreten durch den Vorstand Martin Mustermann, Doris Fischer und Florian Meister.</code>
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
                                        Anschrift: Titel (1. Zeile). <br>
                                        Zum Beispiel: <code>Piratenpartei</code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">zu H&auml;nden</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[postperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[postperson]" value="<?php esc_attr_e( $options['postperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[postperson]">
                                        Anschrift: Optionale Personenangabe ("zu H&auml;nden") <br>
                                        Zum Beispiel: <code>Martin Mustermann</code>
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row">Strasse oder Postfach</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[poststrasse]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[poststrasse]" value="<?php esc_attr_e( $options['poststrasse'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[poststrasse]">
                                        Anschrift: Strassenname und Nummer oder Postfachangabe oder freilassen <br>
                                        Zum Beispiel: <code>Unbesonnenheitsweg 123b</code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">PLZ und Stadt</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[poststadt]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[poststadt]" value="<?php esc_attr_e( $options['poststadt'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[poststadt]">
                                        Anschrift: Postleitzahl gefolgt von Stadt<br>
                                        Zum Beispiel: <code>12345  Ankh-Morpork</code>
                                    </label>
                                </td>					
                            </tr>
                        </table>  	
                            
                            
			</td>
		       </tr>
                       <tr valign="top"><th scope="row">Ladungsf&auml;hige Anschrift</th>
			<td>
				<p>Optionale Angaben f&uuml;r Rechtssachen. Werden diese Angaben frei gelassen, werden die
                                    Daten der Postanschrift verwendet.</p>
                                 <table>                                
                            <tr valign="top"><th scope="row">Name oder Titel</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungtitel]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungtitel]" value="<?php esc_attr_e( $options['ladungtitel'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungtitel]">
                                        Anschrift: Titel (1. Zeile). <br>
                                        Zum Beispiel: <code>Piratenpartei</code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">zu H&auml;nden</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungperson]" value="<?php esc_attr_e( $options['ladungperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungperson]">
                                        Anschrift: Optionale Personenangabe ("zu H&auml;nden"). SOllte in der Regel dieselbe Person sein,
                                        die oben als verantwortliche Person f&uuml;r das Impressum definiert ist.<br>
                                        Zum Beispiel: <code>Martin Mustermann</code>
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row">Strasse oder Postfach</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungstrasse]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungstrasse]" value="<?php esc_attr_e( $options['ladungstrasse'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungstrasse]">
                                        Anschrift: Strassenname und Nummer oder Postfachangabe oder freilassen <br>
                                        Zum Beispiel: <code>Unbesonnenheitsweg 123b</code>
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">PLZ und Stadt</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[ladungstadt]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[ladungstadt]" value="<?php esc_attr_e( $options['ladungstadt'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[ladungstadt]">
                                        Anschrift: Postleitzahl gefolgt von Stadt<br>
                                        Zum Beispiel: <code>12345  Ankh-Morpork</code>
                                    </label>
                                </td>					
                            </tr>
                        </table>  
			</td>
		       </tr>
                        <tr valign="top"><th scope="row">Offizielle E-Mailadresse</th>
			<td>
				<input id="piratenkleider_theme_kontaktinfos[kontaktemail]" class="regular-text" type="text" length="5" name="piratenkleider_theme_kontaktinfos[kontaktemail]" value="<?php esc_attr_e( $options['kontaktemail'] ); ?>" />
				<label class="description" for="piratenkleider_theme_kontaktinfos[kontaktemail]">
                                    Feste Mailadresse f&uuml;r offizielle Kontakte. 
                                    <br>Zum Beispiel: <code><?php echo bloginfo('admin_email'); ?></code>
                                </label>
			</td>
		       </tr>
                       
                       <tr valign="top"><th scope="row">Datenschutzbeauftragter</th>
			<td>
				<p>Optionale Angaben zu einem Datenschutzbeauftragten. Wenn dieser nicht angegeben wird,
                                wird die E-Mail-Adresse des Bundesdatenschutzbeauftragten angegeben.</p>
                                 <table>                                

                            <tr valign="top"><th scope="row">Name</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[dsbperson]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[dsbperson]" value="<?php esc_attr_e( $options['dsbperson'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[dsbperson]">
                                        Name des DSB<br>
                                        Zum Beispiel: <code>Martin Mustermann</code>
                                    </label>
                                </td>					
                            </tr>
                             <tr><th scope="row">E-Mailadresse</th>
                            <td>
				<input id="piratenkleider_theme_kontaktinfos[dsbemail]" class="regular-text" type="text" length="5" name="piratenkleider_theme_kontaktinfos[dsbemail]" value="<?php esc_attr_e( $options['dsbemail'] ); ?>" />
				<label class="description" for="piratenkleider_theme_kontaktinfos[dsbemail]">
                                    Feste Mailadresse f&uuml;r offizielle Kontakte. 
                                    <br>Zum Beispiel:  <code>bundesbeauftragter@piraten-dsb.de</code>
                                </label>
			</td>
                          </tr>
                            
                        </table>  
			</td>
		       </tr>
                       
                       <tr valign="top"><th scope="row">Spendenformulare</th>
			<td>
				<p>Optionale Angaben f&uuml;r Spendenformulare, die mit dem Seiten-Template "Spenden" erstellt werden.
                                    <br>
                                    <strong>Achtung:</strong> Dies ersetzt nicht das 
                                    richtige Eingabeformular. Das Formular wird
                                    z.B.mit dem Plugin <em>Contact Form 7</em> erstellt und dann
                                    als Makro in den Textbereich der Seite hinzugef&uuml;gt.
                                    <br>
                                    Die folgenden Daten werden nur dazu verwendet, 
                                    die Tabelle f&uuml;r die  feststehenden Informationen aufzubauen.
                                </p>
                                 <table>                                

                            <tr valign="top"><th scope="row">Empf&auml;nger</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenempfaenger]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenempfaenger]" value="<?php esc_attr_e( $options['spendenempfaenger'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenempfaenger]">
                                      Name des Empf&auml;ngers/Konto der Spenden f&uuml;r &Uuml;berweisungen. 
                                    </label>
                                </td>					
                            </tr>
                              <tr valign="top"><th scope="row">Kontonummer</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenkonto]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenkonto]" value="<?php esc_attr_e( $options['spendenkonto'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenkonto]">
                                      Kontonummer des Empf&auml;ngers
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row">BLZ</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenblz]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenblz]" value="<?php esc_attr_e( $options['spendenblz'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenblz]">
                                     Die Bankleitzahl.
                                    </label>
                                </td>					
                            </tr>
                            <tr valign="top"><th scope="row">Bank</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendenbank]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendenbank]" value="<?php esc_attr_e( $options['spendenbank'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendenbank]">
                                     Ausgeschriebener Name der Bank
                                    </label>
                                </td>					
                            </tr>
                             <tr valign="top"><th scope="row">IBAN</th>
                                <td>
                                    <input id="piratenkleider_theme_kontaktinfos[spendeniban]" class="regular-text" type="text" name="piratenkleider_theme_kontaktinfos[spendeniban]" value="<?php esc_attr_e( $options['spendeniban'] ); ?>" />
                                    <label class="description" for="piratenkleider_theme_kontaktinfos[spendeniban]">
                                     Internationale Bank Account Nummer
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
                    <input type="submit" class="button-primary" value="<?php _e( 'Speichern', 'piratenkleider' ); ?>" />
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
		<div class="updated fade"><p><strong><?php _e( 'Designeinstellungen wurden gespeichert.', 'piratenkleider' ); ?></strong></p></div>
		<?php endif; ?>
                <p><b>Achtung:</b> Diese Einstellungen sollten nur in Ausnahmef&auml;llen ge&auml;ndert werden. Bei einer 
                falschen Nutzung k&ouml;nnen Eingaben die Gestaltung des Webauftritts sch&auml;digen. <br>
                In anderen Worten: <em>Jo min Jun. Dat wat du hier doust, dat geit voll uff de 
                Basansegel. Pass du jo up!</em>
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
                       <tr valign="top"><th scope="row">Höhe des Kopfbereiches ( .header )</th>
                        <td>
                            <input id="piratenkleider_theme_designspecials[css-default-header-height]" type="text" 
                                   name="piratenkleider_theme_designspecials[css-default-header-height]" 
                                    style="width: 5em;"
                                   value="<?php esc_attr_e( $options['css-default-header-height'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_designspecials[css-default-header-height]">
                               Wenn dieser Wert sich von der Defaulteinstellung von
                               <?php echo $defaultoptions['css-default-header-height']; ?> Pixel aus 
                               der CSS Datei piratenkleider.css (Zeile 1926) 
                               unterscheidet, wird er &uuml;ber ein Inline-CSS nachträglich
                               im Kopfteil des HTML-Documents ge&auml;ndert.<br>
                               <b>Achtung:</b> Die Verkleinerung der Höhe des Kopfteils ist
                               nicht ungef&auml;hrlich. Zu beachten ist, dass der Kopfteil
                               auch bei einer Vergr&ouml;&szlig;erung des Textes auf 200% noch
                               gen&uuml;gend Platz haben muss!
                            </label>
                        </td>					                           
		       </tr>
                        <tr valign="top"><th scope="row">Abstand des Brandingbereiches (=Logo) nach oben ( .header .branding )</th>
                        <td>
                            <input id="piratenkleider_theme_designspecials[css-default-branding-padding-top]" type="text" 
                                   name="piratenkleider_theme_designspecials[css-default-branding-padding-top]" 
                                   style="width: 5em;"
                                   value="<?php esc_attr_e( $options['css-default-branding-padding-top'] ); ?>" />
                            <label class="description" for="piratenkleider_theme_designspecials[css-default-branding-padding-top]">
                               Das Logo hat einen Abstand nach oben. Diese kann &uuml;ber diese Angabe reduziert werden.
                                                              Wenn dieser Wert sich von der Defaulteinstellung von
                               <?php echo $defaultoptions['css-default-branding-padding-top']; ?> Pixel aus 
                               der CSS Datei piratenkleider.css 
                               unterscheidet, wird er &uuml;ber ein Inline-CSS nachträglich
                               im Kopfteil des HTML-Documents ge&auml;ndert.<br>
                               
                               <br><b>Achtung:</b> Wenn Socialmedia-Icons und Linkmenu oben auch erscheinen,
                                sollte dieser Abstand nicht zu klein sein, da diese Icons und  der Text der Links
                                bei steigender Gr&ouml;&szlig;e nach Links zum Logo wandert und es so zu &Uuml;berlapplungen
                                kommen k&ouml;nnte.
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
                                                   Wenn gesetzt, &auml;ndert die Default-Hintergrundfarbe ab.
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
                                                  Wenn gesetzt, &auml;ndert die Position des Hintergrundbildes .
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
                                                  Wenn gesetzt, &auml;ndert die Repeat-Eigenschaft des Hintergrundbildes.
                                            </label>
                                           
                                       </td>                                                                              
                                   </tr>
                               </table> 
                               
                               
                           </td>    
                       </tr>
                      
                       
                        <tr valign="top"><th scope="row">Eigene CSS-Anweisungen</th>
                        <td>
                            <textarea id="piratenkleider_theme_designspecials[css-eigene-anweisungen]" 
                                      class="large-text" cols="30" rows="10" 
                                      name="piratenkleider_theme_designspecials[css-eigene-anweisungen]"><?php echo esc_textarea( $options['css-eigene-anweisungen'] ); ?></textarea>
                            <label class="description" 
                                   for="piratenkleider_theme_designspecials[css-eigene-anweisungen]">
                                       <?php _e( 'Eigene CSS-Anweisungen, die Inline im Kopfteil der Dokumente erg&auml;nzt werden', 'piratenkleider' ); ?></label>

                        </td>					                           
		       </tr>
                       
                         <tr valign="top"><th scope="row">Eigene HTML-Anweisungen</th>
                        <td>
                            <textarea id="piratenkleider_theme_designspecials[html-eigene-anweisungen]" 
                                      class="large-text" cols="30" rows="10" 
                                      name="piratenkleider_theme_designspecials[html-eigene-anweisungen]"><?php echo esc_textarea( $options['html-eigene-anweisungen'] ); ?></textarea>
                            <label class="description" 
                                   for="piratenkleider_theme_designspecials[html-eigene-anweisungen]">
                                       <?php _e( 'Eigene HTML-Anweisungen,  die am Ende der Webseite, vor dem letzten &lt;/body&Gt;&lt;/html&gt; plaziert werden', 'piratenkleider' ); ?></label>
                            <p> <b>Achtung:</b> Fehlerhafter HTML-, JavaScript oder CSS-Code an dieser Stelle
                                kann zu einem Nicht-Funktionieren der gesamt Website f&uuml;hren!<br />
                                Der hier eingegebene Code wird nicht gefiltert oder kontrolliert.
                            </p>
                        </td>					                           
		       </tr>
                       
                    </table>

            <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e( 'Speichern', 'piratenkleider' ); ?>" />
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
