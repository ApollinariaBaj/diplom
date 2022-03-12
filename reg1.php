<?php session_start();
?><!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=windows-1251'/>

    <title>
    </title>

    <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.7.2.custom.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="js/ui.datepicker-uk.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/forma1.js"></script>
</head>

<body>

<?php
require "conf/dbconnect.php";
$res_id1 = mysql_query("SELECT idklient, namekl FROM `klient`")
or die(mysql_error());
$klient = mysql_num_rows($res_id1);

?>
<div id='content'>
    <div id='content1'>
        <!-- вот здесь вся инфа-->
        <table width="800">
            <tr>
                <td width="150" align="center"><img src="image/cup.png" height="80" width="80"></td>
                <td width="600" align="center"><h2> Конкурс по поиску информации в сети Интернет </h2></td>
            </tr>
        </table>
        </td>
        </tr> </table>

        <p class="pp">
            Регистрация участников игры <br>
            <a href="index.php">На главную </a><br>
        </p>

        <table align="center" cellspacing="2" cellpadding="2" border="0" bgcolor="ffffff" width="910">
            <tr>
                <td>
                    <center>
                </td>
                <td bgcolor="" valign="top">
                    <center>

                        <table width="910" bgcolor="#FFFFFF">
                            <tr>
                                <td align="center" bgcolor="#666666"><a href="reg.php"> <img src="image/scool.png"
                                                                                             height="30" width="30">
                                        <span class="reg">  Я -  школьник  </span> </a></td>
                                <td align="center"><a href="#"> <img src="image/student.png" height="30"
                                                                     width="30"><span class="reg">  Я - студент </span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">


                                    <table align="center" cellspacing="2" cellpadding="2" border="0">
                                        <tr>
                                            <form method="post" id="signup" action="regotv.php">
                                                <td class="date1">Фамилия</td>

                                                <td class="log"><input type="text" size="40" name="name" value=""
                                                                       class="required"
                                                                       title="<p class='log'>Только русский алфавит</p>">
                                                </td>
                                                <td class="tr">Русские буквы</td>
                                        </tr>
                                        <tr>
                                            <td width="200" align="center" class="date1"> Имя и отчество</td>
                                            <td width="200" class="log"><input type="text" size="40" name="ima" value=""
                                                                               class="required"
                                                                               title="<p class='log'>Только русский алфавит</p>">
                                            </td>
                                            <td class="tr">Русские буквы</td>
                                        </tr>
                                        <tr>
                                            <td class="date1">Дата рождения</td>
                                            <td class="log"><input type="text" size="40" name="date"
                                                                   class="datepicker1 required"
                                                                   title="<p class='log'>Поле обязательно к заполнению</p>">
                                            </td>
                                            <td class="tr">ГГГГ-ММ-ДД</td>
                                        </tr>
                                        <tr>
                                            <td class="date1">Город</td>
                                            <td class="log"><input type="text" size="40" name="gorod" class="required"
                                                                   title="<p class='log'>Поле обязательно к заполнению</p>">
                                            </td>
                                            <td class="tr">Русские буквы</td>
                                        </tr>
                                        <tr>
                                            <td class="date1">ВУЗ и факультет</td>
                                            <td class="log"><input type="text" size="40" name="scool" class="required"
                                                                   title="<p class='log'>Поле обязательно к заполнению</p>">
                                            </td>
                                            <td class="tr">Цифры и буквы</td>
                                        </tr>
                                        <tr>
                                            <td class="date1">Группа</td>
                                            <td class="log"><input type="text" size="40" name="klass" class="required"
                                                                   title="<p class='log'>Поле обязательно к заполнению</p>">
                                            </td>
                                            <td class="tr">Цифры и буквы</td>
                                        </tr>
                                        <tr>
                                            <td class="date1">Логин</td>
                                            <td class="log"><input type="text" size="40" name="login" class="required"
                                                                   title="<p class='log'>Поле обязательно к заполнению</p>"
                                                                   value=""></td>
                                            <td class="tr">Не менее 6 символов, латиница и цифры</td>
                                        </tr>
                                        <tr>
                                            <td class="date1">Пароль</td>
                                            <td class="log"><input type="text" size="40" name="parol" class="required"
                                                                   title="<p class='log'>Поле обязательно к заполнению</p>"
                                                                   value=""></td>
                                            <td class="tr">Не менее 6 символов, латиница и цифры</td>
                                        </tr>
                                        <tr>
                                            <td width="200" align="center" class="date1"> Игра</td>
                                            <td width="200" align="center" class="log">
                                                <select name="igri">
                                                    <center>
                                                        <?php
                                                        require "conf/dbconnect.php";
                                                        $d = date("Y-m-d H:i");
                                                        $res = mysql_query("SELECT namekl, imagekl, nomer, nameigra, datechet, idchet
FROM chet, klient where idklient=idklientchet and datechet>'$d' ");
                                                        while ($igri = mysql_fetch_row($res)) {
                                                            echo "<center><option value='$igri[5]'>$igri[0] $igri[3] $igri[4]</option>\n";
                                                        }
                                                        ?>
                                                </select>

                                            </td>
                                            <td class="tr">Тип игры, название, дата и время проведения</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" bgcolor="">
                                                <center><br><input type="submit" value="Зарегистрироваться"
                                                                   name="regsud" class="button blue"><br>
                                                    </form><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" bgcolor="e6e6fa">
                                                <center>

                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                </td>
            </tr>
        </table>

    </div>
</div>
<br>
<div id='main' class='noifixpng'>

</div>
<br>
</body>
</html>