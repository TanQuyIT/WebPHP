<?php
    session_start();
    if (!isset($_SESSION['account'])) {
        header('Location: /login.php');
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kích hoạt tài khoản</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<?php
  
    $data = $_SESSION['account'];
    
    if ($data['chucvu'] ==='Trưởng phòng'){
        require_once('../Truongphong/navbar.php');
    }elseif ($data['chucvu'] ==='Nhân viên'){
        require_once('../Nhanvien/navbar.php');
    }else{
        require_once('../Account/navbar.php');
    }



    $user = $data['user'];
    $passOld = '';
    $pass = '';
    $pass2 = '';
    $error = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['passOld']) && isset($_POST['pass']) && isset($_POST['pass2'])) {
            $passOld = $_POST['passOld'];
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];
            require_once('../conndb.php');      

            if (empty($passOld)){
                $error = 'Vui lòng nhập mật khẩu cũ';
            }elseif(!password_verify($passOld,'$2y$12$sJNv9s/pwRA5EOEFNfzg1ew3s22UbuET3JpeUvb5z.RLmb1Hkq3Aq')){
                $error = 'Mật khẩu cũ không chính xác';
            }
            elseif (empty($pass)){
                $error = 'Vui lòng nhập mật khẩu mới';
            }
            elseif (empty($pass2)){
                $error = 'Vui lòng xác nhận lại mật khẩu';
            }
            elseif ($pass != $pass2){
                $error = 'Mật khẩu và mật khẩu xác nhận không trùng khớp';
            }
            elseif (strlen($pass) < 6){
                $error = 'Mật khẩu cần phải từ 6 kí tự trở lên';
            }
            else{

                $pass = password_hash($pass,PASSWORD_BCRYPT,array('cost' => 12));

                $id = 1;
                $sql = 'UPDATE account SET pass = ? WHERE id = ?';
               
                $stm = $conn->prepare($sql);
                $stm->bind_param('si',$pass,$id);

                $stm->execute();
                session_destroy();
                ?>
                <div class="row justify-content-center mt-5">
                    <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                        <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Đổi mật khẩu</h3>
                        <p class="text-success">Mật khẩu đã được thay đổi.</p>
                        <p>Click <a href="/login.php">vào đây</a> hoặc nhấp đăng nhập để truy cập hệ thống bằng mật khẩu đã thay đổi.</p>
                        <a class="btn btn-success px-5" href="/login.php">Đăng nhập</a>
                    </div>
                </div>
                <?php
                die();
            }
        }
    }

?>

<body>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Đặt lại mật khẩu</h3>
                <form method="post" action="" novalidate>
                    <div class="form-group">
                        <label for="user">Tên đăng nhập</label>
                        <input  value="<?= $user ?>" name="user" class="form-control" disabled type="text" id="user">
                    </div>
                    <div class="form-group">
                        <label for="passOld">Mật khẩu cũ</label>
                        <input  value="" name="passOld" class="form-control" type="password" placeholder="Mật khẩu cũ" id="passOld">
                    </div>
                    <div class="form-group">
                        <label for="pass">Mật khẩu mới</label>
                        <input  value="" name="pass" class="form-control" type="password" placeholder="Mật khẩu mới" id="pass">
                    </div>
                    <div class="form-group">
                        <label for="pass2">Xác nhận mật khẩu</label>
                        <input value="" name="pass2" class="form-control" type="password" placeholder="Xác nhận mật khẩu" id="pass2">
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>". $error ."</div>";
                            }
                        ?>
                        <button type="submit" class="btn btn-success px-5 mt-3 mr-2" style="width: 48.5%">Cập nhật</button>
                        <button type="reset" class="btn btn-outline-success px-5 mt-3" style="width: 48.5%">Nhập lại</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>