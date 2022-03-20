<?php session_start();
if (!$_SESSION['user']) {
    header("Location: index.php");
}
if (!$_SESSION['user']['admin']) {
    header("Location: main.php");
}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8'/>

    <title>Группы</title>

    <link rel="stylesheet" type="text/css" href="/js/jquery-ui-1.7.2.custom.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel='stylesheet' type='text/css' href='/css/index.css'/>
    <script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="/js/ui.datepicker-ru.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js/forma.js"></script>
</head>
<body>
<div id='main'>


</div>
</body>
</html>