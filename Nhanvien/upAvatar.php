<?php 
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');

    function error_response($code, $message){
        $res = array();
        $res['code'] = $code;
        $res['message'] = $message;
        die(json_encode($res));
    }

    function success_response($data, $message){
        $res = array();
        $res['code'] = 0;
        $res['message'] = $message;
        $res['data'] = $data;
        die(json_encode($res));
    }

    if (!empty($_FILES['file']) && !empty($_POST['user'])){
        $f = $_FILES['file'];
        $name = $f['name'];
        $size = $f['size'];
        $tmp = $f['tmp_name'];
        $type = $f['type'];
        $ext = pathinfo($name,PATHINFO_EXTENSION);
        $path = getcwd();
        if (!empty($_POST['name'])){
            $f['name'] = $_POST['name'] . '.' . $ext;
            $name = $f['name'];
        }
        $user = $_POST['user'];
        $pathup = $path .'/'.'Avatars'. '/' . $user.".".$ext;
        
        if ($size > 500*1024*1024){
            error_response(1,'Kích thước file không được vượt quá <b>500M');
        }elseif(!in_array($ext,['jpg','png'])){
            error_response(2,'Chỉ upload các file ảnh');
        }
    }
    else {
        error_response(3,'Vui lòng chọn ảnh cần upload');
        header('Location: /login.php');
    }

    move_uploaded_file($tmp,$pathup);
    require_once('../conndb.php');
    $sql = 'UPDATE account SET avata = ? WHERE user = ?';
    $stm = $conn->prepare($sql);
    $ava = '/Nhanvien/Avatars/'. $user.".".$ext;
    $stm->bind_param('ss',$ava,$user);
    $stm->execute(); 

    success_response($ava,'Thành công! Ảnh đã được upload');
    header('Location: /login.php');
?>