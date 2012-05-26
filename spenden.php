<?php
/* 
 Template Name: Spenden
 */
?>
<?php get_header();
 $options = get_option( 'piratenkleider_theme_options' );  
 $kontaktinfos = get_option( 'piratenkleider_theme_kontaktinfos' );  
        if (!isset($options['src-default-symbolbild'])) 
            $options['src-default-symbolbild'] = $defaultoptions['src-default-symbolbild'];
?>
<div class="section content">
  <div class="row">
    <div class="content-primary">
      <div class="content-header">
        <h1 id="page-title"><span>Spenden</span></h1>   
        <?php if (has_post_thumbnail()) { 
            echo '<div class="symbolbild">';
              the_post_thumbnail(); 
            echo '</div>';  
        } else {            
           if ($options['aktiv-platzhalterbilder-indexseiten']) { ?>         
            <div class="symbolbild"> 
              <img src="<?php echo $options['src-default-symbolbild']?>" alt="" >
           </div>                                 
          <?php }     
            }   
         ?>
      </div>
      <div class="skin">

        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
        <?php edit_post_link( __( 'Bearbeiten', 'piratenkleider' ), '', '' ); ?>
        <?php endwhile; ?>
          
          
     <?php if ((isset($kontaktinfos['spendenkonto']))
          && (isset($kontaktinfos['spendenempfaenger']))
         && (isset($kontaktinfos['spendenblz']))) { ?>
          <h2>Per &Uuml;berweisung spenden</h2>
          
        <table>            
        <tbody>
        <tr>
           <th>Empf&auml;nger</th>
         <td><?php esc_attr_e( $kontaktinfos['spendenempfaenger'] ); ?></td>
        </tr>
        <tr>
            <th>Kontonummer</th>
         <td><?php esc_attr_e( $kontaktinfos['spendenkonto'] ); ?></td>
        </tr>
        <tr>
           <th>Bankleitzahl</th>
            <td><?php esc_attr_e( $kontaktinfos['spendenblz'] ); ?></td>
        </tr>
        <tr>
          <th>Bank</th>
           <td><?php esc_attr_e( $kontaktinfos['spendenbank'] ); ?></td>
        </tr>
        <tr>
            <th>IBAN</th>
           <td><?php esc_attr_e( $kontaktinfos['spendeniban'] ); ?></td>
        </tr>
        <tr>
           <th>BIC</th>
            <td><?php esc_attr_e( $kontaktinfos['spendenbic'] ); ?></td>
        </tr>
        <tr>
           <th>Verwendungszweck</th>
           <td>Spende von Name, Vorname, Anschrift (ggf. mit Zusatz "Stichwort" 
            und einem konkreten Verwendungszweck)</td>
        </tr>
        </tbody>
        </table>
          
<p>Bei Angabe von Name und Anschrift im Feld <em>Verwendungszweck</em> &uuml;bersenden 
    wir ab einem Betrag von 200 Euro oder auf Wunsch eine formelle 
    Zuwendungsbest&auml;tigung beziehungsweise eine Spendenbescheinigung zur 
    Einreichung beim Finanzamt. Unterhalb dieses Betrages reicht dem Finanzamt 
    der Einzahlungs- oder &Uuml;berweisungs- oder Abbuchungsbeleg der eigenen Bank.</p>


<h3>Regelm&auml;&szlig;ige Spenden</h3>
<p>Vielen Dank f&uuml;r Einzelspenden! <br>
    Um aber langfristig planen zu k&ouml;nnen und R&uuml;cklagen f&uuml;r Wahlen aufbauen zu 
    k&ouml;nnen freuen wir uns auch besonders &uuml;ber regelm&auml;&szlig;ige Spenden - auch kleine 
    Betr&auml;ge. Wenn Du einen Dauerauftrag bei Deiner Bank einrichten kannst 
    w&uuml;rde uns das sehr helfen. Schon ein paar Euro im Monat erm&ouml;glichen uns 
    auch langfristige Finanzierungen zu &uuml;bernehmen - wie z.B.  f&uuml;r 
    <a class="extern" href="http://www.anonym-surfen.de/">Anonymisierungsdienste</a>. Zudem sind 
    unsere Mitglieder aufgerufen freiwillig 1% ihres Netto-Einkommens monatlich
    zu spenden.</p>

<h3>Steuer-Tipp</h3>
<p>Bis zu einer H&ouml;he von 1650 Euro (3300 Euro bei Ehepaaren) pro Jahr k&ouml;nnen 
    Mitgliedsbeitr&auml;ge und Spenden an politische Parteien als Steuererm&auml;&szlig;igung
    nach  &sect; 34g EStG geltend gemacht werden. Diese Steuererm&auml;&szlig;igungen wirken 
    sich zu f&uuml;nfzig Prozent direkt steuermindernd aus. Das bedeutet, f&uuml;r jeden 
    Euro Spende erh&auml;lt man f&uuml;nfzig Cent Steuerminderung. Hat man in einem Jahr 
    mehr als 1650 Euro (3300 Euro bei Ehepaaren) an Mitgliedsbeitr&auml;gen und 
    Spenden an politische Parteien bezahlt, kann man dar&uuml;ber hinaus gehende 
    Spenden bis zu weiteren 1650 Euro (3300 Euro bei Ehepaaren) als 
    Sonderausgaben nach &sect; 10b EStG geltend machen. Sonderausgaben werden vom zu 
    versteuernden Einkommen abgezogen. Wie viel man hier konkret spart, h&auml;ngt 
    vom eigenen Steuersatz ab. (Stand: 11/2011)</p>

<?php } else { ?>

<div class="box warning">
    <p>
       
        F&uuml;r diesen Webauftritt wurden noch keine eigenen Informationen
        zu Spenden (eigene Kontonumer, BLZ u.a.) gespeichert.</p>
        <p>
        Sollten Sie f&uuml;r die Piratenpartei Deutschland spenden wollen, 
        rufen Sie die
        <a class="extern" href="https://www.piratenpartei.de/mitmachen/spenden/">Spendenseiten der Piratenpartei Deutschland</a>
        auf.        
        
    </p>       
</div>
<?php } ?>

