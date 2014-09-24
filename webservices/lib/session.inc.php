<?php
$cookie_path = "/";
$cookie_timeout = 60 * 60 * 24; // in seconds
$garbage_timeout = $cookie_timeout + 600; // in seconds
session_set_cookie_params($cookie_timeout, $cookie_path);
//ini_set('session.gc_maxlifetime', $garbage_timeout);
strstr(strtoupper(substr($_SERVER["OS"], 0, 3)), "WIN") ? 
	$sep = "\\" : $sep = "/";
$sessdir = ini_get('session.save_path').$sep.$project_vars['appname'];
if (!is_dir($sessdir)) { mkdir($sessdir, 0777); }
//ini_set('session.save_path', $sessdir);


session_name($project_vars['user_session_name']);
session_start();
$_SESSION['redirect_to'] = "";
$_SESSION['user_rand_key'] = "";
//session_register("redirect_to");
//session_register("user_rand_key");
?>