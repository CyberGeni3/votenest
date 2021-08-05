<?php 
	//Load config
	require_once 'config/config.php';
	require_once 'helpers/session_helper.php';
	require_once 'helpers/url_helper.php';
	require_once 'helpers/slugify.php';
	require_once 'helpers/Mobile_Detect.php';
	require_once 'helpers/image_resize.php';

	//Autoload Core Libraries
	spl_autoload_register(function($className){
		require_once 'libraries/' . $className . '.php';
	});

?>