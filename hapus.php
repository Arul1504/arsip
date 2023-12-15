<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM download WHERE id='$id'");
    $data = mysqli_fetch_assoc($result);

    // Hapus file dari sistem file
    unlink($data['lokasi']);

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM download WHERE id='$id'");
}

header("Location: download.php");
exit();
?>
