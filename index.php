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
    <div style="margin-left: 50px;">

        <h1>Danh sách nhân viên</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Thêm Nhân Viên
        </button>
    </div>


    <!-- Modal -->
    <form method="post">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Nhân Viên</h1>
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
                            <?php
                            $querySelectStore = mysqli_query($conn, "(SELECT name FROM stores)");
                            echo '<select name="store" class="form-select" aria-label="Default select example">';
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($querySelectStore)) {
                                echo '<option value="'.$i.'">' . $row['name'] . '</option>';
                                $i++;
                            }
                            echo '</select>';
                            ?>
                        </div>
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Phòng ban</span>
                            <?php
                            $querySelectGroup = mysqli_query($conn, "(SELECT description FROM groups)");
                            echo '<select name="group" class="form-select" aria-label="Default select example">';
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($querySelectGroup)) {
                                echo '<option value="'.$i.'">' . $row['description'] . '</option>';
                                $i++;
                            }
                            echo '</select>';
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="submit">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form method="post">
        <div class="search d-flex">
            <div class="col-3 m-5">
                <h5>Chi nhánh</h5>
                <?php
                $querySelectStore = mysqli_query($conn, "(SELECT name FROM stores)");
                echo '<select name="storeSearch" class="form-select" aria-label="Default select example">';
                echo '<option selected value="all">Tất cả</option>';
                $i = 1;
                while ($row = mysqli_fetch_assoc($querySelectStore)) {
                    echo '<option value="' . $i . '">' . $row['name'] . '</option>';
                    $i++;
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-3 m-5">
                <h5>Phòng ban</h5>
                <?php
                $querySelectGroup = mysqli_query($conn, "(SELECT description FROM groups)");
                echo '<select name="groupSearch" class="form-select" aria-label="Default select example">';
                echo '<option selected value="all">Tất cả</option>';
                $i = 1;
                while ($row = mysqli_fetch_assoc($querySelectGroup)) {
                    echo '<option value="' . $i . '">' . $row['description'] . '</option>';
                    $i++;
                }
                echo '</select>';
                ?>
            </div>
            <div class="col-3 m-5" style="margin-top: 5rem!important;">
                <button type="submit" name="submitSearch" class="btn btn-primary">Hiển thị</button>
            </div>

        </div>
    </form>
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
                $querySearch = mysqli_query($conn, "SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
                LEFT JOIN groups as gr 
                ON us.main_group_id = gr.id
                LEFT JOIN stores as st
                ON us.main_store_id  = st.id");
                if (isset($_POST["submitSearch"])) {
                    $storeName = $_POST['storeSearch'];
                    $groupSearch = $_POST['groupSearch'];
                    if ($storeName == 'all' && $groupSearch == 'all') {
                        $querySearch;
                    } elseif ($storeName == 'all') {
                        $querySearchValue = mysqli_query($conn, "SELECT st.id,gr.id, us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
                        LEFT JOIN groups as gr 
                        ON us.main_group_id = gr.id
                        LEFT JOIN stores as st
                        ON us.main_store_id  = st.id
                        where  gr.id = '$groupSearch'
                    ");
                        $querySearch  = $querySearchValue;
                    } elseif ($groupSearch == 'all') {
                        $querySearchValue = mysqli_query($conn, "SELECT st.id,gr.id, us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
                        LEFT JOIN groups as gr 
                        ON us.main_group_id = gr.id
                        LEFT JOIN stores as st
                        ON us.main_store_id  = st.id
                        where  st.id = '$storeName'
                    ");
                        $querySearch  = $querySearchValue;
                    } elseif ($storeName == null || $groupSearch == null) {
                        $querySearch = $querySearchAll;
                    } else {
                        $querySearchValue = mysqli_query($conn, "SELECT st.id,gr.id, us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
                        LEFT JOIN groups as gr 
                        ON us.main_group_id = gr.id
                        LEFT JOIN stores as st
                        ON us.main_store_id  = st.id
                       where st.id = '$storeName' and gr.id = '$groupSearch'
                    ");
                        $querySearch  = $querySearchValue;
                    }
                    while ($rowSearch = mysqli_fetch_assoc($querySearch)) {
                        echo '<tr>';
                        echo   '<th scope="row">' . $rowSearch['id'] . '</th>';
                        echo   '<td>' . $rowSearch['name'] . '</td>';
                        echo   '<td>' . $rowSearch['address'] . '</td>';
                        echo   '<td>' . $rowSearch['birthday'] . '</td>';
                        if ($rowSearch['strname'] == null) {
                            echo   '<td scope="chi nhánh">----</td>';
                        } else {
                            echo   '<td scope="chi nhánh">' . $rowSearch['strname'] . '</td>';
                        }
                        if ($rowSearch['description'] == null) {
                            echo   '<td>----</td>';
                        } else {
                            echo   '<td>' . $rowSearch['description'] . '</td>';
                        }
                        echo   '<td>' . $rowSearch['created'] . '</td>';
                        echo '<td><button class="btn btn-group"><a href="model/update.php?updateid=' . $rowSearch['id'] . '"><i class="fa-solid fa-pen-to-square" style="color:blue;"></i></a></button><button class="btn btn-group"><a href="model/delete.php?deleteid=' . $rowSearch['id'] . '"><i class="fa-solid fa-trash" style="color:red;"></i></a></button></td>';
                        echo  '</tr>';
                    };
                }

                // $query1 = mysqli_query($conn, "SELECT us.id, us.name, us.address, us.birthday, st.name as strname, gr.description, us.created FROM users AS us 
                // LEFT JOIN groups as gr 
                // ON us.main_group_id = gr.id
                // LEFT JOIN stores as st
                // ON us.main_store_id  = st.id");
                while ($row = mysqli_fetch_assoc($querySearch)) {
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
                    echo '<td><button class="btn btn-group"><a href="model/upload.php?uploadid=' . $row['id'] . '"><i class="fa-solid fa-eye" style="color:blue;"></i></a></button><button class="btn btn-group"><a href="model/update.php?updateid=' . $row['id'] . '"><i class="fa-solid fa-pen-to-square" style="color:blue;"></i></a></button><button class="btn btn-group"><a href="model/delete.php?deleteid=' . $row['id'] . '"><i class="fa-solid fa-trash" style="color:red;"></i></a></button></td>';
                    echo  '</tr>';
                };

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