<?php
session_start();
?>
<?php 
unset($_SESSION['user']); /* ������������ ������� �������� */
session_destroy();
Header ("Location: ../index.php"); /*  �������������� �� ������� �������� ������� */
?>
<!-- ���� ����������� ������  -->
