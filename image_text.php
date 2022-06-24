<?php
include_once "base.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文字圖形處理練習</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #uploadForm{
            width:400px;
            margin:1rem auto;
            font-size:1.25rem;
            padding:1rem;
        }
        #list{
            border-collapse: collapse;
            box-shadow: 0 0 10px #ccc;
            margin:1rem auto;
        }
        #list img{
            width:150px;
        }
        #list td,#list th{
            border:1px solid #ccc;
            padding:0.5rem 1.1rem;
            font-size:1.15rem;
        }
        #list tr:hover{
            background:lightgreen;
            transform: scale(1.1);
        }
    </style>
</head>
<body>
<h1 class="header">文字圖形處理練習</h1>
<!---建立檔案上傳機制--->

<form id="uploadForm" action="?" method="post" enctype="multipart/form-data">
    <div>
        長度: <input type="number" name="length" value="<?=rand(4,8);?>">
    </div>
    <div>
        <input type="number" step="1" name="size" value="24">
    </div>   
    <div>
        <select name="color" >
            <option value="blue">藍色</option>
            <option value="red">紅色</option>
            <option value="green">綠色</option>
        </select>
    </div>   
    <input type="submit" value="產生驗證碼">
</form>


<?php
if(isset($_POST)){
    //$gstr=chr(rand(65,90));
    $gstr="";
    for($i=0;$i<$_POST['length'];$i++){
        $type=rand(1,3);
        switch($type){
            case 1:
                //數字
                $gstr.=rand(0,9);
            break;
            case 2:
                //大寫
                $gstr.=chr(rand(65,90));
            break;
            case 3:
                //小寫
                $gstr.=chr(rand(97,122));
            break;
        }
    }
    $color=$_POST['color'];
    $dst_width=300;
    $dst_height=200;
    $dst_img=imagecreatetruecolor($dst_width,$dst_height);
    $white=imagecolorallocate($dst_img,255,255,255);
    $black=imagecolorallocate($dst_img,0,0,0);
    $blue=imagecolorallocate($dst_img,0,0,255);
    $red=imagecolorallocate($dst_img,255,0,0);
    $green=imagecolorallocate($dst_img,0,255,0);
    imagefill($dst_img,0,0,$white);

    //評估文字資訊
    $text_info=imagettfbbox($_POST['size'],0,realpath('./font/arial.ttf'),$gstr);
    
    $dst_x=0-$text_info[6];
    $dst_y=0-$text_info[7];


    imagettftext($dst_img,$_POST['size'],0,$dst_x,$dst_y,$$color,realpath('./font/arial.ttf'),$gstr);
    imagejpeg($dst_img,"./upload/text.jpg",100);
    imagedestroy($dst_img);

}
?>
<div style="width:500px;margin:auto;">
    <h2>加入文字後的圖形</h2>
    <img src="./upload/text.jpg" alt="" style="border:2px solid black">
</div>

</body>
</html>