<?php
$path = __DIR__;
include $path . '/connect.php';
include $path . '/upload.php';

?>
<?php
if (isset($_GET['deleteimgid'])) {
    $id = $_GET['uploadid'];
    $id111 = $id;
    $idDelete = $_GET['deleteimgid'];
    $sqlDeleteImg = "delete from user_profiles where id = $idDelete";
    if (mysqli_query($conn, $sqlDeleteImg)) {
        echo "<script>alert('DELETE successfully')</script>";
        echo '<script>window.location.href = "upload.php?uploadid=' . $id111 . '";</script>';
    }
}
echo '
            <script>
            if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
            </script>';
