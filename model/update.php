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
    }
    ?>

    <form method="post">
        <div class="" style="width: 30%; margin:10rem 0 0 30rem;">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
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

                        if ($row['strname'] == 'Quận 10') {
                            echo '<option value="1" selected>Quận 10</option>';
                            echo '<option value="2">Bình Thạnh</option>';
                            echo '<option value="3">Thủ Đức</option>';
                            echo '<option value="4">Gò Vấp</option>';
                        } else if ($row['strname'] == 'Bình Thạnh') {
                            echo '<option value="1">Quận 10</option>';
                            echo '<option value="2" selected>Bình Thạnh</option>';
                            echo '<option value="3">Thủ Đức</option>';
                            echo '<option value="4">Gò Vấp</option>';
                        } else if ($row['strname'] == 'Thủ Đức') {
                            echo '<option value="1">Quận 10</option>';
                            echo '<option value="2">Bình Thạnh</option>';
                            echo '<option value="3" selected>Thủ Đức</option>';
                            echo '<option value="4">Gò Vấp</option>';
                        } else {
                            echo '<option value="1">Quận 10</option>';
                            echo '<option value="2">Bình Thạnh</option>';
                            echo '<option value="3">Thủ Đức</option>';
                            echo '<option value="4" selected>Gò Vấp</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Phòng ban</span>
                    <select name="group" class="form-select" aria-label="Default select example">
                        <?php
                        if ($row['description'] == 'Nhân sự') {
                            echo '<option value="1" selected>Nhân Sự</option>';
                            echo '<option value="2">Kế Toán</option>';
                            echo '<option value="3">Quản Lý</option>';
                            echo '<option value="4">Lễ Tân</option>';
                        } else if ($row['description'] == 'Kế toán') {
                            echo '<option value="1" >Nhân Sự</option>';
                            echo '<option value="2" selected>Kế Toán</option>';
                            echo '<option value="3">Quản Lý</option>';
                            echo '<option value="4">Lễ Tân</option>';
                        } else if ($row['description'] == 'Quản lý') {
                            echo '<option value="1" >Nhân Sự</option>';
                            echo '<option value="2">Kế Toán</option>';
                            echo '<option value="3" selected>Quản Lý</option>';
                            echo '<option value="4">Lễ Tân</option>';
                        } else {
                            echo '<option value="1" >Nhân Sự</option>';
                            echo '<option value="2">Kế Toán</option>';
                            echo '<option value="3">Quản Lý</option>';
                            echo '<option value="4"selected>Lễ Tân</option>';
                        }

                        ?>

                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
            </div>
        </div>

    </form>


</body>

</html>