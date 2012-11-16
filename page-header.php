<?php get_header();
global $defaultoptions;
$options = get_option( 'piratenkleider_theme_options' );
if (!isset($options['aktiv-defaultseitenbild'])) 
            $options['aktiv-defaultseitenbild'] = $defaultoptions['aktiv-defaultseitenbild'];

?>

<div class="section content" id="main-content">
  <div class="row">
    <div class="content-primary">