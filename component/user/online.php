<?php
$online = $database->query("SELECT COUNT(*) FROM dvg_online LIMIT 1");
echo "+".$online;
?>