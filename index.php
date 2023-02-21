<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <h1 class="m-3">Danh sách nhân viên</h1>
    <div class=" search d-flex">
        <div class="col-3 m-5">
            <h5>Chi nhánh</h5>
            <select class="form-select" aria-label="Default select example">
                <option selected value="all">Tất cả</option>
                <option value="1">Quận 10</option>
                <option value="2">Bình Thạnh</option>
                <option value="3">Thủ Đức</option>
                <option value="3">Gò Vấp</option>
            </select>
        </div>
        <div class="col-3 m-5">
            <h5>Phòng ban</h5>
            <select class="form-select" aria-label="Default select example">
                <option selected value="all">Tất cả</option>
                <option value="1">Nhân Sự</option>
                <option value="2">Kế Toán</option>
                <option value="3">Quản Lý</option>
                <option value="3">Lễ Tân</option>
            </select>
        </div>
        <div class="col-3 m-5" style="margin-top: 5rem!important;">
            <button type="button" class="btn btn-primary">Hiển thị</button>
        </div>
    </div>
    <div class="table m-3">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Ngày sinh</th>
                    <th scope="col">Chi nhánh</th>
                    <th scope="col">Phòng ban</th>
                    <th scope="col">Thơi gian tạo</th>
                    <th scope="col">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include './model/connect.php';
                $query1 = mysqli_query($conn, "SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
                LEFT JOIN groups as gr 
                ON us.main_group_id = gr.id
                LEFT JOIN stores as st
                ON us.main_store_id  = st.id");
                while ($row = mysqli_fetch_array($query1)) {
                    echo '<tr>';
                    echo   '<th scope="row">' . $row['id'] . '</th>';
                    echo   '<td>' . $row['name'] . '</td>';
                    echo   '<td>' . $row['address'] . '</td>';
                    echo   '<td>' . $row['birthday'] . '</td>';
                    if ($row['strname'] == null) {
                        echo   '<td scope="chi nhánh">----</td>';
                    } else {
                        echo   '<td scope="chi nhánh">' . $row['strname'] . '</td>';
                    }
                    if ($row['description'] == null) {
                        echo   '<td>----</td>';
                    } else {
                        echo   '<td>' . $row['description'] . '</td>';
                    }
                    echo   '<td>' . $row['created'] . '</td>';
                    echo  '</tr>';
                };

                ?>

            </tbody>
        </table>
    </div>

</body>

</html>