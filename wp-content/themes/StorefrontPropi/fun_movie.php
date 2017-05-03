<?php

  add_action( 'init', 'create_post_type', 0 );
  
  function create_post_type() {
    
    $labels = array(
      'name' => _x( 'Pel·licules','Post Type General name' ),
      'singular_name' => _x( 'Pel.licules','Post Type Singular name' )
    );
      
    $args = array(
      'label'                 => __( 'Movie', 'text_domain' ),
      'description'           => __( 'Post Type Description', 'text_domain' ),
      'labels'                => $labels,
      'supports'              => array( ),
      'taxonomies'            => array( 'genere'),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'post',
       'show_in_rest' => true
      );
    
    register_post_type( 'movie',$args);
  } 
  
  function custom_taxonomy() {
    $labels = array(
      'name'              => _x( 'Generes', 'taxonomy general name', 'textdomain' ),
      'singular_name'     => _x( 'Generes', 'taxonomy singular name', 'textdomain' ),
      'search_items'      => __( 'Buscar Generes', 'textdomain' ),
      'all_items'         => __( 'Tots els Generes', 'textdomain' ),
      'parent_item'       => __( 'Parent Generes', 'textdomain' ),
      'parent_item_colon' => __( 'Parent Generes:', 'textdomain' ),
      'edit_item'         => __( 'Editar Generes', 'textdomain' ),
      'update_item'       => __( 'Update Generes', 'textdomain' ),
      'add_new_item'      => __( 'Afegir Generes', 'textdomain' ),
      'new_item_name'     => __( 'Nou Nom Generes ', 'textdomain' ),
      'menu_name'         => __( 'Generes', 'textdomain' ),
    );

    $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'show_in_rest'       => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'genere' ),
    );

	register_taxonomy( 'genere', array( 'movie' ), $args );
  }
  

  add_action( 'init', 'custom_taxonomy', 0 );
  
  add_action( 'cmb2_admin_init', 'exemple_register_demo_metabox' );

  function exemple_register_demo_metabox() {
   // Start with an underscore to hide fields from custom fields list
    $prefix = 'mov_';

    $cmb_demo = new_cmb2_box( array(
      'id' => $prefix . 'metabox',
      'title' => esc_html__( 'Informació pel.licula', 'cmb2' ),
      'object_types' => array( 'movie', ), // Post type
      'show_in_rest' => WP_REST_Server::READABLE,
    ) );
  
    $cmb_demo->add_field( array(
    'name' => __( 'Director', 'cmb2' ),
    'desc' => __( 'Director', 'cmb2' ),
    'id' => $prefix . 'director',
    'type' => 'text',
    ) );       
    $cmb_demo->add_field( array(
    'name' => __( 'Duració', 'cmb2' ),
    'desc' => __( 'Duració de la pel.licula ', 'cmb2' ),
    'id' => $prefix . 'duracio',
    'type' => 'text_time',
    'time_format' => 'H:i:s',
    ) );  
    $cmb_demo->add_field( array(
      'name' => __( 'Any', 'cmb2' ),
      'desc' => __( 'Any', 'cmb2' ),
      'id' => $prefix . 'anny',
      'type' => 'text_small',
      //'date_format' => 'Y',
    ) );    
    $cmb_demo->add_field( array(
      'name' => __( 'genere', 'cmb2' ),
      'desc' => __( 'Genere', 'cmb2' ),
      'id' => $prefix . 'genere',
      'taxonomy'       => 'genere', //Enter Taxonomy Slug
      'type'           => 'taxonomy_select',
      'remove_default' => 'true',
    ) ); 
    $cmb_demo->add_field( array(
      'name' => __('Imatge','cmb2'),
      'desc' => __('Imatge exemple de la pel·licula','cmb2'),
      'id'   => $prefix.'imatge',
      'type' => 'file',
    ));
    $cmb_demo->add_field( array(
    'name' => __( 'Trailer', 'cmb2' ),
    'desc' => __( 'Trailer', 'cmb2' ),
    'id' => $prefix . 'trailer',
    'type' => 'text_small',
    ) );     
  }
  
  add_action('rest_api_init','registrar_camps');
  
  function registrar_camps(){
    register_rest_field('movie','director',
      array(
        'get_callback'    => 'get_director',
        'update_callback' => null,
        'schema'          => null,
      )
    );
    
    register_rest_field('movie','nom_genere',
      array(
        'get_callback'    => 'get_nom_genere',
        'update_callback' => null,
        'schema'          => null,
      )
    );
    
    register_rest_field('movie','duracio',
      array(
        'get_callback'    => 'get_duracio',
        'update_callback' => null,
        'schema'          => null,
      )
    );
    
    register_rest_field('movie','anny',
      array(
        'get_callback'    => 'get_anny',
        'update_callback' => null,
        'schema'          => null,
      )
    );
    
    register_rest_field('movie','imatge',
      array(
        'get_callback'    => 'get_imatge',
        'update_callback' => null,
        'schema'          => null,
      )
    );
    
    register_rest_field('movie','trailer',
      array(
        'get_callback'    => 'get_trailer',
        'update_callback' => null,
        'schema'          => null,
      )
    );
  }
  
  function get_director($object,  $field_name, $request){
    return get_post_meta($object['id'],"mov_director", true);
  }
  
  function get_duracio($object, $field_name, $request){
    return get_post_meta($object['id'],"mov_duracio",true);
  }
  
  function get_imatge($object, $field_name, $request){
    return get_post_meta($object['id'],"mov_imatge", true);
  }
  
  function get_anny($object, $field_name, $request){
    return get_post_meta($object['id'],"mov_anny",true);
  }
  
  function get_trailer($object, $field_name, $request){
    return get_post_meta($object['id'],"mov_trailer",true);
  }
  
  function get_nom_genere($object, $field_name, $request){
    $terms = get_the_terms($object['id'],"genere");
    if(count($terms)>0) return $terms[0]->name;
  }