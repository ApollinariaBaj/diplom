<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=windows-1251'/>

    <title> Необходима авторизация</title>

    <link rel="stylesheet" type="text/css" href="js/jquery-ui-1.7.2.custom.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" href="css/jquery.treeview.css"/>
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="js/ui.datepicker-uk.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/forma.js"></script>
    <script src="js/jquery.treeview.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function () {
            $("#tree").treeview({
                collapsed: false,
                animated: "medium",
                control: "#sidetreecontrol",
                persist: "location"
            });
        })
    </script>
</head>
<body>
<br>
<br>
<div id='main'>
    <div class='noifixpng'></div>
    <div>
        <div>
            <table align="center" cellspacing="2" cellpadding="2" border="0" width="600" bgcolor="#99FF66">
                <tr>
                    <td colspan="3" align="center" class="ppp">
                        <br>
                        <h2>
                            <?php
                            require "conf/dbconnect.php";
                            $namec = mysql_query("select namec from contact where namec!='0' limit 1");
                            while ($sod_mas1 = mysql_fetch_row($namec)) {
                                $title = $sod_mas1[0];
                                echo $title;
                            };
                            ?></h2>
                        <table width="600">
                            <tr>
                                <td width="150" align="center"><img src="image/user.png" height="80" width="80">
                                </td>
                                <td width="300" align="center"><h2>Необходима авторизация</h2> <br> <a
                                            href="reg.php">Регистрация</a><br>
                                </td>
                                <td width="150" align="center"><img src="image/cup.png" height="80" width="80"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffcc" align="center">
                        <div>Введите логин и пароль</div>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <form method="post" action="auth.php">
                            <table align="center">

                                <td>Логин:</td>
                                <td><input type="text" name="login" class="text"></td>
                                </tr>

                                <tr>
                                    <td>Пароль:</td>
                                    <td><input type="password" name="password" class="text"></td>
                                </tr>
                                <tr>
                                    <td colspan=2>
                                        <br>
                                        <div style="text-align: center;">
                                            <input type="submit" name="parol" width="99" height="33" border="0"
                                                   value="Вход">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td class="tr">
                        <div style="text-align: center;"><a href="admin/index.php">Вход для администратора</a><br>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>

</html>
