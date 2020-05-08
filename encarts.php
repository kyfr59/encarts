<?php
/*
    Plugin Name: Encarts
    Description: Permet l'insertion de morceaux de code HTML dans les publications
    Author: Franck Dupont
    Author URI: http://franck-dupont.me
    Version: 1.0.0
*/

// Encsure that CPT plugin is active
register_activation_hook( __FILE__, 'encarts_cpt_plugin_active' );
function encarts_cpt_plugin_active(){

    // Require parent plugin
    if ( ! is_plugin_active( 'custom-post-type-ui/custom-post-type-ui.php' ) and current_user_can( 'activate_plugins' ) ) {
        wp_die('Le plugin <strong>Encarts</strong> nécessaite le plugin <a href="https://fr.wordpress.org/plugins/custom-post-type-ui/" target="_blank">Custom Post Type UI</a> pour fonctionner. Veuillez installer ce dernier avant de réessayer.<br><a href="' . admin_url( 'plugins.php' ) . '"><br>&laquo; Retour à la liste des plugins</a>');
    }
}

// Define plugin constants
if ( !defined( 'ENCARTS_PLUGIN_DIR' ) ) {define( 'ENCARTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );}
if ( !defined( 'ENCARTS_ACF_PREFIX' ) ) {define( 'ENCARTS_ACF_PREFIX', 'encarts_' );}

// Create the CPT
require_once(ENCARTS_PLUGIN_DIR . "encarts-create-cpt.php");

// Include CSS
wp_enqueue_style('encarts', plugins_url( '/css/style.css', __FILE__ ) );
wp_enqueue_style('balloon', 'https://cdnjs.cloudflare.com/ajax/libs/balloon-css/1.0.4/balloon.min.css' );


// Include JS
wp_enqueue_script('encarts', plugins_url( '/js/scripts.js', __FILE__ ) );


// Handle the encarts_ shortcode
add_shortcode('encart', 'shortcode_encart');
function shortcode_encart($args) {

    if (!$id = $args['id']) return;

    if (!$post = get_post($id)) return;

    $current_post = get_post();
    if ($current_post->post_type == 'encart') return; // Disable shortcode on "encart" post types

    return $post->post_content;
}


// Add the shortcode metabox
add_action( 'admin_init', 'encarts_create_shortcode_metabox' );
function encarts_create_shortcode_metabox() {
    add_meta_box( 'encarts_shortcode_metabox', 'Insérer cet encart dans vos articles', 'encarts_display_shortcode_metabox', ['encart'], 'side', 'low');
}


// Display "encarts" metabox
function encarts_display_shortcode_metabox() {
  $url = plugins_url( '/js/clipboard.min.js', __FILE__ );
  $shortcode = '[encart id='.get_the_ID().']';
  echo "<script type='text/javascript' src='$url'></script>";
  echo '<p>Pour insérer cet encart dans vos pages utilisez le shortcode suivant :</p>';
  echo '<div aria-label="Copier dans le presse papier" data-balloon-pos="down" id="copy-shortcode" data-clipboard-text="'.$shortcode.'">'.$shortcode.'</div>';
}


// Install the "wp_encart" table
register_activation_hook(__FILE__,'encarts_plugin_table_install');
function encarts_plugin_table_install() {

  global $wpdb;

  $table_name = $wpdb->prefix . "encarts";

  if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table_name}'" ) != $table_name ) {

  $sql = "CREATE TABLE $table_name (
    `id` int(8) NOT NULL AUTO_INCREMENT,
    `post_id` int(8) NOT NULL,
    `encart_id` int(8) NOT NULL,
    `position` varchar(50) NOT NULL,
    PRIMARY KEY  id (id),
    UNIQUE KEY id (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
  }
}


// Create the "encarts" metabox
add_action( 'admin_init', 'encarts_create_encarts_metabox' );
function encarts_create_encarts_metabox() {

  // Don't display the metabox on "encart" cpt
  $all_posts_types = get_post_types();
  unset($all_posts_types['encart']);
  $posts_types = array_keys($all_posts_types);

  add_meta_box( 'encarts_metabox', 'Gestion des encarts', 'encarts_display_encarts_metabox', $posts_types, 'advanced', 'low');
}


// Display the "encarts" metabox
function encarts_display_encarts_metabox() {

  global $post;
  $args = array('post_type' => 'encart');
  $query = new WP_Query($args);
  $encarts = $query->posts;

  global $wpdb;
  $sql = "SELECT * FROM `wp_encarts` WHERE `post_id` = '".$post->ID."'";
  $results = $wpdb->get_results($wpdb->prepare($sql), ARRAY_A);

  $positionning = [];
  foreach($results as $result) {
    $positionning[$result['encart_id']] = $result['position'];
  }

  if (!count($encarts)) {
    echo "<p>Aucun encart à positionner, veuillez <a href='".admin_url('post-new.php?post_type=encart')."'>créer un encart</a> au préalable</p>";
  } else {
    echo '<table>';
    foreach($encarts as $encart) {
      $selected = [];
      $selected[$positionning[$encart->ID]] = 'selected';
      echo '<tr>';
      echo '  <td style="padding-right:50px">'.$encart->post_title.'</td>';
      echo '  <td>';
      echo '  <select name="encarts['.$encart->ID.']">';
      echo '    <option value="">-- Choisissez le positionnement --</option>';
      echo '    <option '.$selected['haut'].' value="haut">En début de page (sous le titre)</option>';
      echo '    <option '.$selected['bas'].' value="bas">En fin de page</option>';
      echo '  </select>';
      echo '  </td>';
      echo '</tr>';
    }
    echo '</table>';
    echo '<p><i><b style="color:orangered">Pensez à enregistrer vos modifications avec le bouton "Mettre à jour" de Wordpress</b></i></p>';
  }
}


// Handle the storage of positionning in database
add_action( 'save_post', 'encarts_save_encarts_positionning');
function encarts_save_encarts_positionning() {

  global $post;
  global $wpdb;

  if (!is_array($_POST['encarts'])) return;

  $encarts = $_POST['encarts'];

  // Delete current positionning
  $sql = "DELETE FROM `wp_encarts` WHERE `post_id` = '".$post->ID."'";
  $wpdb->query( $wpdb->prepare($sql));

  foreach($encarts as $encart_id => $position) {
    if (!empty($position)) {
      $sql = "INSERT INTO `wp_encarts` (`id`, `post_id`, `encart_id`, `position`) VALUES (NULL, '".$post->ID."', '".$encart_id."', '".$position."');";
      $wpdb->query( $wpdb->prepare($sql));
    }
  }
}


// Handle the deletation of an encart
add_action( 'delete_post', 'encarts_delete_post');
function encarts_delete_post() {

  global $post;

  if ($post->post_type == 'encart') {

    // Delete current encart from database
    $sql = "DELETE FROM `wp_encarts` WHERE `encart_id` = '".$post->ID."'";
    $wpdb->query( $wpdb->prepare($sql));
  }
}


// Add the encart in posts content
add_filter( 'the_content', 'encart_add_encart_in_content' );
function encart_add_encart_in_content( $content ) {

    global $post;
    global $wpdb;

    $sql = "SELECT * FROM `wp_encarts` WHERE `post_id` = '".$post->ID."'";
    $results = $wpdb->get_results($wpdb->prepare($sql), ARRAY_A);

    $haut = $bas = '';
    foreach($results as $result) {

      if (!$encart_id = $result['encart_id']) continue;
      if (!$position = $result['position']) continue;

      $encart = get_post($encart_id);

      if ($position == 'haut') {
        $haut .= $encart->post_content;
      } else {
        $bas .= $encart->post_content;
      }

    }

    return $haut.$content.$bas;
}
