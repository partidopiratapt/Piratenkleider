<?php
/*
  Template Name: Datenschutzerklaerung
 */
?>
<?php 
    get_header();
    global $options;  
        ?>

<div class="section content" id="main-content">
    <div class="row">
        <div class="content-primary">
	
	<?php if ( have_posts() ) while ( have_posts() ) : the_post();         
        $custom_fields = get_post_custom();
        ?>

	<?php
	    $image_url = '';
	    $image_alt = '';
            $attribs = array(
                "credits" => $options['img-meta-credits'],
            );
	    if (has_post_thumbnail()) { 
		$thumbid = get_post_thumbnail_id(get_the_ID());
		 // array($options['bigslider-thumb-width'],$options['bigslider-thumb-height'])
		$image_url_data = wp_get_attachment_image_src( $thumbid, 'full');
		$image_url = $image_url_data[0];
		$attribs = piratenkleider_get_image_attributs($thumbid);

                } else {
		if (($options['aktiv-platzhalterbilder-indexseiten']==1) && (isset($options['src-default-symbolbild']))) {  
		    $image_url = $options['src-default-symbolbild'];		    
		}
	    }
	    
	    if (isset($image_url) && (strlen($image_url)>4)) { 
		if ($options['indexseitenbild-size']==1) {
		    echo '<div class="content-header-big">';
		} else {
		    echo '<div class="content-header">';
      }
?>
		   <h1 class="post-title"><span><?php the_title(); ?></span></h1>
		   <div class="symbolbild"><img src="<?php echo $image_url ?>" alt="">
		    <?php if (isset($attribs["credits"]) && (strlen($attribs["credits"])>1)) {
		     echo '<div class="caption">'.$attribs["credits"].'</div>';  
		   }  ?>
		   </div>
            </div>
	    <?php } ?>

            <div class="skin">
        <?php if (!(isset($image_url) && (strlen($image_url)>4))) { ?>
	    <h1 class="post-title"><span><?php the_title(); ?></span></h1>
	<?php } ?>
	
	


        <?php the_content(); ?>
        <?php edit_post_link( __( 'Bearbeiten', 'piratenkleider' ), '', '' ); ?>
    <?php endwhile; ?>


          <p>Die Piratenpartei Deutschland fordert nicht nur strengeren Datenschutz, sie setzt ihn auch selber praktisch um. 
              Personenbezogene Daten werden auf dieser Webseite nur im technisch unbedingt notwendigen Umfang erhoben.
              In keinem Fall werden die erhobenen Daten verkauft oder aus anderen Gr&uuml;nden an Dritte weitergegeben. 
              Sollte es ausnahmsweise doch einmal notwendig werden, ihre Daten an Dritte weiterzugeben, so werden wir sie, 
              f&uuml;r jede &Uuml;bermittlung einzeln, vorher um Erlaubnis fragen.</p>
               <p>
              Die nachfolgende Erkl&auml;rung gibt Ihnen einen &Uuml;berblick dar&uuml;ber, wie wir diesen Schutz gew&auml;hrleisten 
              und welche Art von Daten zu welchem Zweck erhoben werden.</p>

               <h2>Datenverarbeitung auf diesem Webangebot</h2>

<p>
Die Nutzung des Webangebots ist ohne Angabe personenbezogener Daten m&ouml;glich. 
Eine Speicherung von Verbindungsdaten (beispielsweise die aktuell genutzte 
IP-Adresse in Kombination mit Zeitpunkt und einer Browseridentifikation) erfolgt 
nicht.  
Im System eintreffende IP-Adressen werden noch vor jeglicher Weiterverarbeitung
anonymisiert.<br>
Zu statistischen Zwecken werden Zugriffe auf Seiten des Webangebotes 
verarbeitet. Dies erfolgt jedoch nur ohne personenbeziehbare Verbindungsdaten.
</p>
<p>
Die Nutzung von Kommentaren erfolgt auf freiwilliger Basis. Hier
werden zur Wiedererkennung der verschiedenen Kommentatoren Name und E-Mailadresse
abgefragt. Diese Daten werden nicht verifiziert. Es ist jedem Benutzer m�glich, 
hier unzutreffende Daten einzugeben.
</p>
<p>Wir weisen darauf hin, dass die Daten&uuml;bertragung 
im Internet allgemein (z.B. bei der Kommunikation per E-Mail) Sicherheitsl&uuml;cken aufweisen 
kann. Ein l&uuml;ckenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht 
m&ouml;glich. 
</p>

