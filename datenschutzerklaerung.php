<?php
/*
  Template Name: Datenschutzerklaerung
 */
?>
<?php
get_header();
$options = get_option('piratenkleider_theme_options');
$kontaktinfos = get_option('piratenkleider_theme_kontaktinfos');
if (!isset($options['src-default-symbolbild']))
    $options['src-default-symbolbild'] = $defaultoptions['src-default-symbolbild'];
?>

<div class="section content">
    <div class="row">
        <div class="content-primary">
            <div class="content-header">
                <h1 id="page-title"><span>Pol&iacute;tica de Privacidade</span></h1>   
                <?php
                if (has_post_thumbnail()) {
                    echo '<div class="symbolbild">';
                    the_post_thumbnail();
                    echo '</div>';
                } else {
                    if ($options['aktiv-platzhalterbilder-indexseiten']) {
                        ?>         
                        <div class="symbolbild"> 
                            <img src="<?php echo $options['src-default-symbolbild'] ?>" alt="" >
                        </div>                                 
    <?php
    }
}
?>
            </div>
            <div class="skin">

<?php if (have_posts()) while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
        <?php edit_post_link(__('Bearbeiten', 'piratenkleider'), '', ''); ?>
    <?php endwhile; ?>


                <p>O Partido Pirata da Alemanha exige não apenas uma protecção de dados mais rigorosa, mas também pôe esta em prática. As informações pessoais recolhidas neste site só são levantados no meio técnica- e absolutamente necessário. Em nenhum caso os dados serão vendidos ou transferidos a terceiros. Se por alguma exceção for necessário divulgar os seus dados a terceiros, então pedimos permissão separadamente para cada apresentação.</p>
                <p>A declaração a seguir dá uma visão geral de como podemos garantir esta protecção e que tipo de dados são recolhidos e para que finalidade.</p>


                <h2>Processamento de dados neste site</h2>
                <p>Diversos são transmitidos para nós do seu computador, e estes diferem, dependendo do seu navegador e tipo, versão e configuração do sistema operativo. Alguns deles podem ser:</p>
                <ul>
                    <li>Tipo de navegador / versão</li>
                    <li>Sistema operativo</li>
                    <li>Referente URL (a página visitada anteriormente)</li>
                    <li>Nome do host do computador (endereço IP)</li>
                    <li>Hora do pedido do servidor.</li>
                </ul>
                <p>O Partido Pirata opõe-se estritamente ao armazenamento de dados deste tipo.<br />
                    No entanto, se os nossos sistemas possam ser usados indevidamente para o crime, pode acontecer que sejamos obrigados a armazenar os dados destes e de outros, e entregue às autoridades de investigação. Tanto quanto nos é permitido em tal caso o utilizador é avisado. No caso de um processo preliminar deveríamos usar esses dados para enviar às autoridades ou correctores. Na nossa wiki vocês podem aprender como se pode evitar a transmissão de todos os dados deste parágrafo a nós e outros.<a class="extern" href="http://wiki.piratenpartei.de/HowTo">&Uuml;bermittlung aller in diesem 
                        Absatz genannten Daten an uns und andere unterbinden</a></p>

                <h2>Cookies</h2>
                <p>O nosso site usa cookies em vários lugares. Cookies são pequenos arquivos de texto que são armazenados no seu computador pelo seu navegador. Cookies não causam nenhum dano ao seu computador e não contêm vírus. A maioria dos cookies que usamos são "cookies de sessão". Ou seja, eles são automaticamente apagados após a sua visita.<br />
                   Os cookies também podem habilitá-lo a reconhecê-los depois de sair do site. Infelizmente, esse recurso é abusado por algumas empresas para espionar os hábitos de navegação dos internautas. Os piratas rejeitam esse tipo de comportamento, pois é uma violação da privacidade.<br />
                   Em detalhe: O Fórum, o site e os cookies wiki usam cookies a fim de identificar o utilizador como o usuário que fez login. No fórum também usamos cookies sem ser necessário fazer login para preparar uma sessão para os utilizadores, para que eles possam ver se houve novas mensagens no fórum.<br />
                   Nas configurações do navegador pode impedir a aceitação de cookies.</p>

                <h2>Newsletter</h2>
                <p>Se você deseja receber as listas de discussão que oferecemos, é necessário um email válido. Outros dados não são recolhidos. Não oferecemos o seu endereço de e-mail a terceiros, só tendo acesso apenas o moderador da lista. A sua permissão para armazenar o endereço de e-mail e a sua utilização para enviar a lista(s) de discussão pode ser revogada a qualquer momento. Se você se retirar da lista de discussão, o seu endereço de e-mail é excluído.</p>

                <h2>Direito à informação</h2>
                <p>Você tem sempre o direito de receber informações sobre seus dados pessoais, a sua origem e destino e fins de armazenagem. O Partido Pirata da Alemanha fornece-lhe informações sobre os dados armazenados. Para fazer isso, por favor contacte
                    <?php
                    if (isset($kontaktinfos['dsbemail'])) {
                        echo '<a href="mailto:' . $kontaktinfos['dsbemail'] . '">';
                        if (isset($kontaktinfos['dsbperson'])) {
                            echo 'den/die Datenschutzbeauftrage/n ';
                            echo $kontaktinfos['dsbperson'];
                        } else {
                            echo 'bundesbeauftragter@piraten-dsb.de';
                        }
                        echo '</a>.';
                    } else {
                        echo '<a href="mailto:bundesbeauftragter@piraten-dsb.de">bundesbeauftragter@piraten-dsb.de</a>.';
                    }
                    ?>
                    , a comissão de protecção de dados.
                </p>

                <h2>Informações adicionais</h2>
                <p>Ihr Vertrauen ist uns wichtig. Daher werden wir Ihnen jederzeit Rede und 
                    Antwort bez&uuml;glich der Verarbeitung Ihrer personenbezogenen Daten stehen. 
                    Wenn Sie Fragen haben, die Ihnen diese Datenschutzerkl&auml;rung nicht 
                    beantworten konnte oder wenn Sie zu einem Punkt vertiefte Informationen 
                    w&uuml;nschen, wenden Sie sich bitte jederzeit an die Piraten. Sie k&ouml;nnen ihre
                    Fragen und Anregungen im Forum oder an 
                    <?php
                    if (isset($kontaktinfos['dsbemail'])) {
                        echo '<a href="mailto:' . $kontaktinfos['dsbemail'] . '">';
                        if (isset($kontaktinfos['dsbperson'])) {
                            echo 'den/die Datenschutzbeauftrage/n ';
                            echo $kontaktinfos['dsbperson'];
                        } else {
                            echo 'bundesbeauftragter@piraten-dsb.de';
                        }
                        echo '</a>.';
                    } else {
                        echo '<a href="mailto:bundesbeauftragter@piraten-dsb.de">bundesbeauftragter@piraten-dsb.de</a>.';
                    }
                    ?> 
                    stellen.</p>


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

                if ($options['zeige_sidebarpagemenu'] == 1) {
                    if ($options['zeige_subpagesonly'] == 1) {
                        //if the post has a parent

                        if ($post->post_parent) {
                            //collect ancestor pages
                            $relations = get_post_ancestors($post->ID);
                            //get child pages
                            $result = $wpdb->get_results('SELECT ID FROM ' . $wpdb->prefix . 'posts WHERE post_parent = ' . $post->ID . ' AND post_type=\'page\'');
                            if ($result) {
                                foreach ($result as $pageID) {
                                    array_push($relations, $pageID->ID);
                                }
                            }
                            //add current post to pages
                            array_push($relations, $post->ID);
                            //get comma delimited list of children and parents and self
                            $relations_string = implode(",", $relations);
                            //use include to list only the collected pages. 
                            $sidelinks = wp_list_pages("sort_column=menu_order&title_li=&echo=0&include=" . $relations_string);
                        } else {
                            // display only main level and children
                            $sidelinks = wp_list_pages("sort_column=menu_order&title_li=&echo=0&depth=1&child_of=" . $post->ID);
                        }

                        if ($sidelinks) {
                            ?>
                            <ul class="menu">
                            <?php //links in <li> tags
                            echo $sidelinks;
                            ?>
                            </ul>         
                            <?php
                            }
                        } else {

                            if (has_nav_menu('primary')) {
                                wp_nav_menu(array('depth' => 0, 'container_class' => 'menu-header', 'theme_location' => 'primary', 'walker' => new My_Walker_Nav_Menu()));
                            } else {
                                ?>
                            <ul class="menu">
                            <?php wp_page_menu(); ?>
                            </ul> 
            <?php
        }
    }
}


get_sidebar();
?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
