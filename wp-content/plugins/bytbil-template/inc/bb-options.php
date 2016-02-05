<?php


// Add Options Page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'BytBil Hemsida : Inställningar',
		'menu_title'	=> 'BytBil Hemsida',
		'menu_slug' 	=> 'bb-site-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	/*acf_add_options_sub_page(array(
		'page_title' 	=> 'BytBil Hemsida : Inloggningssida',
		'menu_title'	=> 'Inloggningssida',
		'parent_slug'	=> 'bb-site-settings',
	));*/
    
	/*
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
    */
    
}

?>