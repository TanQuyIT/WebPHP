<?php
    session_start();
    if (!isset($_SESSION['account'])) {
        header('Location: /login.php');
        die();
    }
    if ($_SESSION['account']['chucvu'] != 'Giám đốc'){
        header('Location: /login.php');
        die();
    }

    $error = '';
    $name = '';
    $mota = '';
    $sophong = '';

    if (empty($_GET['id']) && empty($_POST['id'])){
        header('Location: index.php');
    }elseif(!empty($_GET['id'])){
        $id = $_GET['id'];
        require_once('../conndb.php');
        $sql = 'SELECT * FROM phongban WHERE id = ?';
        $stm = $conn->prepare($sql);
        $stm->bind_param('i',$id);
        $stm->execute();
        $data = $stm->get_result();
        if ($data->num_rows != 1){
           header('Location: index.php');
        }else{
            $row = $data->fetch_assoc();
            $sophong = $row['sophong'];
            $name = $row['name'];
            $mota = $row['mota'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sửa đổi thông tin Phòng ban</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<?php
    require_once('../Account/navbar.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['name']) && isset($_POST['sophong']) && isset($_POST['mota'])){
            $id = $_POST['id'];
            $name = $_POST['name'];
            $sophong = $_POST['sophong'];
            $mota = $_POST['mota'];
            if (empty($sophong)){
                $error = 'Vui lòng điền số phòng';
            } elseif($sophong <1){
                $error = 'Số phòng không hợp lệ';
            }elseif(empty($name)){
                $error = 'Vui lòng điền tên phòng ban';
            }else{
                require_once('../conndb.php');
                $sql = 'UPDATE phongban SET sophong = ?, name = ?, mota = ? WHERE id = ?';
                $stm = $conn->prepare($sql);
                $stm->bind_param('issi',$sophong,$name,$mota,$id);
                $stm->execute();
                ?>
                <div class="row justify-content-center mt-5">
                    <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                        <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Cập nhật thông tin Phòng ban</h3>
                        <p class="text-success">Phòng <?=$name ?> đã hệ thống cập nhật thành công.</p>
                        <p>Click <a href="index.php">vào đây</a> để xem danh sách phòng ban</p>
                        <a class="btn btn-success px-5" href="index.php">Danh sách phòng ban</a>
                    </div>
                </div>
                <?php
                die();
            }
        }
    }  
    //var_dump($row);
?>

<body>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3">
                <!-- <p class="mb-5"><a href="index.php">Quay lại</a></p> -->
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Cập nhật thông tin phòng ban</h3>
                <form method="post" action="updatePhongban.php" novalidate>
                    <input type="hidden" name="id" value="<?=$id?>">
                    <div class="form-group">
                        <label for="sophong">Số phòng</label>
                        <input value="<?=$sophong?>" name="sophong" required class="form-control" type="number" placeholder="Số phòng" id="sophong">
                    </div>

                    <div class="form-group">
                        <label for="name">Tên phòng</label>
                        <input value="<?=$name?>" name="name" required class="form-control" type="text" placeholder="Tên phòng" id="name">
                    </div>

                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea id="mota" name="mota" rows="4" class="form-control" placeholder=""><?=$mota?></textarea>
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                    </div>
                    <div class="row justify-content-end">
                        <button type="submit" class="btn btn-primary px-5 mr-3">Cập nhật</button>

                    </div>
                </form>

            </div>
        </div>

    </div>
</body>
</html>