<?php
session_start();
$user="root";
$pass="фуашу2УЗ";
$host = "127.0.0.1";
$port = 3306;
$db = "ww";
$link = mysqli_connect($host, $user, $pass, $db, $port);
if (!$link) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
$ssilkanaglav="<div class='wwheader'>"."<img src='"."/site/siteimages/war_07.jpg"."'>"."<img src='"."/site/siteimages/war_08.jpg"."'>"."<img src='"."/site/siteimages/war_09.gif"."'>"."<img src='"."/site/siteimages/war_10.gif"."'>"."<a href='"."/site/"."'><img src='"."/site/siteimages/war_11.gif"."'></a>"."<img src='"."/site/siteimages/war_12.jpg"."'>"."</div>";
$footerhtml="<footer>"."<img src='"."/site/siteimages/war_19.jpg"."'>"."<img src='"."/site/siteimages/war_20.jpg"."'>"."<img src='"."/site/siteimages/war_21.gif"."'>"."<img src='"."/site/siteimages/war_22.gif"."'>"."<img src='"."/site/siteimages/war_23.jpg"."'>"."<img src='"."/site/siteimages/war_24.jpg"."'>"."</footer>";
?>
<!DOCTYPE html>
<html>
<head>
<title>Зимняя война</title>
<link href="/site/styles.css" rel="stylesheet" />
</head>
<body>
<?php
#Разделяем запрос по слэшу
$explodeURL = explode('/',$_SERVER['REQUEST_URI']);
unset($explodeURL[1]);
$langper=$_GET['lang'];
$correctpath=trim(implode("/",$explodeURL));
if ($langper=='rus'){
    array_pop($explodeURL);
    $correctpath=trim(implode("/",$explodeURL)).'/';
}
$sql = "SELECT * FROM path WHERE p_name = '$correctpath'";
$result = mysqli_query($link,$sql);
while($ans = mysqli_fetch_assoc($result)){
    #находим id текущей страницы
    $nowc_id=end(explode(',',$ans['p_path']));

    #Создаем меню для страницы, находим в категориях все меню, для которых родитель 1, они будут в меню главными
    $menu="";
    $upmenu="";
    $undermenu="<div class='undermenu'>";
    #Создаем подменю, детей для родителей и родителей для детей
    $sql1 = "SELECT * FROM category WHERE c_parent_id = $nowc_id AND c_show_in_menu = '1' ORDER BY c_priority DESC";
    $result1 = mysqli_query($link,$sql1);
    while($ans1 = mysqli_fetch_assoc($result1)){
        $sql3 = "SELECT * FROM path";
        $result3 = mysqli_query($link,$sql3);
        while($ans3 = mysqli_fetch_assoc($result3)){
            if(end(explode(",",$ans3['p_path']))==$ans1['c_id']){
                $undermenu=$undermenu."<a href='"."/site".$ans3['p_name']."'>".$ans1['c_name_rus']."</a>"."<br/>";
            }
        }
    }
    $sql1 = "SELECT * FROM category WHERE c_id = $nowc_id AND c_parent_id != 1";
    $result1 = mysqli_query($link,$sql1);
    while($ans1 = mysqli_fetch_assoc($result1)){
        $temp = $ans1['c_parent_id'];
        $sql2 = "SELECT * FROM category WHERE c_parent_id = $temp AND c_show_in_menu = '1' ORDER BY c_priority DESC";
        $result2 = mysqli_query($link,$sql2);
        while($ans2 = mysqli_fetch_assoc($result2)){
            $sql3 = "SELECT * FROM path";
            $result3 = mysqli_query($link,$sql3);
            while($ans3 = mysqli_fetch_assoc($result3)){
                if(end(explode(",",$ans3['p_path']))==$ans2['c_id']){
                    $undermenu=$undermenu."<a href='"."/site".$ans3['p_name']."'>".$ans2['c_name_rus']."</a>"."<br/>";
                    $parent_id = $temp;
                }
            }
        }
    }
    $undermenu=$undermenu."</div>";
    $sql1 = "SELECT * FROM category WHERE c_parent_id = 1 ORDER BY c_priority DESC";
    $result1 = mysqli_query($link,$sql1);
    while($ans1 = mysqli_fetch_assoc($result1)){
        $sql2 = "SELECT * FROM path";
        $result2 = mysqli_query($link,$sql2);
        while($ans2 = mysqli_fetch_assoc($result2)){
            #находим все пути, обрабатываем те которые переходят сразу на подвкладки
            if(end(explode(",",$ans2['p_path']))==$ans1['c_id']){
                if($ans1['c_id']==7){
                    $menu=$menu."<a href='"."/site".$ans2['p_name']."A/"."'>".$ans1['c_name_rus']."</a>"."<br/>";
                }
                elseif($ans1['c_id']==9 && $parent_id!=9){
                    $menu=$menu."<a href='"."/site".$ans2['p_name']."begin/"."'>".$ans1['c_name_rus']."</a>"."<br/>";
                }
                elseif($ans1['c_id']==9 && $parent_id==9){
                    $menu=$menu."<a href='"."/site".$ans2['p_name']."begin/"."'>".$ans1['c_name_rus']."</a>".$undermenu;
                }
                elseif($ans1['c_id']==11){
                    $menu=$menu."<a href='"."/site".$ans2['p_name']."rus/A/"."'>".$ans1['c_name_rus']."</a>"."<br/>";
                }
                elseif($ans1['c_id']==4){
                    $upmenu=$upmenu."<a href='"."/site".$ans2['p_name']."'>".$ans1['c_name_rus']."</a>"."&nbsp;|&nbsp;";
                }
                elseif($ans1['c_id']==102){
                    $upmenu=$upmenu."<a href='"."/site".$ans2['p_name']."'>".$ans1['c_name_rus']."</a>"."&nbsp;|&nbsp;";
                }
                elseif($ans1['c_id']==59){
                    $upmenu=$upmenu."<a href='"."/site".$ans2['p_name']."'>".$ans1['c_name_rus']."</a>"."&nbsp;|&nbsp;";
                }
                else{
                    if($nowc_id==$ans1['c_id']){
                        $menu=$menu."<a href='"."/site".$ans2['p_name']."'>".$ans1['c_name_rus']."</a>".$undermenu;
                    }
                    elseif($parent_id==$ans1['c_id']){
                        $menu=$menu."<a href='"."/site".$ans2['p_name']."'>".$ans1['c_name_rus']."</a>".$undermenu;
                    }
                    else
                    {
                        $menu=$menu."<a href='"."/site".$ans2['p_name']."'>".$ans1['c_name_rus']."</a>"."<br/>";
                    }
                }
            }
        }
    }
    # ищем по Id информацию из article
    $sql1 = "SELECT * FROM article WHERE c_id = $nowc_id";
    $result1 = mysqli_query($link,$sql1);
    $main_text="";
    while($ans1 = mysqli_fetch_assoc($result1)){
        $main_text=$main_text.$ans1['a_text'];
    }
    if($nowc_id==62){
        $main_text="<a href='"."/site/battle/karelia/15/"."'>Боевые действия на участке 15-й армии</a></br>"."<a href='"."/site/battle/karelia/8/"."'>Боевые действия на участке 8-й армии</a></br>"."<a href='"."/site/battle/karelia/9/"."'>Боевые действия на участке 9-й армии</a></br>";
    }
}
echo $ssilkanaglav.
        "<div class='centrtext'>".
            "<div class='menu'>".
                "<div class='menua'>".
                    $menu.
                "</div>".
                "<div class='bglc'>".
                    "<div class='line'></div>
                    <p>Вышла новая книга о зимней войне</p>".
                    "<a href='https://war-museum-shop.ru/magazin/product/srazheniya-zimney-voyny'>".
                    "<img src='"."/site/siteimages/img_150.jpg"."'></a>".
                "</div>".
            "</div>".
            "<div class='prom_mm'>"."</div>".
            "<div class='main_text'>".
                "<div class = 'upmenu'>".$upmenu."</div>".
                "<div class='line'></div>".
                $ans1['a_title'].$main_text.
            "</div>".
        "<div class='right_p'>"."</div>".
        "</div>".$footerhtml;
$_SESSION['menu']=$menu;
$_SESSION['footer']=$footerhtml;
$_SESSION['ssilkanaglav']=$ssilkanaglav;
$_SESSION['upmenu']=$upmenu;
?>
</body>
</html>