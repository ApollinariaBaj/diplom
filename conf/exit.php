<?php
session_start();
?>
<?php 
$_SESSION['sotr']=0; /* ������������ ������� �������� */
session_destroy();
Header ("Location: ../index.php"); /*  �������������� �� ������� �������� ������� */
?>
<!-- ���� ����������� ������  -->
