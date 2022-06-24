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
        選擇檔案:<input type="text" name="string" value="ABC">
    </div>
    <div>
        <input type="number" step="1" name="size" value="1">
    </div>   
    <div>
        <select name="color" >
            <option value="blue">藍色</option>
            <option value="red">紅色</option>
            <option value="green">綠色</option>
        </select>
    </div>   
    <input type="submit" value="上傳">
</form>


<?php
if(isset($_POST['string'])){
    
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
    imagestring($dst_img,$_POST['size'] ,20,20,$_POST['string'],$$color);
    imagejpeg($dst_img,"./upload/text.jpg",100);
    imagedestroy($dst_img);

}
?>
<div style="width:500px;margin:auto;">
    <h2>加入文字後的圖形</h2>
    <img src="./upload/text.jpg" alt="">
</div>

</body>
</html>