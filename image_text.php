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
                $gstr.=rand(0,9);//數字
            break;
            case 2:
                $gstr.=chr(rand(65,90));//大寫
            break;
            case 3:
                $gstr.=chr(rand(97,122));//小寫
            break;
        }
    }
    $color=$_POST['color'];


    //評估文字資訊
    $text_info=[];
    $dst_w=0;
    $dst_h=0;
    for($i=0;$i<mb_strlen($gstr);$i++){
        $char=mb_substr($gstr,$i,1);
        $tmp=imagettfbbox($_POST['size'],0,realpath('./font/arial.ttf'),$char);
        $text_info[$char]['width']=max($tmp[0],$tmp[2],$tmp[4],$tmp[6])-min($tmp[0],$tmp[2],$tmp[4],$tmp[6]);
        $text_info[$char]['height']=max($tmp[1],$tmp[3],$tmp[5],$tmp[7])-min($tmp[1],$tmp[3],$tmp[5],$tmp[7]);
        $dst_w+=$text_info[$char]['width'];
        $dst_h=($dst_h>=$text_info[$char]['height'])?$dst_h:$text_info[$char]['height'];
        $text_info[$char]['x']=0-min($tmp[0],$tmp[2],$tmp[4],$tmp[6]);
        $text_info[$char]['y']=0-min($tmp[1],$tmp[3],$tmp[5],$tmp[7]);
    }
    //dd($text_info);
    //exit();
    
    
    $border=10;
    $base_w=$dst_w+($border*2);
    $base_h=$dst_h+($border*2);
    $dst_img=imagecreatetruecolor($base_w,$base_h);

    //顏色定義區
    $white=imagecolorallocate($dst_img,255,255,255);
    $black=imagecolorallocate($dst_img,0,0,0);
    $blue=imagecolorallocate($dst_img,0,0,255);
    $red=imagecolorallocate($dst_img,255,0,0);
    $green=imagecolorallocate($dst_img,0,255,0);
    $colors=[imagecolorallocate($dst_img,0,0,255),
             imagecolorallocate($dst_img,0,255,0),
             imagecolorallocate($dst_img,255,0,0),
             imagecolorallocate($dst_img,20,100,255),
             imagecolorallocate($dst_img,200,100,155),
             imagecolorallocate($dst_img,100,250,55),
             imagecolorallocate($dst_img,156,20,90),
            ];
    imagefill($dst_img,0,0,$white);

    $x_pointer=$border+1;
    $y_pointer=$border+1;
    foreach($text_info as $char => $info){
        imagettftext($dst_img,$_POST['size'],0,$x_pointer,$y_pointer+$info['y'],$colors[rand(0,6)],realpath('./font/arial.ttf'),$char);
        $x_pointer+=$info['width'];
    }

    $lines=rand(3,6);

    for($i=0;$i<$lines;$i++){
        $left_x=rand(5,$border-5);
        $left_y=rand(5,$base_h-5);
        $right_x=rand($base_w-$border+5,$base_w-5);
        $right_y=rand(5,$base_h-5);
        imageline($dst_img,$left_x,$left_y,$right_x,$right_y,$colors[rand(0,6)]);
    }

    imagejpeg($dst_img,"./upload/text.jpg",100);
    imagedestroy($dst_img);

}
?>
<div style="width:500px;margin:auto;">
    <h2>加入文字後的圖形<?=$_POST['length']."碼";?>-<?=$lines."線";?></h2>
    <img src="./upload/text.jpg" alt="" style="border:2px solid black">
</div>

</body>
</html>