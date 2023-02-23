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
    <title>Document</title>
</head>

<body>
    <?php
    $id = $_GET['updateid'];
    $query2 = mysqli_query($conn, "SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
    LEFT JOIN groups as gr 
    ON us.main_group_id = gr.id
    LEFT JOIN stores as st
    ON us.main_store_id  = st.id
    where us.id = '$id' ");
    $row = mysqli_fetch_assoc($query2);
    // echo "<scirpt>console.log($row[description])</scirpt>";

    // echo "<scirpt>console.log('$id')</scirpt>";

    if (isset($_POST['submit'])) {
        $name = $_POST['nameuser'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday'];
        $store = $_POST['store'];
        $group = $_POST['group'];
        $sql = "update users set name='$name', address='$address', birthday = '$birthday', main_group_id='$group',main_store_id='$store' where id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Update success!')</script>";
            echo '<script>window.location.href = "../index.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    };

    if (isset($_POST['cancle'])) {
        echo '<script>window.location.href = "../index.php";</script>';
    }
    ?>
    <div class="d-flex justify-content-center">

        <form method="post">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa nhân viên</h1>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Tên nhân viên</span>
                    <input value="<?php echo $row['name'] ?>" name="nameuser" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Địa chỉ</span>
                    <input value="<?php echo $row['address'] ?>" name="address" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Ngày sinh</span>
                    <input value="<?php echo $row['birthday'] ?>" name="birthday" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Chi nhánh</span>
                    <select name="store" class="form-select" aria-label="Default select example">
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
                    <select name="group" class="form-select" aria-label="Default select example">
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
            </div>
            <div class="modal-footer">
                <button type="submit" name="cancle" class="btn btn-secondary mx-3" data-bs-dismiss="modal">Huỷ</button>
                <button type="submit" class="btn btn-primary" name="submit">Chỉnh Sửa</button>
            </div>

        </form>
    </div>


</body>

</html>