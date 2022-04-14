<?php
     if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST['danhgia']) && !empty($_POST['idTask'])){
            $idTask = $_POST['idTask'];
            $timesubmit = date("Y-m-d H:i:s");
            $danhgia = $_POST['danhgia'];
            $tp_nv = 1;
            $noidung = 'Hoàn thành ở mức: '.$danhgia;
            $dungthoihan = $_POST['dungthoihan'];
            $dealine = $_POST['dealine'];
            
            require_once('../conndb.php');
            $sql = 'INSERT INTO chitiettask(idTask,noidung,timesubmit,dealine,tp_nv) VALUES (?,?,?,?,?)';
            $stm = $conn->prepare($sql);
            $stm->bind_param('issss',$idTask,$noidung,$timesubmit,$dealine,$tp_nv);
            if ($stm->execute()){
               
                $sql = 'UPDATE task SET danhgia = ?, dungthoihan = ?, trangthai = ?, ngaythaydoi = ? WHERE id = ?';
                $stm = $conn->prepare($sql);
                $trangthai = 'Completed';
                $stm->bind_param('ssssi',$danhgia,$dungthoihan,$trangthai,$timesubmit,$idTask);
                $stm->execute();
            }

        }
     }
     header('Location: /Truongphong/')
?>