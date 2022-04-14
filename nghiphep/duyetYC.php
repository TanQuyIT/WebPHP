<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST['idYC']) && !empty($_POST['idNV']) && !empty($_POST['stt'])){
            $idYC = $_POST['idYC'];
            $idNV = $_POST['idNV'];
            $songaynghi = $_POST['songay'];
            $stt = $_POST['stt'];
            //die($songaynghi);
            require_once('../conndb.php');
            $sql = 'UPDATE nghiphep SET trangthai = ? WHERE id = ?';
            $stm = $conn->prepare($sql);
            $stm->bind_param('si',$stt,$idYC);
            if ($stm->execute()){
                $now = date('Y-m-d H:i:s');
                $sql = 'UPDATE account SET songaynghi = songaynghi + ?, ngayxinphep = ? WHERE id = ?';
                $stm = $conn->prepare($sql);
                $stm->bind_param('isi',$songaynghi,$now,$idNV);
                $stm->execute();
            }
        }
    }
    else{
        header('Location: /login.php');
    }
?>