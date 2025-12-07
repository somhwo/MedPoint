<?php
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
<<<<<<< HEAD:medpoint/admin/include/config.php
define('DB_NAME', 'MedPoint');
=======
define('DB_NAME', 'medpoint');
>>>>>>> 499a00047a51e6a0efcba8d3685b9e39cfb1e097:hms/admin/include/config.php
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>