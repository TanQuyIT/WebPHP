<?php
    if (!empty($_POST['id']) && !empty($_POST['trangthai'])){
        $id = (int)$_POST['id'];
        $trangthai = $_POST['trangthai'];
        require_once('../conndb.php');
        $sql = 'SELECT trangthai,dealine FROM task WHERE id = ?';
        
        $stm = $conn->prepare($sql);
        $stm->bind_param('i',$id);
        $stm->execute();
        $now = date('Y-m-d H:i:s');
        $tp_nv = $_POST['tp_nv'];
        $noidung = $trangthai;

        $data = $stm->get_result()->fetch_assoc();

        $trangthaicu = $data['trangthai'];
        $dealine = $data['dealine'];

        if ($trangthaicu ==='Canceled' || $trangthaicu === 'Completed'){
            die();
        }elseif ($trangthaicu === 'New'){
            if ($trangthai === 'In progress' || $trangthai === 'Canceled'){
                require_once('../conndb.php');

                $sql = 'UPDATE task SET trangthai = ?,ngaythaydoi = ? WHERE id = ?';
        
                $stm = $conn->prepare($sql);
                $stm->bind_param('ssi',$trangthai,$now,$id);
                $stm->execute();
                
                $sql = 'INSERT INTO chitiettask(idTask,noidung,timesubmit,dealine,tp_nv) VALUES (?,?,?,?,?)';
                $stm = $conn->prepare($sql);
                $stm->bind_param('isssi',$id,$noidung,$now,$dealine,$tp_nv);

                $stm->execute();

            }else{
                die();
            }
        }elseif ($trangthaicu === 'In progress' || $trangthaicu === 'Rejected'){
            if ($trangthai ==='Waiting'){
                require_once('../conndb.php');

                $sql = 'UPDATE task SET trangthai = ?,ngaythaydoi = ? WHERE id = ?';
        
                $stm = $conn->prepare($sql);
                $stm->bind_param('ssi',$trangthai,$now,$id);
                $stm->execute();
                
                $sql = 'INSERT INTO chitiettask(idTask,noidung,timesubmit,dealine,tp_nv) VALUES (?,?,?,?,?)';
                $stm = $conn->prepare($sql);
                $stm->bind_param('isssi',$id,$noidung,$now,$dealine,$tp_nv);

                $stm->execute();

            }else{
                die();
            }
        }elseif ($trangthaicu ==='Waiting'){
            if ($trangthai === 'Rejected'  || $trangthai==='Completed'){
                require_once('../conndb.php');

                $sql = 'UPDATE task SET trangthai = ?,ngaythaydoi = ? WHERE id = ?';
        
                $stm = $conn->prepare($sql);
                $stm->bind_param('ssi',$trangthai,$now,$id);
                $stm->execute();
                
                $sql = 'INSERT INTO chitiettask(idTask,noidung,timesubmit,dealine,tp_nv) VALUES (?,?,?,?,?)';
                $stm = $conn->prepare($sql);
                $stm->bind_param('isssi',$id,$noidung,$now,$dealine,$tp_nv);

                $stm->execute();

            }else{
                die();
            }
        }

    }else{
        header('Location: /login.php');
    }

   
?>