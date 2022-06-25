<?php
include_once "verification_code.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>圖形驗證碼練習</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .wrapper{
            width:400px;
            margin:2rem auto;
            padding:1rem;
            text-align: center;
        }
        .btn{
            padding:0.5rem 1.5rem;
            border-radius:0.5rem;
            margin:1rem 0;
        }
        .captcha img{
            border:2px solid black;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h1 class="header">圖形驗證碼練習</h1>

        <!--使用按鈕每次點擊時重整頁面來重新產生圖形驗證碼-->
        <button onclick="location.reload()" class='btn'>產生驗證碼</button>
        <div class="captcha">
            <img src="<?=captcha(code());?>">
        </div>
    </div>

</body>

</html>