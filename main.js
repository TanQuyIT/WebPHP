//index.php main 
//Đổi ảnh đại diện
function doiavatar(input,user){
    input.click();
    $('#input_avatar').on('change',function(e){
        let myfile = e.target.files[0];
        //ktra file 
        //ktra size

        let f_name = myfile['name'];
        let ext = f_name.split('.').pop();
        if (!['jpg','png'].includes(ext)){
            $('#tb_doiAVATAR_k_thanhcong1').fadeIn(0,()=>{$('#tb_doiAVATAR_k_thanhcong1').fadeOut(5000)}) 
            return;
        }

        if (myfile['size'] > 500*1024*1024){
            $('#tb_doiAVATAR_k_thanhcong2').fadeIn(0,()=>{$('#tb_doiAVATAR_k_thanhcong2').fadeOut(5000)}) 
            return;
        }

        let data = new FormData();
        data.append('file',myfile);
        
        data.append('user',user);

        let xhr = new XMLHttpRequest();

        xhr.onload = function(){
            res = xhr.responseText;
			res = JSON.parse(res)
            if (res.code === 0){
                window.location.reload(true);
            }
        }

        xhr.open('POST','/Nhanvien/upAvatar.php',true);
        xhr.send(data);
    })
}





//Account/profile.php
// hiện modal
function showDLMK(){
    $('#profile_doimk').modal('show');
    document.getElementById('datlai_mk').onclick = function(e){
        e.preventDefault();
        let user = document.getElementById('Datlai_mk_user_val').value;
        let data = new FormData();
        data.append('user',user);
        
        const xhr = new XMLHttpRequest();

        xhr.onload = function(){
            $('#profile_doimk').modal('hide');
            $('#tb_datlai_mk_thanhcong').fadeIn(0,()=>{$('#tb_datlai_mk_thanhcong').fadeOut(5000)}) 
        }
        xhr.onerror = function(){
            $('#profile_doimk').modal('hide');
            $('#tb_datlai_mk_k_thanhcong').fadeIn(0,()=>{$('#tb_datlai_mk_k_thanhcong').fadeOut(5000)})
        }
        xhr.open('POST','/Account/resetPassword.php',true);
        xhr.send(data);
    }
}




// Nhanvien/getTaskNV.php
// click Start/Nộp báo cáo btn

