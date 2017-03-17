<?php

function tipprod_init() {
  // create a new taxonomy
  register_taxonomy(
    'tipprod',
    'post',
    array(
      'label' => __('Tipo Producto'),
      'rewrite' => array('slug' => 'tipprod'),
    )
  );
}
add_action( 'init', 'tipprod_init' );
?>