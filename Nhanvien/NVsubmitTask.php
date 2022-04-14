<?php
     if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST['noidung']) && !empty($_POST['id'])){
            $idTask = $_POST['id'];
            $noidung = $_POST['noidung'];
            $timesubmit = date('Y-m-d H:i:s');
            $dealine = $_POST['dealine'];
            $tp_nv = $_POST['tp_nv'];
            if (!isset($_FILES['NV_file'])){
                $namefile = '';
                $srcfile = '#';
            }else{
                $f = $_FILES['NV_file'];
                $tmp = $f['tmp_name'];
                $namefile = $f['name'];

                $sizefile = $f['size'];
                $ext = pathinfo($namefile,PATHINFO_EXTENSION);

                if ($sizefile > 500*1024*1024){
                    die();//'Kích thước file vượt quá <b>500M';
                }elseif(in_array($ext,['exe','msi','sh'])){
                    die();// 'Các tập tin thực thi không được phép upload';
                }
                $namefile = time().$namefile;
                $srcfile = $_SERVER['DOCUMENT_ROOT'] .'/Truongphong/UploadFile/'.$namefile;
            }
            require_once('../conndb.php');
            $sql = 'INSERT INTO chitiettask(idTask,noidung,timesubmit,dealine,file,tp_nv) VALUES (?,?,?,?,?,?)';
            $stm = $conn->prepare($sql);
            $stm->bind_param('isssss',$idTask,$noidung,$timesubmit,$dealine,$namefile,$tp_nv);
            if ($stm->execute()){
                if ($srcfile != '#'){
                    move_uploaded_file($tmp,$srcfile);
                }
                $sql = 'UPDATE task SET trangthai = ?, ngaythaydoi = ? WHERE id = ?';
                $stm = $conn->prepare($sql);
                $trangthai = 'Waiting';
                $stm->bind_param('ssi',$trangthai,$timesubmit,$idTask);
                $stm->execute();
            }
        }
    }else{
        header('Location: /login.php');
    }
    
?>