<?php
session_start();
?>
<table> 
<tr> <td width="60%"> <h2> <?php 
require "conf/dbconnect.php";
$namec=mysqli_query(CONNECTION, "select namec from contact where namec!='0' limit 1");
while($sod_mas1=mysqli_fetch_row($namec))
{
$title=$sod_mas1[0];
echo $title;
};
?>
</h2>
</td>  <td width="20%" class='log' align="right">

 <?php 
require "conf/dbconnect.php";
$res=mysqli_query(CONNECTION, "select  `name`, surname, stud from sotr   where idsotr='{$_SESSION['sotr']}' ");
while($res_mas=mysqli_fetch_row($res))
{
echo "$res_mas[0] <br>  $res_mas[1] <br> ";
if ($res_mas[2]=1)
{
echo "<img src='image/student.png' height='25' width='25' >"; 
}
else
{
echo "<img src='image/scool.png' height='25' width='25' >"; 
}

};
?> </td> <td width="20%" align="center"><form   action='conf/exit.php' method='post' name='exit' >
<input type='image' src='image/button_delete_blue.png' value='Выйти' title='Выход' WIDTH='40' HEIGHT='40'> </form>  </td> </tr></table>