<p>Von ihrem Computer werden verschiedene Daten an aufgerufene Webangebote &uuml;bermittelt. 
    Diese sind je nach Browser- und Betriebssytemtyp, -version und -einstellung unterschiedlich. 
    Einige davon k&ouml;nnen sein:</p>
                <ul>
<li>Browsertyp/ -version</li>
<li>verwendetes Betriebssystem</li>
<li>Referrer URL (die zuvor besuchte Seite)</li>
    <li>Hostname des zugreifenden Rechners (IP-Adresse)</li>
<li>Uhrzeit der Serveranfrage.</li>
                </ul>

<p>
   Auf den Server dieses Webangebotes werden von diesen Datens�tzen jene die eine
   Identifizierung erm�glichen, anonymisiert: Die IP-Adresse wird mit einer anderen
   Adresse �berschrieben; Daten zum Browsertyp und Version werden gel�scht.
</p>



<h3>Einbindung von Diensten und Inhalten Dritter</h3>
<p>
Es kann vorkommen, dass innerhalb dieses Webangebots Inhalte Dritter,
wie zum Beispiel Videos von YouTube, Kartenmaterial von Google-Maps,
RSS-Feeds oder Grafiken von anderen Webseiten eingebunden werden.
<br>
Wir bem�hen uns nur solche Inhalte zu verwenden, die direkt auf diesem
Webauftritt liegen und somit keinem anderen Dienst ein Tracking
erm�glichen.<br>
Leider ist dies, insbesondere bei Videostreams und anderen Angeboten,
die nur auf externen Plattformen bereit gestellt werden, oft
nicht m�glich. In diesen F&auml;llen haben wir keinen Einfluss darauf, falls
die Dritt-Anbieter die IP-Adresse oder Eigenschaften des verwendeten
Browsers speichern und auswerten.
<br>
Bei der Einbindung von Inhalten, bei denen die M�glichkeit besteht,
Tracking zu umgehen, wird dieses genutzt. Beispielsweise bei der Nutzung
von youtube-nocookie.com anstelle von youtube.com f�r die
Einbindung von Videos.
</p>
               

                <h2>Cookies</h2>
<p>Das Webangebot kann an einigen Stellen sogenannte Cookies verwenden.
    Cookies sind kleine Textdateien, die auf Ihrem Rechner abgelegt werden 
    und die Ihr Browser speichert. Cookies richten auf Ihrem Rechner keinen 
    Schaden an und enthalten keine Viren. Die meisten der von uns verwendeten 
    Cookies sind sogenannte "Session-Cookies". Das hei&szlig;t, sie werden nach Ende 
    Ihres Besuchs automatisch gel&ouml;scht.<br />
Cookies k&ouml;nnen es auch erm&ouml;glichen, sie nach Verlassen der Website wiederzuerkennen. 
Leider wird diese Funktion von einigen Firmen dazu missbraucht, das
Surfverhalten von Internetnutzern auszuspionieren. Die Piraten lehnen ein
solches Verhalten als datenschutzwidrig ab.<br />
Im Einzelnen: Das Forum, die Website und das Wiki verwenden Cookies dazu, 
um sie nach dem Einloggen als der Benutzer zu identifizieren, als der sie sich
eingeloggt haben. Im Forum verwenden wir Cookies auch ohne Einloggen dazu ihnen
eine Session bereitstellen zu k&ouml;nnen, so dass sie sehen k&ouml;nnen, ob im Forum 
neue Beitr&auml;ge geschrieben wurden.<br />
In ihren Browsereinstellungen k&ouml;nnen sie die Annahme von Cookies unterbinden.</p>

                <h2>Newsletter</h2>
