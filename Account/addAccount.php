<?php
   session_start();
   if (!isset($_SESSION['account'])) {
       header('Location: /login.php');
       die();
   }
   if ($_SESSION['account']['chucvu'] !='Giám đốc'){
       header('Location: /login.php');
       die();
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thêm nhân viên</title>
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
    $ngaysinh = '';
    $gioitinh = '';
    $user = '';
    $phongban = '';
    $chucvu = '';
    $idPhong = -1;

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['name']) && isset($_POST['user']) && isset($_POST['ngaysinh']) && isset($_POST['gioitinh']) && isset($_POST['phongban']) && isset($_POST['chucvu'])){
            $name = $_POST['name'];
            $ngaysinh = $_POST['ngaysinh'];
            $gioitinh = $_POST['gioitinh'];
            $user = $_POST['user'];
            $idPhong = $_POST['phongban'];
            $chucvu = $_POST['chucvu'];
            if (empty($name)){
                $error = 'Vui lòng điền đầy đủ họ tên nhân viên';
            }elseif(empty($ngaysinh)){
                $error = 'Vui lòng chọn ngày sinh cho nhân viên';
            }elseif(empty($gioitinh)){
                $error = 'Vui lòng chọn giới tính cho nhân viên';
            }
            elseif(empty($user)){
                $error = 'Vui lòng điền tên đăng nhập cho nhân viên';
            }elseif($idPhong ===-1){
                $error = 'Vui lòng chọn phòng ban cho nhân viên';
            }elseif(empty($chucvu)){
                $error = 'Vui lòng điền đầy đủ chức vụ của nhân viên';
            }else{
                require_once('../conndb.php');
                //tìm tên phòng ban

                $sql = 'SELECT name FROM phongban WHERE id = ?';
                $stm = $conn->prepare($sql);
                $stm->bind_param('i',$idPhong);
                $stm->execute();
                $phongban = $stm->get_result()->fetch_assoc()['name'];

                // thêm nhân viên
                $sql = 'SELECT * FROM account WHERE user = ?';
                $stm = $conn->prepare($sql);
                $stm->bind_param('s',$user);
                $stm->execute();
                if ($stm->get_result()->num_rows > 0){
                    $error = 'Tên đăng nhập của nhân viên đã trùng với một nhân viên khác';
                }else{
                    $pass = $user;
                    //$ngaysinh = date('d/m/Y');

                    $sql = 'INSERT INTO account(name,ngaysinh,gioitinh,user,pass,phongban,chucvu,idPhong) VALUES(?,?,?,?,?,?,?,?)';
                    $stm = $conn->prepare($sql);
                    $stm->bind_param('sssssssi',$name,$ngaysinh,$gioitinh,$user,$pass,$phongban,$chucvu,$idPhong);

                    $stm->execute();
                    require_once('navbar.php');

                    ?>
                    <div class="row justify-content-center mt-5">
                        <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                            <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Thêm Nhân viên</h3>
                            <p class="text-success"><?=$name ?> đã được thêm vào hệ thống với chức vụ nhân viên</p>
                            <p>Click <a href="index.php">vào đây</a> để xem danh sách nhân viên</p>
                            <a class="btn btn-success px-5" href="index.php">Danh sách nhân viên</a>
                        </div>
                    </div>
                    <?php
                    die();
                }
            }
            
        }
    }  
    
    require_once('../conndb.php');
    $sql = 'SELECT id,name FROM phongban';
    
    $listphongban = array();
    
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()){
        $listphongban[] = $row;
    }
    require_once('navbar.php');

?>

<body>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 border rounded my-5 p-4  mx-3">
                <!-- <p class="mb-5"><a href="index.php">Quay lại</a></p> -->
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Thêm nhân viên</h3>
                <form method="post" action="addAccount.php" novalidate>

                    <div class="form-group">
                        <label for="name">Họ tên nhân viên</label>
                        <input value="" name="name" required class="form-control" type="text" placeholder="Họ tên nhân viên" id="name">
                    </div>

                    <div class="form-group">
                        <label for="ngaysinh">Ngày sinh</label>
                        <input value="" name="ngaysinh" required class="form-control" type="date" id="ngaysinh">
                    </div>

                    <div class="form-group">
                        <label for="gioitinh">Giới tính</label>
                        <select name="gioitinh" required class="form-control" id="gioitinh"> 
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="user">Tên đăng nhập</label>
                        <input value="" name="user" required class="form-control" type="text" placeholder="Tên đăng nhập" id="user">
                    </div>

                    <div class="form-group">
                        <label for="phongban">Chọn phòng ban:</label>
                        <select name="phongban" required class="form-control" id="phongban">
                            <option value="-1" selected>--</option>
                        <?php
                        foreach ($listphongban as $x){
                        ?>
                            <option value="<?= $x['id'] ?>"><?= $x['name'] ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        
                    </div>
                    
                    <div class="form-group">
                        <input value="Nhân viên"  name="chucvu" class="form-control" type="hidden" id="chucvu">
                    </div>

                    <div class="form-group">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                    </div>
                    <div class="row justify-content-end">
                        <button type="submit" class="btn btn-success px-5 mr-3">Thêm nhân viên</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</body>