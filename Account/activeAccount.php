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
    if ($data['active'] === 1){
        header('Location: /index.php');
    }

    $pass = '';
    $pass2 = '';
    $error = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['pass']) && isset($_POST['pass2'])) {
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];
            if (empty($pass)){
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
                require_once('../conndb.php');      

                $pass = password_hash($pass,PASSWORD_BCRYPT,array('cost' => 12));

                $active = 1;
                $id = $data['id'];
                $sql = 'UPDATE account SET pass = ?, active = ? WHERE id = ?';
               
                $stm = $conn->prepare($sql);
                $stm->bind_param('sii',$pass,$active,$id);

                $stm->execute();
                session_destroy();
                ?>
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                        <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Kích hoạt tài khoản</h3>
                        <p class="text-success">Đặt mật khẩu thành công! Tài khoản của bạn đã được kích hoạt.</p>
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
<div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Đặt lại mật khẩu</h3>
                <form method="post" action="activeAccount.php" novalidate>
                    <div class="form-group">
                        <label for="pass">Mật khẩu mới</label>
                        <input  value="" name="pass" class="form-control" type="password" placeholder="Mật khẩu mới" id="pass">
                        <div class="invalid-feedback">Mật khẩu không hợp lệ</div>
                    </div>
                    <div class="form-group">
                        <label for="pass2">Xác nhận mật khẩu</label>
                        <input value="" name="pass2" class="form-control" type="password" placeholder="Xác nhận mật khẩu" id="pass2">
                        <div class="invalid-feedback">Mật Khẩu không hợp lệ</div>
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>". $error ."</div>";
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success mr-3" style="width:30%">Cập nhật</button>
                        <button type="reset" class="btn btn-outline-success mr-3"style="width:30%">Nhập lại</button>
                        <a class="btn btn-dark" style="width:30%" href="/logout.php">Logout</a>
                    </div>
                </form>
                <br>
                <b class="text-danger">Lưu ý bạn phải thay đổi mật khẩu mới có thể truy cập vào hệ thống!</b>
            </div>
        </div>

    </div>
    
</body>