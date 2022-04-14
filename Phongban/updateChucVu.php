<?php
    // session_start();
    // if ($_SESSION['account']['chucvu'] != 'Giám đốc'){
    //     header('Location: /login.php');
    //     die();
    // } 
 
    function cachchuc($id_phongban){
        require_once('../conndb.php');
        
        $sql = 'SELECT * FROM phongban WHERE id = ?';
        $stm = $conn->prepare($sql);
        $stm->bind_param('i',$id_phongban);
        $stm->execute(); 

        $data = $stm->get_result();
        if ($data->num_rows === 1){
            $data = $data->fetch_assoc();
            $id = $data['idTruongphong'];

            $sql = 'UPDATE account SET chucvu = ? WHERE id = ?';
            $stm = $conn->prepare($sql);
            $cv = 'Nhân viên';
            $stm->bind_param('si',$cv,$id);
            $stm->execute(); 
        }


        $sql = 'UPDATE phongban SET truongphong = ?, idTruongphong = ? WHERE id = ?';
        $stm = $conn->prepare($sql);
        $cv = null;
        $idtp = null;
        $stm->bind_param('sii',$cv,$idtp,$id_phongban);
        $stm->execute();
        return $stm->affected_rows === 1;
    }

    function thangchuc($id_phongban,$idTp,$name){
        require_once('../conndb.php');

        $sql = 'SELECT * FROM phongban WHERE id = ?';
        $stm = $conn->prepare($sql);
        $stm->bind_param('i',$id_phongban);
        $stm->execute(); 
        $data = $stm->get_result();
        if ($data->num_rows === 1){
            $data = $data->fetch_assoc();
            $id = $data['idTruongphong'];

            $sql = 'UPDATE account SET chucvu = ? WHERE id = ?';
            $stm = $conn->prepare($sql);
            $cv = 'Nhân viên';
            $stm->bind_param('si',$cv,$id);
            $stm->execute(); 
        }


        $sql = 'UPDATE phongban SET truongphong = ?, idTruongphong = ? WHERE id = ?';
        $stm = $conn->prepare($sql);
        $stm->bind_param('sii',$name,$idTp,$id_phongban);

        $bol = $stm->execute();
        if ($bol){
            $sql = 'UPDATE account SET chucvu = ? WHERE id = ?';
            $stm = $conn->prepare($sql);
            $cv = 'Trưởng phòng';
            $stm->bind_param('si',$cv,$idTp);
            $stm->execute(); 
        }
        
        return $stm->affected_rows === 1;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Web không tồn tại</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container m-auto" style="padding-top: 50px;" >

        <h3>Trang web không thể truy cập được</h3>
        <a href="index.php" class="btn btn-primary">Quay lại</a>
    </div>
</body>
</html>