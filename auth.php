<?php
session_start();
require "../conf/dbconnect.php";
if (isset($_POST['parol'])) {
    $res = mysqli_query(CONNECTION, "SELECT id FROM user WHERE login='{$_POST['login']}' AND password='{$_POST['password']}'");
    if (mysql_num_rows($res)) {
        while ($prise_mas = mysql_fetch_row($res)) {
            $_SESSION['var'] = "$prise_mas[0]";
            Header("Location: man.php");
        }
    } else {    //������ ������������ ���
        echo "<center><br><br>������� �������� ����� ��� ������<br><br> <span><a href='index.php'>���������� ��� ���</a></span> <br> ��� ���������� � �������������� �������<br>
";
    }
}
?>
