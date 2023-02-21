<?php
include './model/connect.php';
include './model/delete.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/fontawesome-free-6.3.0-web/fontawesome-free-6.3.0-web/css/all.min.css">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <title>Document</title>
</head>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['nameuser'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $store = $_POST['store'];

    $group = $_POST['group'];

    $sql = "insert into users (name,birthday,address,main_group_id,main_store_id) 
    values('$name','$birthday','$address','$group','$store')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('New record created successfully')</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<body>

    <h1 class="m-3">Danh sách nhân viên</h1>
    <!-- Button trigger modal -->
    <button style="margin-left: 1rem;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Thêm Nhân Viên
    </button>


    <!-- Modal -->
    <form method="post">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Tên nhân viên</span>
                            <input name="nameuser" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Địa chỉ</span>
                            <input name="address" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Ngày sinh</span>
                            <input name="birthday" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Chi nhánh</span>
                            <select name="store" class="form-select" aria-label="Default select example">
                                <option value="1">Quận 10</option>
                                <option value="2">Bình Thạnh</option>
                                <option value="3">Thủ Đức</option>
                                <option value="3">Gò Vấp</option>
                            </select>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Phòng ban</span>
                            <select name="group" class="form-select" aria-label="Default select example">
                                <option value="1">Nhân Sự</option>
                                <option value="2">Kế Toán</option>
                                <option value="3">Quản Lý</option>
                                <option value="4">Lễ Tân</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class=" search d-flex">
        <form method="post">
            <div class="col-3 m-5">
                <h5>Chi nhánh</h5>
                <?php
                $querygroup = mysqli_query($conn,"");
                ?>
                <select class="form-select" aria-label="Default select example">
                    <option selected value="all">Tất cả</option>
                    <option value="1">Quận 10</option>
                    <option value="2">Bình Thạnh</option>
                    <option value="3">Thủ Đức</option>
                    <option value="4">Gò Vấp</option>
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
        </form>

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
                $query1 = mysqli_query($conn, "SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
                LEFT JOIN groups as gr 
                ON us.main_group_id = gr.id
                LEFT JOIN stores as st
                ON us.main_store_id  = st.id");
                while ($row = mysqli_fetch_assoc($query1)) {
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
                    echo '<td><button class="btn btn-group"><a href="model/update.php?updateid=' . $row['id'] . '"><i class="fa-solid fa-pen-to-square" style="color:blue;"></i></a></button><button class="btn btn-group"><a href="model/delete.php?deleteid=' . $row['id'] . '"><i class="fa-solid fa-trash" style="color:red;"></i></a></button></td>';
                    echo  '</tr>';
                };
                //<button class="btn btn-group"><a><i class="fa-solid fa-eye" style="color:blue;"></i></a></button>
                ?>
            </tbody>
        </table>
    </div>


    <script>
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
            myInput.focus()
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>

</html>