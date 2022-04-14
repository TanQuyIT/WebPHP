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
    <title>Thay đổi trưởng phòng</title>
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
    <link rel="stylesheet" href="../style.css">
    <script src="../main.js"></script>

</head>

<?php

  
    $id_phongban = 0;
    if (!empty($_GET['id'])){
        $id_phongban = $_GET['id'];
    }else{
        header('Location: index.php');
    }

    require_once('../conndb.php');
    $sql = 'SELECT * FROM phongban WHERE id = ?';

    $stm = $conn->prepare($sql);
    $stm->bind_param('i',$id_phongban);
    $stm->execute();

    $data = $stm->get_result();
    if ($data->num_rows != 1){
      header('Location: /Phongban/getPhongban.php');
      die();
    }else{
        $data = $data->fetch_assoc();
        $sophong = $data['sophong'];
        $phongban = $data['name'];
        $idTruongphong = $data['idTruongphong'];
        $truongphong = $data['truongphong'];
        $mota = $data['mota'];
    }
    require_once('../Account/navbar.php');
?>

<body>
   
    

    <div class="container" style="margin-top: 80px">
        <div class="row justify-content-center">
            <div class="card w-100">
               <div class="card-body">
                   <h2 class="card-title text-center">Phòng <?=$phongban?></h2>
                   <h5 class="card-subtitle mb-2 text-muted">Số phòng: <?=$sophong?></h5>
                   <p class="card-text">Giới thiệu:
                       <br>
                       <?=$mota?>
                       <br>
                    </p>
               </div>
              <div class="card-footer">
                <div class="row justify-content-end">
                    <a href="updatePhongban.php?id=<?=$id_phongban?>" class="btn btn-danger mr-3"><i class="fas fa-edit"> Chỉnh sửa thông tin</i></a>
                </div>
              </div>
            </div>
        </div>
        <?php
            require_once('../conndb.php');
            $sql = 'SELECT * FROM account WHERE idPhong = ?';

            $stm = $conn->prepare($sql);
            $stm->prepare($sql);
            $stm->bind_param('s',$id_phongban);
            $stm->execute();

            $result = $stm->get_result();
            $accounts = array();

            $id = -1;
            $name = 'Chưa có trưởng phòng';
            $chucvu = '';
            $avata = '';
            $srcHref= '#';
            while ($row = $result->fetch_assoc()){
                $accounts[] = $row;

                if ($row['id'] != $idTruongphong){
                }else{
                    $id = $row['id'];
                    $idTruongphong = $id;
                    $name = $row['name'];
                    $chucvu = $row['chucvu'];
                    $avata = $row['avata'];
                    if (empty($avata)){
                        if ($row['gioitinh'] ==='Nam'){
                            $avata = '/img/img_avatar.png';
                        }else{
                            $avata = '/img/avatar.png';
                        }
                    }
                    $srcHref = '/Account/profile.php?id='.$id;
                }
            }
        ?>
        <h4 class="text-secondary mt-2 mb-3 mb-3">Trưởng phòng</h4>
        <hr>
     
        <div class="row">
            <div class="col-sm-10 col-lg-3 col-xl-3 py-1">
                <div class="card h-100 mb-2">
                    <!-- $avata -->
                    <img id="avaTP" src="<?=$avata?>" alt="avatar" class="img-fluid img-card-top h-75">
                    <div class="card-body">
                        <h4 id="tenTP" class="card-title"><a href="<?=$srcHref?>"><?= $name ?></a></h4>
                        <p id="cotruongphong" style="display: none;"><?=$id?></p>
                    </div>
                    <div class="card-footer">
                        <button onclick="cachchuc(this,<?=$id_phongban?>)"  class="btn btn-dark btn-sm btn-block">Cách chức</button>
                    </div>
                </div>
            </div>
        </div>
    
        <h4 class="text-secondary mt-2 mb-3 mt-3">Danh sách nhân viên phòng <?=$phongban?></h4>
        <hr>
        <div id="listNV_phongban_X" class="row justify-content-center">
            <?php
               
                foreach ($accounts as $row){
                    $id = $row['id'];
                    $name = $row['name'];
                    $chucvu = $row['chucvu'];
                    $avata = $row['avata'];
                    if (empty($avata)){
                        if ($row['gioitinh'] ==='Nam'){
                            $avata = '/img/img_avatar.png';
                        }else{
                            $avata = '/img/avatar.png';
                        }
                    }
                    $srcHref = '/Account/profile.php?id='.$id;
                    $divid = 'cardNV' . $id;
                    if ($id === $idTruongphong){
                        $display = 'none';
                    }else $display = '';
                ?>
                    <div class="col-sm-10 col-lg-3 col-xl-3 py-1" id="<?=$divid?>" style="display: <?=$display?>;">
                        <div class="card h-100 mb-2">
                            <!-- $avata -->
                            <img src="<?=$avata?>" alt="avatar" class="img-fluid img-card-top h-75">
                            <div class="card-body">
                                <h4 class="card-title"><a href="<?=$srcHref?>"><?= $name ?></a></h4>
                                <p class="card-text">
                                    Chức vụ: <?= $chucvu ?>
                                </p>
                                <span style="display: none;"><?=$id?></span>
                            </div>
                            <div class="card-footer">
                                <button onclick="thangchuc(this,<?=$id_phongban?>)" class="btn btn-primary btn-sm btn-block">Bổ nhiệm trưởng phòng</button>
                            </div>
                        </div>
                    </div>
                <?php
                }
            ?>
        </div>
        
    </div>
    <br>
    <br>
    <div class="modal fade" id="chonTruongphongMODAL">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thay đổi chức vụ tại phòng ban</h4>
                    <Button type="button" class="close" data-dismiss='modal'>&times;</Button>
                </div>
                <div class="modal-body">
                    <p id="tb_doitruongphong">Đã cập nhật lại nhân sự của <strong><?=$phongban?></strong></p>
                </div>
                    <div class="modal-footer">
                        <button id="btn_thangchuc" style="display: none;" type="submit" class="btn btn-danger">Bổ nhiệm</button>
                        <button id="btn_cachchuc" stylte="display: none;" type="submit" class="btn btn-danger">Cách chức</button>
                        <button class="btn btn-info" data-dismiss="modal">Thoát</button>
                    </div>
            </div>
        </div>
    </div>
   
</body>