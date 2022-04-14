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
    <meta charset="utf-8">
    <title>Thông tin Cá nhân</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link 
        rel="stylesheet"
        href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</head>
<body>
<?php


  
  $data= $_SESSION['account'];

  $id = $data['id'];
  // cần sửa
  require_once('conndb.php');
  $sql = 'SELECT * FROM account WHERE  id= ?';
  $stm = $conn->prepare($sql);
  $stm->bind_param('s',$id);
  $stm->execute();

  $result = $stm->get_result();
  $data = $result->fetch_assoc();

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
  if ($data['chucvu'] === 'Giám đốc'){
    require_once('./Account/navbar.php');
  }elseif($data['chucvu'] === 'Trưởng phòng'){
    require_once('./Truongphong/navbar.php');
  }else{
    require_once('./Nhanvien/navbar.php');
  }
?>
<br>
  <div class="container mt-5">
    <div class="main-body">
      <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                
                <img id="avatar_index" src="<?=$avata?>" alt="avatar" class="rounded-circle w-75">

                <div class="mt-2">
                  <h4><?= $name?></h4>
                  <p class="text-secondary mb-1"><?=$chucvu?></p>
                  <p class="text-muted font-size-sm"><?=$phongban?></p>
                  <input id="input_avatar" type="file" name="input_avatar_value" accept="image/*" style="display:none;">
                  <button onclick="doiavatar(input_avatar,'<?=$user?>')" class="btn btn-primary btn-sm mt-1">
                    Đổi ảnh đại diện
                  </button>
                  <a href="/Nhanvien/changePassword.php" class="btn btn-outline-primary btn-sm mt-1">Đổi mật khẩu</a>
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
			<div class="col col-md-6 ">
				
				<div id="tb_doiAVATAR_k_thanhcong1" class="alert alert-danger alert-dismissable" style="display: none">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Tập tin tải lên phải là ảnh có đuôi <strong>.jpg</strong> hoặc <strong>.png</strong>
				</div>
        <div id="tb_doiAVATAR_k_thanhcong2" class="alert alert-danger alert-dismissable" style="display: none">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Vui lòng chọn ảnh có kích thước dưới<strong>500M</strong>
				</div>
			</div>
		</div>
  </div>
 
</body>
</html>