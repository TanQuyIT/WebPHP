<?php
    session_start();
    if (!isset($_SESSION['account'])) {
        header('Location: /login.php');
        die();
    }
    if ($_SESSION['account']['chucvu'] === 'Giám đốc'){
        header('Location: listYC.php');
    }
    $data= $_SESSION['account'];
    $idNV = $data['id'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Nộp đơn nghỉ phép</title>
  <meta charset="utf-8">
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

 
  

 if ($data['chucvu'] === 'Trưởng phòng'){
     require_once('../Truongphong/navbar.php');
 }else{
     require_once('../Nhanvien/navbar.php');
 }

require_once('../conndb.php');
  $sql = 'SELECT * FROM account WHERE  id= ?';
  $stm = $conn->prepare($sql);
  $stm->bind_param('s',$idNV);
  $stm->execute();

  $result = $stm->get_result();
  $data = $result->fetch_assoc();
 $nhanvien = $data['name'];
 $idNV = $data['id'];
 $idPhong = $data['idPhong'];
 $chucvu = $data['chucvu'];
 $songaydanghi = $data['songaynghi'];
 $maxnghi = 12 - $songaydanghi;
 if ($chucvu === 'Trưởng phòng'){
     $maxnghi = 15 - $songaydanghi;
 }
 if ($maxnghi <= 0){
    //hết số ngày nghỉ
    ?>
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Gửi đơn xin nghỉ phép</h3>
                <p class="text-info">Bạn đã sử dụng hết của ngày nghỉ trong năm của mình.</p>
                <p>Click <a href="index.php">vào đây</a> để thông tin chi tiết số lần nghỉ phép của mình</p>
                <a class="btn btn-success px-5" href="index.php">Xem chi tiết</a>
            </div>
        </div>
    <?php
    die();
 }

 $phepgapnhat = $data['ngayxinphep'];
 $today = date('Y-m-d');
 
 if (((strtotime($today) - strtotime($phepgapnhat))/86400)<7){
    //chưa đủ 7 ngày từng lập nộp đơn gần nhất
    ?>
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Gửi đơn xin nghỉ phép</h3>
                <p class="text-info">Trong 7 ngày gần nhất bạn đã gửi đơi xin nghỉ phép vì vậy hiện giờ bạn không thể gửi thêm đơn xin nghỉ phép nào.</p>
                <p class="text-info">Vui lòng quay lại sau</p>
                <p>Click <a href="index.php">vào đây</a> xem thông tin nghỉ phép chi tiết</p>
                <a class="btn btn-outline-primary px-5" href="index.php">Xem thông tin</a>
            </div>
        </div>
    <?php
    die();
 }





 $ngayBDnghi = '';
 $songaymuonnghi = 0;
 $lydo = '';
 $now = date('Y-m-d H:i:s');
 $error = '';
 if ($_SERVER["REQUEST_METHOD"] == "POST"){
     if (isset($_POST['ngayBDnghi']) && isset($_POST['songaymuonnghi']) && isset($_POST['lydo'])){
         $ngayBDnghi = $_POST['ngayBDnghi'];
         $songaymuonnghi = $_POST['songaymuonnghi'];
         $lydo = $_POST['lydo'];

        if (empty($ngayBDnghi)){
            $error = 'Vui lòng chọn ngày bắt đầu nghỉ';
        }elseif($ngayBDnghi <= $now){
            $error = 'Ngày bắt đầu nghỉ phải từ sau ngày hôm nay trở đi';
        }
        elseif ($songaymuonnghi <= 0){
            $error = 'Vui lòng chọn số ngày nghỉ';
        }elseif ($songaymuonnghi > $maxnghi){
            $error = 'Số ngày muốn nghỉ vượt quá số ngày nghỉ được phép.';
        }
        elseif (empty($lydo)){
            $error = 'Cần có lý do nghỉ phù hợp.';
        }else{
            if ($_FILES['FileNghi']['error'] != UPLOAD_ERR_OK){
                $namefile = '';
                $srcfile = '#';
            }else{
                $f = $_FILES['FileNghi'];
                $tmp = $f['tmp_name'];
                $namefile = $f['name'];

                $sizefile = $f['size'];
                $ext = pathinfo($namefile,PATHINFO_EXTENSION);

                if ($sizefile > 500*1024*1024){
                    $error = 'Kích thước file vượt quá <b>500M';
                }elseif(in_array($ext,['exe','msi','sh'])){
                    $error = 'Các tập tin thực thi không được phép upload';
                }
                $namefile = time().$namefile;
                $srcfile = $_SERVER['DOCUMENT_ROOT'] .'/Truongphong/UploadFile/'.$namefile;
            }

            if ($error===""){
                //them yêu cầu nghỉ phép
                require_once('../conndb.php');
                $sql = 'INSERT INTO nghiphep(nhanvien,idNV,idPhong,chucvu,ngayBDnghi,songaymuonnghi,lydo,file,ngaythaydoi) VALUES (?,?,?,?,?,?,?,?,?)';
                $stm = $conn->prepare($sql);
                $stm->bind_param('siississs',$nhanvien,$idNV,$idPhong,$chucvu,$ngayBDnghi,$songaymuonnghi,$lydo,$namefile,$now);
                if ($stm->execute()){
                    $sql = 'UPDATE account SET ngayxinphep = ? WHERE id = ?';
                    $stm = $conn->prepare($sql);
                    $stm->bind_param('si',$now,$idNV);
                    $stm->execute();
                    if ($srcfile != '#'){
                        move_uploaded_file($tmp,$srcfile);
                    }
                    ?>
                        <br>
                        <div class="row justify-content-center mt-5">
                            <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Gửi đơn xin nghỉ phép</h3>
                                <p class="text-success">Bạn vừa gửi thành công đơn xin nghỉ phép.</p>
                                <p class="text-dark">Lưu ý: Ít nhất 7 nữa bạn mới có thể nộp một đơn xin nghỉ phép khác</p>
                                <p>Click <a href="index.php">vào đây</a> để xem tình trạng nghỉ phép của mình</p>
                                <a class="btn btn-success px-5" href="index.php">Chi tiết nghỉ phép</a>
                            </div>
                        </div>
                    <?php
                    die();
                }

            }
        }
     }
 }


?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-7 col-md-9 border rounded my-5 p-4 mx-3">
                <!-- <p class="mb-5"><a href="index.php">Quay lại</a></p> -->
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Nộp đơn nghỉ phép</h3>
                <form method="post" action="creatYC.php" novalidate enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="nhanvien">Tên nhân viên:</label>
                        <input value="<?=$nhanvien?>" name="nhanvien" required class="form-control" type="text" disabled>                       
                    </div>

                    <div class="form-group">
                        <label for="ngayBDnghi">Bắt đầu nghỉ từ ngày</label>
                        <input value="" name="ngayBDnghi" required class="form-control" type="date">
                    </div>

                    <div class="form-group">
                        <label for="songaymuonnghi">Số ngày muốn nghỉ</label>
                        <input type="number" name="songaymuonnghi" class="form-control" max="<?=$maxnghi?>" min="1">
                        <small class="text text-danger">(*) Số ngày nghỉ còn lại trong năm là <?=$maxnghi?></small>
                    </div>
              
                    <div class="form-group">
                        <label for="lydo">Lý do nghỉ</label>
                        <textarea name="lydo" rows="4" class="form-control" placeholder="Lý do nghỉ"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="FileNghi" id="FileNghi" class="custom-file-input">
                            <label for="FileNghi" id="FileNghi" class="custom-file-label">Tệp đính kèm</label>
                        </div>
                    </div>

                    <div class="form-group ">
                        <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                        ?>
                    </div>
                    <div class="row justify-content-end">

                        <button type="submit" class="btn btn-success px-5 mr-3 ">Gửi Đơn</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
    <script src="/main.js"></script>

</body>