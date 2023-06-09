<?php use Hekmatinasser\Verta\Verta; ?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <link href="favicon.png" rel="shortcut icon" type="image/png">

    <link rel="stylesheet" href="assets/css/styles.css<?="?v=" . rand(99, 9999999)?>" />
    <style>

    body{
        background:#f2f2f2;
    }
    a{
        text-decoration: none;
    }
    h1{
        text-align: center;
    }

    .main-panel{
        width:1000px;
        margin:30px auto;
    }
    .box {
        background: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0px 3px 3px #EEE;
        margin-bottom: 20px;
    }
    table.tabe-locations {
        width: 100%;
        border-collapse: collapse;
    }
    .statusToggle {
        background: #eee;
        color: #686868;
        border: 0;
        padding: 3px 12px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 400;
        font-family: iransans;
        display:inline-block;
        margin:0 3px;
    }
    .statusToggle.active {
        background: #0c8f10;
        color: #ffffff;
    }
    .statusToggle:hover,button.preview:hover {
        opacity: 0.7;
    }
    button.preview {
        padding: 0 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }
    tr {
        line-height: 36px;
    }
    tr:nth-child(2n) {
        background:#f7f7f7;
    }
    td{
        padding:0 5px;
    }
    iframe#mapWivdow {
        width: 100%;
        height: 500px;
    }
    .text-center{
        text-align: center;
    }
    </style>

    
</head>
<body>
    <div class="main-panel">
        <h1>پنل مدیریت </h1>
        <div class="box">
            <a class="statusToggle" href="" target="_blank">🏠</a>
            <a class="statusToggle active" href="adm.php">همه</a>
            <a class="statusToggle active" href="?status=1">فعال</a>
            <a class="statusToggle" href="?status=0">غیرفعال</a>
            <a class="statusToggle" href="?logout=1"  style="float:left">خروج</a>
        </div>
        <div class="box">
        <table class="tabe-locations">
        <thead>
        <tr>
        <th style="width:40%">عنوان مکان</th>
        <th style="width:15%" class="text-center">تاریخ ثبت</th>
        <th style="width:10%" class="text-center">lat</th>
        <th style="width:10%" class="text-center">lng</th>
        <th style="width:25%">وضعیت</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($locations as $locate): ?>
        <tr>
            <td><?=$locate->title ?></td>
            <td class="text-center"><?= Verta::instance($locate->created_at) ?></td>
            <td class="text-center"><?=$locate->lat ?></td>
            <td class="text-center"><?=$locate->lng ?></td>
            <td>
                <button class="statusToggle <?=$locate->status ?'active':'' ?>" data-loc='<?=$locate->id ?>'>

                تایید
            
                </button> 
                <button class="preview" data-loc='<?=$locate->id ?>'>👁️‍🗨️</button> 
            </td>
        </tr>
<?php endforeach; ?>        
        </tbody>
        </table>
        </div>

    </div>

    <div class="modal-overlay" style="display: none; position: absolute;width: 60%; top:10%; left:30%;">
        <div class="modal">
            <span class="close" style="cursor: pointer; font-size: 30px; color: red;">x</span>
            <div class="modal-content">
                <iframe id='mapWivdow' src="#" frameborder="0"></iframe>
            </div>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

$(document).ready(function () {

$('.preview').click(function (e) { 
    e.preventDefault();
    $('.modal-overlay').fadeIn();
    $('#mapWivdow').attr('src','<?=URI_BASE?>'+ "?loc=" + $(this).attr('data-loc'));
});

$('.modal-overlay .close').click(function (e) { 
    e.preventDefault();
    $('.modal-overlay').fadeOut();
    
});

$('.statusToggle').click(function (e) { 
    e.preventDefault();
    var btn=$(this);
    const locid=$(this).attr('data-loc');

    $.ajax({
        url: "process/updatestatus.php",
        method:'POST',
        data: {loc:locid},
        success: function (response) {

            if(response == 1){

                btn.toggleClass('active');


            }
            
        }
    });
    
});






});

    </script>

</body>
</html>