function btn_NVtask(btn,stt,id){
    //console.log('click start');
   // console.log(btn.innerHTML,'  ',stt,'   ',id);
    if (btn.innerHTML == 'Start'){
        stt = 'In progress';
        document.querySelector('#sttTaskNV').innerHTML = stt;
        const xhr = new XMLHttpRequest();
        
        let data = new FormData();
        data.append('id',id);
        data.append('trangthai',stt);
        data.append('tp_nv',0)
        xhr.open('POST','/Truongphong/change_sttTask.php',true);
        xhr.send(data);
        btn.innerHTML = 'Báo cáo kết quả';
    }else{
        $('#getTaskNV_MODAL').modal('show');
        $("#NV_file").on("change", function() {
            let fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

    }
 
}

//submit MODAL
function NVsubmitTask(id,dealine){
    //console.log('submit');
    noidung = document.getElementById('noidungBC_nv').value;
    
    if (noidung.length === 0){
        document.getElementById('errNV_submit').style.display = '';
        return;
    }
    let data = new FormData();
    data.append('id',id);
    data.append('noidung',noidung);
    data.append('dealine',dealine);
    data.append('tp_nv',0);
    //f = '';
    if (document.getElementById('NV_file').files.length){
        f = document.getElementById('NV_file').files[0];
        let f_name = f['name'];
        let ext = f_name.split('.').pop();
        if (['exe','sh'].includes(ext)){
            document.getElementById('errNV_submit').innerHTML = 'Các tập tin thực thi không được chấp nhận';
            document.getElementById('errNV_submit').style.display = '';
            return;
        }
        
        if (f['size'] > 500*1024*1024){
            document.getElementById('errNV_submit').innerHTML = 'Kích thước tập tin quá lớn';
            document.getElementById('errNV_submit').style.display = '';
            return;
        }
        data.append('NV_file',f);
    }
    let xhr = new XMLHttpRequest();

 

    xhr.onload = function(){
        //console.log('submited');
        document.getElementById('errNV_submit').style.display = 'none';
        btn = document.getElementById('nvbtn');
        btn.style.display = 'none';
        document.querySelector('#sttTaskNV').innerHTML = 'Waiting';
        $('#getTaskNV_MODAL').modal('hide');
        window.location.reload()
    }

    xhr.open('POST','/Nhanvien/NVsubmitTask.php',true);
    xhr.send(data);

}

//Truongphong
//truongphong/getTaskTP.php
function btnTPhuyTaskMODAL(id){
    $('#TpHuyTaskMODAL').modal('show');
}
function TpHuyTask(id){
    console.log(id);
    stt = 'Canceled';
    document.querySelector('#sttTaskTP').innerHTML = stt;
    document.querySelector('#btnTphuytask').style.display = 'none';
    $('#TpHuyTaskMODAL').modal('hide');
    const xhr = new XMLHttpRequest();
    let data = new FormData();
    data.append('id',id);
    data.append('tp_nv',1)
    data.append('trangthai',stt);
    
    xhr.open('POST','change_sttTask.php',true);
    xhr.send(data);
}
//Truongphong
//truongphong/getTaskTP.php
function btnRejected(){
    $('#TpRejectedMODAL').modal('show');
    $("#TPfile").on("change", function() {
        let fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
}
//Truongphong
//truongphong/getTaskTP.php
function btnCompleted(){
    $('#TpCompletedTaskMODAL').modal('show');
}
    

//phongban/chonTruongphong.php
//modal chonTruongphong.php
function cachchuc(it,id_phongban){

    $('#btn_thangchuc').hide();
    if ($('#cotruongphong').text() === '-1'){
        document.querySelector('#tb_doitruongphong').innerHTML = 'Hiện tại không có trưởng phòng';
        $('#btn_cachchuc').hide();
        $('#chonTruongphongMODAL').modal('show');
    }else{
        $('#btn_cachchuc').show();

        let card = it.parentElement.parentElement;
        let name = document.getElementById('tenTP').innerHTML;
        let id = document.getElementById('cotruongphong').innerHTML;

        document.querySelector('#tb_doitruongphong').innerHTML = 'Có chắc bạn muốn cách chức trưởng phòng của ' + '<strong>'+name+'</strong>';
        $('#chonTruongphongMODAL').modal('show');

        document.getElementById('btn_cachchuc').onclick = function(){
            cachchucFunc(id_phongban,id);    
        }
       
    }
}

function cachchucFunc(id_phongban,id){
    if (id_phongban === '' || id === ''){
        return 
    } 

    fetch('/Phongban/cachchuc.php',{
        method: 'POST',
        Headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_phongban: id_phongban,
            id: id
        })
    })
    .then(function(res){

        s = '#cardNV' + id;
        document.querySelector(s).getElementsByTagName('p')[0].innerHTML = 'Chức vụ: Nhân viên';
        document.querySelector(s).style.display = "";


        document.getElementById('avaTP').src='';
        document.getElementById('tenTP').innerHTML = '<a href="#">Chưa có trưởng phòng</a>'
        document.getElementById('cotruongphong').innerHTML = -1;
        $('#chonTruongphongMODAL').modal('hide');
    })
}

//phongban/chonTruongphong.php
//modal chonTruongphong.php
function thangchuc(it,id_phongban){
    $('#btn_cachchuc').hide();
    $('#btn_thangchuc').show();

    
    let card = it.parentElement.parentElement.parentElement;
    let name = card.getElementsByTagName('a')[0].innerHTML;
    let id = card.getElementsByTagName('span')[0].innerHTML
    if($('#cotruongphong').text() != '-1'){
        document.querySelector('#tb_doitruongphong').innerHTML = 'Phòng ban hiện tại đã có trưởng phòng! <br>Có chắc bạn muốn <strong>thăng chức</strong> ' +'cho '+ '<strong>'+name+'</strong> làm trưởng phòng mới? <br>Lúc đó trưởng phòng hiện tại sẽ trở thành nhân viên.';
        
        $('#chonTruongphongMODAL').modal('show');
        let idTP = document.getElementById('cotruongphong').innerHTML;
        document.getElementById('btn_thangchuc').onclick = function(){
            cachchucFunc(id_phongban,idTP);
            thangchucFunc(id_phongban,id,name);
        }
        
    }else{
        document.querySelector('#tb_doitruongphong').innerHTML = 'Có chắc bạn muốn <strong>thăng chức</strong> ' +'cho '+ '<strong>'+name+'</strong> làm trưởng phòng? ';
        $('#chonTruongphongMODAL').modal('show');

        document.getElementById('btn_thangchuc').onclick = function(){
            thangchucFunc(id_phongban,id,name);
        }

    }

   
}

function thangchucFunc(id_phongban,id,name){

    fetch('/Phongban/thangchuc.php',{
        method: 'POST',
        Headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_phongban: id_phongban,
            id: id,
            name: name
        })
    })
    .then(function(res){
        
        let s = '#cardNV' + id;
        let card = document.querySelector(s)
        let img = card.getElementsByTagName('img')[0];
        let h4 = card.getElementsByTagName('h4')[0];

        document.getElementById('avaTP').src = img.src;
        document.getElementById('tenTP').innerHTML = h4.innerHTML;
        document.getElementById('cotruongphong').innerHTML = id;
        card.style.display = "none";
        
        $('#chonTruongphongMODAL').modal('hide');

    })

}



// Truongphong/addTask.php
// upfile Truongphong/addTask.php
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});


//Truongphong/getTaskTP.php
//download file getTaskTP.php to downloadFile.php
function TPsend_down(it){
    const xhr = new XMLHttpRequest();
    let data = new FormData();
    data.append('name_down',it);

    xhr.onload = function(res,data){
      // console.log(res,data);
    }

    xhr.open('POST','/Truongphong/downloadFile.php',true);
    xhr.send(data);
}


// tooltip
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});


//nghiphep
//nghiphep/creatYC.php
//upfile

//nghiphep/getYC.php
function showDYmodal(){
    $('#dongyYC').modal('show');
}

function showKDYmodal(){
    $('#kdongyYC').modal('show');
}


function duyetYC(idYC,idNV,songay,stt){
    // console.log(idYC,' x',idNV,' x',songay,'x ',stt)
    const xhr = new XMLHttpRequest();
    let data = new FormData();
    data.append('idYC',idYC);
    data.append('idNV',idNV);
    data.append('songay',songay);
    data.append('stt',stt);

    xhr.onload = function(){
        $('#dongyYC').modal('hide');
        $('#kdongyYC').modal('hide');
        document.getElementById('sttYC').innerHTML = stt;
        document.getElementById('btn_duyet').style.display = 'none';
    }
    //console.log(document.getElementById('btn_duyet'))

    xhr.open('POST','/nghiphep/duyetYC.php',true);
    xhr.send(data);
}


// Truongphong/addTask.php
// upfile Truongphong/addTask.php
$(".custom-file-input").on("change", function() {
    let fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});