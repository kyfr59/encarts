<?php

function cptui_register_my_cpts_encart() {

  /**
   * Post Type: encarts.
   */

  $labels = [
    "name" => __( "Encarts", "kerge" ),
    "singular_name" => __( "encart", "kerge" ),
    "menu_name" => __( "Encarts", "kerge" ),
    "all_items" => __( "Tous les encarts", "kerge" ),
    "add_new" => __( "Ajouter un encart", "kerge" ),
    "add_new_item" => __( "Ajouter un encart", "kerge" ),
    "edit_item" => __( "Modifier l'encart", "kerge" ),
    "new_item" => __( "Nouvel encart", "kerge" ),
    "view_item" => __( "Voir l'encart", "kerge" ),
    "view_items" => __( "Voir les encarts", "kerge" ),
    "search_items" => __( "Rechercher un encart", "kerge" ),
    "not_found" => __( "Encart non trouvé", "kerge" ),
    "not_found_in_trash" => __( "Aucun encarts trouvé dans la corbeille", "kerge" ),
    "parent" => __( "Encart parent", "kerge" ),
    "featured_image" => __( "Image mise en avant pour cet encart", "kerge" ),
    "set_featured_image" => __( "Définir l’image mise en avant pour cet encart", "kerge" ),
    "remove_featured_image" => __( "Retirer l’image mise en avant pour cet encart", "kerge" ),
    "use_featured_image" => __( "Utiliser comme image mise en avant pour cet encart", "kerge" ),
    "archives" => __( "Archives des encarts", "kerge" ),
    "insert_into_item" => __( "Insérer dans l'encart", "kerge" ),
    "uploaded_to_this_item" => __( "Téléverser sur cet encart", "kerge" ),
    "filter_items_list" => __( "Filtrer la liste des encarts", "kerge" ),
    "items_list_navigation" => __( "Navigation de liste d'encarts", "kerge" ),
    "items_list" => __( "Liste des encarts", "kerge" ),
    "attributes" => __( "Attributs de l'encart", "kerge" ),
    "name_admin_bar" => __( "Encart", "kerge" ),
    "item_published" => __( "Encart publié", "kerge" ),
    "item_published_privately" => __( "Encart publié en privé.", "kerge" ),
    "item_reverted_to_draft" => __( "Encart repassés en brouillon.", "kerge" ),
    "item_scheduled" => __( "Encart planifié", "kerge" ),
    "item_updated" => __( "Encart mis à jour.", "kerge" ),
    "parent_item_colon" => __( "Encart parent", "kerge" ),
  ];

  $args = [
    "label" => __( "encarts", "kerge" ),
    "labels" => $labels,
    "description" => "Extrait de code HTML insérable dans les publications",
    "public" => false,
    "publicly_queryable" => false,
    "show_ui" => true,
    "show_in_rest" => false,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => false,
    "delete_with_user" => false,
    "exclude_from_search" => true,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => false,
    "query_var" => false,

  ];

  register_post_type( "encart", $args );
}

add_action( 'init', 'cptui_register_my_cpts_encart' );
