<?require_once 'services/users.php';
if (!Users::isAuthorized()) {
    header("Location: index.php");
}?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8'/>
    <link rel="shortcut icon" href="https://e.muiv.ru/theme/image.php/_s/vitte/theme/1632305883/favicon"/>
    <title>Выход</title>
</head>
<body>
<form class="form-signin ajax visually-hidden" method="post" id="logoutForm" action="./ajax/authorizationAjax.php">
    <input type="hidden" name="act" value="logout">
    <div class="form-actions">
        <button class="btn btn-large btn-primary" type="submit">Выйти</button>
    </div>
</form>
<script src="./js/jquery-2.0.3.min.js"></script>
<script src="./js/ajax-form.js"></script>
<script >document.addEventListener("DOMContentLoaded", function(){
        $('#logoutForm').submit();
    });</script>
</body>
</html>
