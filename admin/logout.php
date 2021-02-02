<?php 
require_once(__DIR__ . '/../connection.php'); 

session_destroy();
header('Location: ' . get_option('site_url'));
exit;

?>