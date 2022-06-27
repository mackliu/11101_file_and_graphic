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
        <div>
            <form action="?" method="get">
                <?php
                session_start();
                if(isset($_GET['check'])){
                    if($_SESSION['check']==$_GET['check']){
                        echo "驗證正確<br>";
                        echo "session:".$_SESSION['check']."<br>";
                        echo "get:".$_GET['check']."<br>";
                    }else{
                        echo "驗證錯誤<br>";
                        echo "session:".$_SESSION['check']."<br>";
                        echo "get:".$_GET['check']."<br>";
                    }
                }


                $_SESSION['check']=code(5);
                ?>
                請輸入驗證碼: <input type="text" name="check" >
                
                <input type="submit" value="檢查">
                <div><?=$_SESSION['check'];?></div>
            </form>
        </div>

        <!--使用按鈕每次點擊時重整頁面來重新產生圖形驗證碼-->
        <!-- <button onclick="location.reload()" class='btn'>產生驗證碼</button> -->
        <div class="captcha">
            <img src="<?=captcha($_SESSION['check']);?>">
        </div>
    </div>

</body>

</html>