<p>Wenn Sie die von uns angebotenen Mailinglisten empfangen m&ouml;chten, ben&ouml;tigen 
    wir von Ihnen eine g&uuml;ltige E-Mail-Adresse. Weitere Daten werden nicht 
    erhoben. Wir geben ihre E-Mailaddresse niemals an Dritte weiter, Einsicht
    hat nur der Listenmoderator. Ihre Einwilligung zur Speicherung der 
    E-Mail-Adresse sowie deren Nutzung zum Versand der Mailingliste/n k&ouml;nnen 
    Sie jederzeit widerrufen. Wenn sie sich aus dem Verteiler austragen, wird 
    ihre E-Mail-Adresse gel&ouml;scht.</p>

<h2>Auskunftsrecht</h2>
<p>Sie haben jederzeit das Recht auf Auskunft &uuml;ber die bez&uuml;glich Ihrer Person 
    gespeicherten Daten, deren Herkunft und Empf&auml;nger sowie den Zweck der 
    Speicherung. Auskunft &uuml;ber die gespeicherten Daten gibt Ihnen die 
    Piratenpartei Deutschland. Wenden Sie sich dazu bitte an
    <?php if ( (isset($options['dsbemail'])) && (strlen(trim($options['dsbemail']))>1)) {
        echo '<a href="mailto:'.$options['dsbemail'].'">';
        if ((isset($options['dsbperson'])) && (strlen(trim($options['dsbperson']))>1)) {
                            echo 'den/die Datenschutzbeauftrage/n ';
            echo $options['dsbperson'];
                        }
                        echo '</a>.';
                    } else {
        echo 'Unbekannt :( (E-Mail-Adresse wurde noch nicht gesetzt!).';
                    }
                    ?>
    
                </p>

<h2>Weitere Informationen</h2>
                <p>Ihr Vertrauen ist uns wichtig. Daher werden wir Ihnen jederzeit Rede und 
                    Antwort bez&uuml;glich der Verarbeitung Ihrer personenbezogenen Daten stehen. 
                    Wenn Sie Fragen haben, die Ihnen diese Datenschutzerkl&auml;rung nicht 
                    beantworten konnte oder wenn Sie zu einem Punkt vertiefte Informationen 
                    w&uuml;nschen, wenden Sie sich bitte jederzeit an die Piraten. Sie k&ouml;nnen ihre
                    Fragen und Anregungen im Forum oder an 
    <?php if ((isset($options['dsbemail']))  && (strlen(trim($options['dsbemail']))>1)) {
        echo '<a href="mailto:'.$options['dsbemail'].'">';
        if ((isset($options['dsbperson']))  && (strlen(trim($options['dsbperson']))>1)) {
                            echo 'den/die Datenschutzbeauftrage/n ';
            echo $options['dsbperson'];

                        }
       echo '</a>';      
                    } else {
        echo 'Unbekannt :( (E-Mail-Adresse wurde noch nicht gesetzt!).';
                    }
                    ?> 
                    stellen.</p>


            </div>
        </div>

    <div class="content-aside">
      <div class="skin">

        <h1 class="skip"><?php _e( 'Weitere Informationen', 'piratenkleider' ); ?></h1>   
            <?php
			
            get_piratenkleider_seitenmenu($options['zeige_sidebarpagemenu'],$options['zeige_subpagesonly'],$options['seitenmenu_mode']);
            get_sidebar(); ?>
      </div>
    </div>
  </div>
  <?php get_piratenkleider_socialmediaicons(2); ?>
</div>

<?php get_footer(); ?>
