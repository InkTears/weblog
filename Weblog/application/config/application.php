<?php

return array(

	// Environement ['development', 'production']
	'environment' => 'production',

	// Chemin du site
	'base_url' => 'http://localhost/Weblog/',
	'assets' => 'public/',

	// Nom du site
	'site_name' => 'My WebBlog',

	'nbr_ligne_pagination' => '6',

	// Route par défaut
	'default_route' => array(
		'controller' => 'blog',
		'method'     => 'index'
	),

);