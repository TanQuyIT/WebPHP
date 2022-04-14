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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thêm Phòng ban</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<?php
   
    
    $error = '';
    $name = '';
    $mota = '';
    $sophong = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['name']) && isset($_POST['sophong']) && isset($_POST['mota'])){
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
                $sql = 'SELECT * FROM phongban WHERE sophong = ?';
                $stm = $conn->prepare($sql);
                $stm->bind_param('i',$sophong);
                $stm->execute();

                if ($stm->get_result()->num_rows > 0){
                    $error = 'Số phòng đã tồn tại - vui lòng chọn số phòng khác';
                }else{
                    
                    $sql = 'INSERT INTO phongban(sophong,name,mota) VALUES(?,?,?)';
                    $stm = $conn->prepare($sql);
                    $stm->bind_param('iss',$sophong,$name,$mota);

                    print_r($stm->execute());
                    require_once('../Account/navbar.php');

                    ?>
                    
                    <div class="row justify-content-center mt-5">
                        <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                            <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Thêm Phòng ban</h3>
                            <p class="text-success">Phòng <?=$name ?> đã được thêm vào hệ thống.</p>
                            <p>Click <a href="index.php">vào đây</a> để danh sách phòng ban hiện tại</p>
                            <a class="btn btn-success px-5" href="index.php">Danh sách phòng ban</a>
                        </div>
                    </div>
                    <?php
                    die();
                }
            }
          
        }
    }  
    require_once('../Account/navbar.php');
?>

<body>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10 border rounded my-5 p-4  mx-3">
                <!-- <p class="mb-5"><a href="index.php">Quay lại</a></p> -->
                <h3 class="text-center text-secondary mt-2 mb-3">Thêm Phòng ban</h3>
                <form method="post" action="addPhongban.php" novalidate>

                    <div class="form-group">
                        <label for="sophong">Số phòng</label>
                        <input value="" name="sophong" required class="form-control" type="number" placeholder="Số phòng" id="sophong">
                    </div>

                    <div class="form-group">
                        <label for="name">Tên phòng</label>
                        <input value="" name="name" required class="form-control" type="text" placeholder="Tên phòng" id="name">
                    </div>

                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea id="mota" name="mota" rows="4" class="form-control" placeholder="Mô tả"></textarea>
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                    </div>
                    <div class="row justify-content-end">
                        <button type="submit" class="btn btn-success px-5 mr-3">Thêm</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>
</html>