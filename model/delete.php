<?php
$path = __DIR__;
include $path . '/connect.php';

if (isset($_GET['deleteid'])) {
    $id = $_GET['deleteid'];
    $sql = "delete from users where id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('DELETE successfully')</script>";
        echo '<script>window.location.href = "../index.php";</script>';
    }
}
