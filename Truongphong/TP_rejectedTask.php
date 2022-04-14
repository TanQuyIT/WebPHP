<?php
     if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST['nhanxet']) && !empty($_POST['idTask'])){
            $idTask = $_POST['idTask'];
            $noidung = $_POST['nhanxet'];
            $timesubmit = date('Y-m-d H:i:s');
            $dealine = $_POST['dealine'];
            $tp_nv = $_POST['tp_nv'];
            if ($_FILES['TPfile']['error'] != UPLOAD_ERR_OK){
                $namefile = '';
                $srcfile = '#';
            }else{
                $f = $_FILES['TPfile'];
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
                $sql = 'UPDATE task SET trangthai = ?,dealine = ?, ngaythaydoi = ? WHERE id = ?';
                $stm = $conn->prepare($sql);
                $trangthai = 'Rejected';
                $stm->bind_param('sssi',$trangthai,$dealine,$timesubmit,$idTask);
                $stm->execute();
            }

        }
     }
     header('Location: /Truongphong/')
?>