<?php
session_start();
echo "<pre>"; 
print_r($_SESSION);
echo "</pre>";

echo "<pre>"; 
print_r($_COOKIE);
echo "</pre>";
if(isset($_GET['c']))
    session_destroy();
?>
