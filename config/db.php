<?php
define("DB_HOST",'localhost');
define("username","attendance_admin");
define("password","attendance");
define("DB_NAME","php_attendance_list_crud");

$conn = mysqli_connect(DB_HOST, username, password, DB_NAME);

if (!$conn) {
    die("Database connection error " . mysqli_connect_error());
} 

?>
