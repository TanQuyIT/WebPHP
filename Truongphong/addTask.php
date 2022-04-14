<?php
  session_start();

  if (!isset($_SESSION['account'])) {
      header('Location: /login.php');
      die();
  }

  if ($_SESSION['account']['chucvu'] != 'Trưởng phòng'){
      header('Location: /login.php');
      die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tạo Task mới</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<?php
  
    $data= $_SESSION['account'];
    $idTP = $data['id'];
    $phongban = $data['phongban'];
    $idPhong = $data['idPhong'];
   

  
    $error = '';
    $name = '';
    $nhanvien = '';
    $dealine = '';
    $mota = '';
    $idNV = -1;
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['name']) && isset($_POST['nhanvien']) && isset($_POST['dealine'])){
            $name = $_POST['name'];
            $idNV = $_POST['nhanvien'];

            
            $dealine = $_POST['dealine'];
            $mota = $_POST['mota'];
            $idPhong = $_POST['idPhong'];

            if (empty($name)){
                $error = 'Vui lòng nhập tên công việc cần thực hiện';
            }elseif ($idNV === -1){
                $error = 'Vui lòng chọn nhân viên thực hiện';
            }elseif (empty($dealine)){
                $error = 'Công việc cần hoàn thành trước một thời điểm nhất định';
            }else{
                $now = date('Y-m-d H:i:s');
                $dealine;
                // print_r($now);
                // print_r($dealine);
                if ($dealine < $now){
                    $error = 'Thời hạn hoàn thành phải từ sau ngày hôm nay';
                }else
                {
                    
                    if ($_FILES['taskFile']['error'] != UPLOAD_ERR_OK){
                        $namefile = '';
                        $srcfile = '#';
                    }else{
                        $f = $_FILES['taskFile'];
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

                   if ($error ===""){
                        // tìm tên nhan vien theo id nhân viên
                        require_once('../conndb.php');
                        $sql = 'SELECT name FROM account WHERE id = ?';
                        $stm = $conn->prepare($sql);
                        $stm->bind_param('i',$idNV);
                        $stm->execute();
                        $nhanvien = $stm->get_result()->fetch_assoc()['name'];

                        // them task
                        $sql = 'INSERT INTO task(name,idNV,nhanvien,mota,file,dealine,idPhong,ngaygiao,ngaythaydoi) VALUES(?,?,?,?,?,?,?,?,?)';
                        $stm = $conn->prepare($sql);

                        $stm->bind_param('sissssiss',$name,$idNV,$nhanvien,$mota,$namefile,$dealine,$idPhong,$now,$now);

                        

                        if ($stm->execute()){
                            $idTask = mysqli_insert_id($conn);
                            $tp_nv = 1;
                            $sql = 'INSERT INTO chitiettask(idTask,noidung,timesubmit,dealine,file,tp_nv) VALUES (?,?,?,?,?,?)';
                            $stm = $conn->prepare($sql);
                            $stm->bind_param('issssi',$idTask,$mota,$now,$dealine,$namefile,$tp_nv);
                            $stm->execute();

                            if ($srcfile != '#'){
                                move_uploaded_file($tmp,$srcfile);
                            }
                            require_once('navbar.php');

                            ?>
                                <div class="row justify-content-center mt-5">
                                    <div class="col-xl-5 col-lg-6 col-md-8 border my-5 p-4 rounded mx-3">
                                        <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Phân công công việc</h3>
                                        <p class="text-success">Nhân viên <?=$nhanvien ?> đã được phân nhiệm vụ: <?= $name ?>.</p>
                                        <p>Click <a href="index.php">vào đây</a> để xem danh sách cộng việc</p>
                                        <a class="btn btn-success px-5" href="index.php">Danh sách công việc</a>
                                    </div>
                                </div>
                            <?php
                            die();
                            
                        } 
                   }             
                }

            }
        }
    }
    



    require_once('../conndb.php');
    $sql = 'SELECT id,name FROM account WHERE idPhong = ? AND id != ?';
    
    $listaccount = array();
    
    $stm = $conn->prepare($sql);
    $stm->bind_param('ii',$idPhong,$idTP);
    $stm->execute();

    $result = $stm->get_result();
    
    while ($row = $result->fetch_assoc()){
        $listaccount[] = $row;
    }
    require_once('navbar.php');
?>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10 border rounded my-5 p-4 mx-3">
                <!-- <p class="mb-5"><a href="index.php">Quay lại</a></p> -->
                <h3 class="text-center text-secondary mt-2 mb-3 mb-3">Tạo task mới</h3>
                <form method="post" action="addTask.php" novalidate enctype="multipart/form-data" >
                    <input type="hidden" name="idPhong" value="<?=$idPhong?>">
                    <div class="form-group">
                        <label for="name">Tên task mới</label>
                        <input value="" name="name" required class="form-control" type="text" placeholder="Tên Task mới" id="name">
                    </div>

                    <div class="form-group">
                        <label for="nhanvien">Chọn nhân viên thực hiện:</label>
                        <select name="nhanvien" required class="form-control" id="nhanvien">
                            <option value="-1" selected>--</option>
                        <?php
                        foreach ($listaccount as $x){
                        ?>
                            <option value="<?= $x['id'] ?>"><?= $x['name'] ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        
                    </div>

                    <div class="form-group">
                        <label for="dealine">Thời điểm hoàn thành</label>
                        <input value="" name="dealine" required class="form-control" type="date" id="dealine">
                    </div>
              
                    <div class="form-group">
                        <label for="mota">Mô tả</label>
                        <textarea id="mota" name="mota" rows="4" class="form-control" placeholder="Mô tả"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="taskFile" id="taskFile" class="custom-file-input">
                            <label for="taskFile" id="label_name_up" class="custom-file-label">Tệp đính kèm</label>
                        </div>
                    </div>
<!-- 
                    <div class="form-group">
                        <label for="">Tệp đính kèm</label>
						<div class="custom-file">
							<input name="document" type="file" class="custom-file-input" id="document">
							<label id="label" class="custom-file-label" for="document">Choose file</label>
						</div>
					</div> -->

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
    <script src="/main.js"></script>

</body>