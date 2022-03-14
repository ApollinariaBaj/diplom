<html>
<title>  Необходима авторизация</title>
<head>

        <body BACKGROUND="image/bg.png">
<br>
<br>
			
<center>
<link rel='stylesheet' type='text/css' href='../css/index.css' /> 


		<table align="center" cellspacing="2" cellpadding="2" border="0"  width="600" bgcolor="#ABE2F0">
<tr>
	<td colspan="3" align="center" class="ppp">
	<h2> 
  <?php 
require "../conf/dbconnect.php";
$namec=mysql_query("select namec from contact where namec!='0' limit 1");
while($sod_mas1=mysql_fetch_row($namec))
{
$title=$sod_mas1[0];
echo $title;
};
?></h2>
	<center> 
	<table width="600"> <tr> <td width="150" align="center">  <img src="../image/admin.png" height="80" width="80" > </td> 
	<td width="300" align="center"> <h2>Панель администратора</h2></td> <td width="150" align="center">  <img src="../image/cup.png" height="80" width="80" > </td> </tr> </table>

		</td>
</tr>
<tr>
	<td bgcolor="#ffffcc" align="center"><center>Введите логин и пароль
</td>
</tr>
<tr>
	<td align="center">
	<form method="post" action="auth.php" ><table align=center>
             
              <td>Логин:</td>
              <td><input type="text" name="login" class="text"></td></tr>

            <tr>
              <td>Пароль:</td>
              <td><input type="password" name="password" class="text"></td></tr>
            <tr>
              <td colspan=2>
                  <br><center>
				  <input type="submit"  name="parol"  width="99" height="33" border="0" value="Вход"></form>  </td>
            </tr>
         </table>
	
	</td>
	</tr>
	<tr>  <td class="tr"><center><a href="../index.php">Вход для участника</a><br> </td>
	</tr> </table>



  		
     
        </body>     
  
</html>
