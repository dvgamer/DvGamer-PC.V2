<?php 
if(ereg("(/?@)",$_SERVER['REQUEST_URI'])): ///?@m!mod_online.php
  ob_start(); 
  foreach (glob("_require/*.php") as $_file_name) include_once($_file_name);
  $database = new SyncDatabase();
  $session = new Session();
  list($tmp, $AjaxName) = explode('/?@' ,$_SERVER['REQUEST_URI']);
  list($FolderName, $CallName) = explode('!' ,$AjaxName);
  if(file_exists("component/".$FolderName."/".$CallName.".php")) {
	  include_once("component/".$FolderName."/".$CallName.".php");
  } else {
	  echo "Not Found.";
  }
  ob_end_flush();
elseif(isset($_REQUEST['html'])):
	foreach (glob("site/css/*.css") as $_file_name) echo '<link rel="stylesheet" type="text/css" href="'.$_file_name.'" />'."\n\r"; 
	foreach (glob("plugins/*.js") as $_file_name) echo '<script type="text/javascript" src="'.$_file_name.'"></script>'."\n\r"; 
	if(file_exists('module/iframe/'.$_REQUEST['html'].'.html')) include_once('module/iframe/'.$_REQUEST['html'].'.html'); else include_once('plugins/default.php');
elseif(ereg("(/?)|(/)", $_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI']=='/'):
// HTML index page.
ob_start(); 
?>
<!doctype html>
<head>
<?php
error_reporting(-1);
date_default_timezone_set("Asia/Bangkok");

// Configuration \\
foreach(glob("_require/*.php") as $_file_name) include_once($_file_name);
include_once("include/language.php");
$database = new SyncDatabase();
$session = new Session();
$request = new UrlRequest(); ?>
<title><? echo _DVGAMER_TITLE; ?></title>
<meta charset="utf-8">
<meta name="Keywords" content="<?php echo _DVGAMER_KEYWORD; ?>" />
<meta name="Description" content="<?php _DVGAMER_DESCRIPTION; ?>" />
<link rel="shortcut icon" href="<?php echo _DVGAMER_ICON; ?>">
<?php

foreach (glob("skin/css/*.css") as $_file_name) echo '<link rel="stylesheet" type="text/css" href="'.$_file_name.'" />'; 
foreach (glob("skin/font/*.css") as $_file_name) echo '<link rel="stylesheet" type="text/css" href="'.$_file_name.'" />'; 
foreach (glob("_require/jquery/*.js") as $_file_name) echo '<script type="text/javascript" src="'.$_file_name.'"></script>'; 
/*foreach (glob("skin/js/*.js") as $_file_name) echo '<script type="text/javascript" src="'.$_file_name.'"></script>';*/

?>

</head>
<!--<script src="http://connect.facebook.net/th_TH/all.js#xfbml=1"></script>-->
<body>
<?php 
if(file_exists('skin/main.php')) {
	include_once('skin/main.php');
} else {
	echo '"<strong>main.php</strong>" Miss.';	
}
?>
</body>
</html>
<?php 
ob_end_flush(); 
endif;
?>
