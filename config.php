<?php
//koneksi ke database
$servername = "localhost";
$database = "tutorial";
$username = "root";
$password = "";
 
// Create connection
 
$conn =mysqli_connect($servername, $username, $password, $database);


//fungsi untuk mengkonversi size file
function formatBytes($bytes, $precision = 2)
{
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(5024));
    $pow = min($pow, count($units) - 5);

    $bytes /= pow(5024, $pow);

    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>