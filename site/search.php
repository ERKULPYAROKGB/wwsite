<!DOCTYPE html>
<html>
    <head>
        <title>Зимняя война</title>
        <link rel='stylesheet' href='../../styles.css'>
    </head>
    <body>
        <?php
        session_start();
        $name= '%'.$_GET['name'].'%';
        $surname = '%'.$_GET['surname'].'%';
        $fathername = '%'.$_GET['fathername'].'%';
        $user="root";
        $pass="фуашу2УЗ";
        $host = "127.0.0.1";
        $port = 3306;
        $db = "ww";
        $link = mysqli_connect($host, $user, $pass, $db, $port);
        if (!$link) {
            die('Ошибка подключения (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
        #получаем и заполняем информацию
        $main_text="";
        $tempres="";
        $forma='<form name="soldierfilter" action="/site/bd/search/">
        <table width="100%" cellspacing="1" cellpadding="0" border="0">
            <tbody>
                    <tr>
                        <td><b>Фамилия</b></td>
                        <td><b>Имя</b></td>
                        <td><b>Отчество</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><input type="text" class="enter1" name="surname" size="16" onclick="this.value='."''".'" value=""></td>
                        <td><input type="text" class="enter1" name="name" size="16" onclick="this.value='."''".'" value=""></td>
                        <td><input type="text" class="enter1" name="fathername" size="16" onclick="this.value='."''".'" value=""></td>
                        <td valign="bottom" align="right"><br/><input type="image" src="../../support/images/search.gif"></td>
                    </tr>
                </tbody>
            </table>
        </form>';
        $sql = "SELECT * FROM soldiers WHERE s_name LIKE '$name' and s_surname LIKE '$surname' and s_fathername LIKE '$fathername'";
        $result = mysqli_query($link,$sql);
        while($ans = mysqli_fetch_assoc($result)){
            $tempres="<div class='soldiers_box'><b>".$ans['s_surname']." ".$ans['s_name']." ".$ans['s_fathername']."</b><ul>";
            if($ans['s_birthyear']!=''){
                $tempres=$tempres."<li>Год рождения: ".$ans['s_birthyear']."</li>";}
            if($ans['s_birthrepublic'] != '' || $ans['s_birthregion'] != '' || $ans['s_birthrayon'] != '' || $ans['s_birthtown']!=''){    
            $tempres=$tempres."<li>Место рождения: ".$ans['s_birthrepublic'].", ".$ans['s_birthregion'].", ".$ans['s_birthrayon'].", ".$ans['s_birthtown']."</li>";}
            if($ans['s_calledby']!=''){    
                $tempres=$tempres."<li>Призван: ".$ans['s_calledby']."</li>";}
            if($ans['s_rank']!=''){
                $tempres=$tempres."<li>Звание: ".$ans['s_rank']."</li>";}
            if($ans['s_milforce']!=''){
                $tempres=$tempres."<li>Воинское соединение: ".$ans['s_milforce']."</li>";}
            if($ans['s_deathdate']!=''){
                $tempres=$tempres."<li>Дата гибели: ".$ans['s_deathdate']."</li>";}
            if($ans['s_reason']!=''){
                $tempres=$tempres."<li>Причина гибели: ".$ans['s_reason']."</li>";}
            $tempres=$tempres."</ul>"."<div class='line'></div>"."</div>";
            $main_text=$main_text.$tempres;
        }
        $c=0;
        echo $_SESSION['ssilkanaglav'].
        "<div class='centrtext'>".
            "<div class='menu'>".
                "<div class='menua'>".
                $_SESSION['menu'].
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
                "<div class = 'upmenu'>".$_SESSION['upmenu']."</div>".
                "<div class='line'></div>".
                $forma.$main_text.
            "</div>".
        "<div class='right_p'>"."</div>".
        "</div>".$_SESSION['footer'];
        ?>
        </body>
    </html>