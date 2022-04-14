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
if (!empty($_GET['id'])){
$id = $_GET['id'];
}else{
header('Location: index.php');
}
require_once('../conndb.php');
  $sql = 'SELECT * FROM account WHERE id = ?';
  $stm = $conn->prepare($sql);
  $stm->bind_param('i',$id);
  $stm->execute();
  $data = $stm->get_result();
  if ($data->num_rows != 1){
    header('Location: index.php');
    die();
  }
  else{
    $data = $data->fetch_assoc();
    $name = $data['name'];
    $chucvu = $data['chucvu'];
    $phongban = $data['phongban'];
    $user = $data['user'];
    $gioitinh = $data['gioitinh'];
    $ngaysinh = $data['ngaysinh'];
    $avata = $data['avata'];
    if (empty($avata)){
        if ($gioitinh ==='Nam'){
            $avata = '/img/img_avatar.png';
        }else{
            $avata = '/img/avatar.png';
        }
    }
    $songaynghi = $data['songaynghi'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thông tin nhân viên</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link 
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
  
  require_once('navbar.php');

?>
<br>
  <div class="container mt-5">
    <div class="main-body">
      <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center h-100">
                <img src="<?=$avata?>" alt="avatar" class="rounded-circle w-75 img-fluid  img-card-top h-75">
                <div class="mt-2">
                  <h4><?= $name?></h4>
                  <p class="text-secondary mb-1"><?=$chucvu?></p>
                  <?php
                    if ($id != 1){ ?>
                      <p class="text-muted font-size-sm">P. <?=$phongban?></p>
                      <button onclick="showDLMK()" class="btn btn-outline-danger mb-1">Khôi phục mật khẩu</button>
                   <?php }
                  ?>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card mb-3">
            <div class="card-header">
              <h3>Thông tin chi tiết</h3> 
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Họ tên</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?=$name?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Mã nhân viên</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?= $id?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Giới tính</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?=$gioitinh?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Ngày sinh</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?=$ngaysinh?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Tên đăng nhập</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?=$user?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Số ngày nghỉ</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?=$songaynghi?>
                </div>
              </div>
              
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="row justify-content-center">
			<div class="col col-md-6 p-3">
				<div id="tb_datlai_mk_thanhcong" class="alert alert-success alert-dismissable" style="display: none;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Đã đặt lại mật khẩu mặt định cho <strong><?=$user?></strong> 
				</div>
				<br>
				<div id="tb_datlai_mk_k_thanhcong" class="alert alert-danger alert-dismissable" style="display: none;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Failed!</strong> Chưa thể đặt lại mật khẩu mặt định cho <strong><?=$user?></strong>
				</div>
			</div>
		</div>
  </div>


  <script src="../main.js"></script>
   <div class="modal fade" id="profile_doimk">
       <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Khôi phục mật khẩu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc rằng muốn đặt lại mật khẩu mặt định cho <strong><?=$user?></strong> </p>
                </div>
                <form action="resetPassword.php" method="post" id="dlmk">
                    <input type="hidden" id="Datlai_mk_user_val" name="user" value="<?=$user?>">
                    <div class="modal-footer">
                        <button type="submit" id="datlai_mk" class="btn btn-danger">Đặt lại</button>
                        <button class="btn btn-outline-dark" data-dismiss="modal">Thoát</button>
                    </div>
                </form>
            </div>
       </div>
   </div>

</body>
</html>