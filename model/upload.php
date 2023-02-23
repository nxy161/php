<?php
$path = __DIR__;
include $path . '/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/fontawesome-free-6.3.0-web/fontawesome-free-6.3.0-web/css/all.min.css">

    <title>Document</title>
</head>


<body>
    <?php
    $id = $_GET['uploadid'];
    $query2 = mysqli_query($conn, "SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
    LEFT JOIN groups as gr 
    ON us.main_group_id = gr.id
    LEFT JOIN stores as st
    ON us.main_store_id  = st.id
    where us.id = '$id' ");
    $row = mysqli_fetch_assoc($query2);

    if (isset($_POST['uploadImg']) && isset($_FILES['image'])) {
        // print_r($_FILES['image']);
        if ($_FILES['image']['error'] === 4) {
            echo "<script>alert('Image Does not exist');</script>";
        } else {
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $tmpName = $_FILES['image']['tmp_name'];
            $validImage = ['jpg', 'jpge', 'png'];
            $imageEx = explode('.', $fileName);
            $imageEx = strtolower(end($imageEx));
            if (!in_array($imageEx, $validImage)) {

                echo "<script>alert('Invalid Image');</script>";
            } elseif ($fileSize > 100000000) {
                echo "<script>alert('Image too large');</script>";
            } else {
                $newImg = uniqid();
                $newImg .= '.' . $imageEx;
                move_uploaded_file($tmpName, '../image/' . $newImg);
                $queryUpload = "Insert into user_profiles (user_id, image) VALUES ('$id', '$newImg' )";
                mysqli_query($conn, $queryUpload);
                echo "<script>alert('Image upload success!');

                </script>";
            }
        }
    };
    if (isset($_POST['cancle'])) {
        echo '<script>window.location.href = "../index.php";</script>';
    }
    ?>
    <div class="d-flex justify-content-center">

        <form method="post" enctype="multipart/form-data">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa nhân viên</h1>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Tên nhân viên</span>
                    <input disabled value="<?php echo $row['name'] ?>" name="nameuser" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Địa chỉ</span>
                    <input disabled value="<?php echo $row['address'] ?>" name="address" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Ngày sinh</span>
                    <input disabled value="<?php echo $row['birthday'] ?>" name="birthday" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Chi nhánh</span>
                    <select disabled name="store" class="form-select" aria-label="Default select example">
                        <?php

                        $arrayDataStore = array("");
                        $querySelectNameStore = mysqli_query($conn, 'Select name from stores');
                        while ($rowNameStore = mysqli_fetch_array($querySelectNameStore)) {
                            array_push($arrayDataStore, $rowNameStore['name']);
                        }

                        for ($i = 1; $i < count($arrayDataStore); $i++) {
                            if ($row['strname'] == $arrayDataStore[$i]) {
                                echo '<option value="' . $i . '" selected>' . $arrayDataStore[$i] . '</option>';
                            } else {
                                echo '<option value="' . $i . '" >' . $arrayDataStore[$i] . '</option>';
                            }
                        };
                        ?>
                    </select>
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Phòng ban</span>
                    <select disabled name="group" class="form-select" aria-label="Default select example">
                        <?php


                        $arrayDataGroup = array("");
                        $querySelectNameGroup = mysqli_query($conn, 'Select description from groups');
                        while ($rowNameGroup = mysqli_fetch_array($querySelectNameGroup)) {
                            array_push($arrayDataGroup, $rowNameGroup['description']);
                        }

                        for ($i = 1; $i < count($arrayDataGroup); $i++) {
                            if ($row['description'] == $arrayDataGroup[$i]) {
                                echo '<option value="' . $i . '" selected>' . $arrayDataGroup[$i] . '</option>';
                            } else {
                                echo '<option value="' . $i . '" >' . $arrayDataGroup[$i] . '</option>';
                            }
                        };

                        ?>

                    </select>
                </div>
                <div class="input-group input-group-sm mb-3">
                    <input name="image" type="file" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="cancle" class="btn btn-secondary mx-3" data-bs-dismiss="modal">Huỷ</button>
                <button type="submit" class="btn btn-primary" name="uploadImg">Tải Ảnh Lên</button>
            </div>

        </form>

    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
            </tr>
        </thead>
        <tbody style="display: flex;">
            <?php
            $rows = mysqli_query($conn, "SELECT * FROM user_profiles  where user_id = '$id'")
            ?>
            <?php foreach ($rows as $row) : ?>
                <?php
                echo     '<tr style="border: 1px solid #000;">';
                echo     '<td> <img src="../image/' . $row["image"] . '" style="width: 150px; height: 150px;" title="' . $row['image'] . '"> </td>';
                echo   ' <td><button class="btn btn-group"><a href="upload.php?uploadid=' . $id . '&deleteid=' . $row['id'] . '"><i class="fa-solid fa-trash" style="color:red;"></i></a></button></td>';
                echo '
                <script>
                if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
                }
                </script>';
                ?>
            <?php endforeach; ?>
            <?php
            if (isset($_GET['deleteid'])) {
                $idreload = $_GET['uploadid'];
                $idDelete = $_GET['deleteid'];
                $sqlDeleteImg = "delete from user_profiles where id = $idDelete";
                if (mysqli_query($conn, $sqlDeleteImg)) {
                    echo "<script>alert('DELETE successfully')</script>";
                    echo '<script>window.location.href = "upload.php?uploadid=' . $idreload . '"</script>';
                }
            }
            echo '
            <script>
            if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
            </>';
            ?>
        </tbody>

    </table>
</body>

</html>