<h2>Wenn einmal etwas unklar sein sollte...</h2>

<p>Unsere Gesch&auml;ftsstelle steht per E-Mail, Telefon oder Fax zur Verf&uuml;gung. 
    Alle Wege zu uns sind im Impressum aufgef&uuml;hrt.</p>
          
          
      </div>
    </div>

    <div class="content-aside">
      <div class="skin">

        <h1 class="skip"><?php echo $defaultoptions['default_text_title_sidebar']; ?></h1>   
            <?php
            if (!isset($options['zeige_subpagesonly'])) 
            $options['zeige_subpagesonly'] = $defaultoptions['zeige_subpagesonly'];
  
            if (!isset($options['zeige_sidebarpagemenu'])) 
            $options['zeige_sidebarpagemenu'] = $defaultoptions['zeige_sidebarpagemenu'];

          if ($options['zeige_sidebarpagemenu']==1) {   
           if ($options['zeige_subpagesonly']==1) {
                //if the post has a parent

                if($post->post_parent){
                    //collect ancestor pages
                    $relations = get_post_ancestors($post->ID);
                    //get child pages
                    $result = $wpdb->get_results( 'SELECT ID FROM '.$wpdb->prefix.'posts WHERE post_parent = '.$post->ID.' AND post_type=\'page\'' );
                    if ($result){
                        foreach($result as $pageID){
                            array_push($relations, $pageID->ID);
                        }
                    }
                    //add current post to pages
                    array_push($relations, $post->ID);
                    //get comma delimited list of children and parents and self
                    $relations_string = implode(",",$relations);
                    //use include to list only the collected pages. 
                    $sidelinks = wp_list_pages("sort_column=menu_order&title_li=&echo=0&include=".$relations_string);
                }else{
                    // display only main level and children
                    $sidelinks = wp_list_pages("sort_column=menu_order&title_li=&echo=0&depth=1&child_of=".$post->ID);
                }

                if ($sidelinks) { ?>
                <ul class="menu">
                    <?php //links in <li> tags
                    echo $sidelinks; ?>
                </ul>         
                <?php } 
                             
             } else {
          
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array('depth' => 0, 'container_class' => 'menu-header', 'theme_location' => 'primary', 'walker'  => new My_Walker_Nav_Menu()) );      
                } else { 
                ?>
                <ul class="menu">
                    <?php  wp_page_menu( ); ?>
                </ul> 
                <?php 
                } 
             }
          }
        
            get_sidebar(); ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
