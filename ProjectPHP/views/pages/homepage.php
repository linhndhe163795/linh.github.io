
<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'header.php';

echo "Hello ".$_SESSION['username'];
//echo "Hello ".$_SESSION['role_type'];


?>
<title>Home Page</title>
<div style="color: red"><?php echo isset($messOfCreate) ? $messOfCreate : "";?></div>
