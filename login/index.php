<?php
require '../common.php';

// если POST - то это попытка войти
// POST - pokus loginu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db, $_POST['log']);
    $password = mysqli_real_escape_string($db, $_POST['pass']);


    // ищем соответствующего юзера в базе
    // Hledame odpovidajiciho uzivatele v databazi
    $sql = "SELECT * FROM users WHERE log = '$username'";
    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        // если не нашли
        // jestli neni
        $error_text = 'Nesprávné přihlašovací jméno a/nebo heslo';
        session_destroy();
    } else {
        $user = mysqli_fetch_array($result);
        // пишем юзера в сессию
        // zapis uzivatele do session
        // if (password_verify($password, $user['pass'])) {
            $_SESSION['user'] = $user;
        // } else {
        //     $error_text = 'Incorrect login and/or password';
        //     session_destroy();
        // }
    }
}

// если залогинены
// jestli zalogovan
if (!empty($_SESSION['user'])) {
    // редиректим в зависимости от роли
    // presmerovani podle roli
    $role = $_SESSION['user']['role'];
    switch ($role) {
        case 'redaktor':
            header('Location: ../redaktor/');
            break;
        case 'admin':
            header('Location: ../admin/');
            break;
        default:    // неизвестная роль / neznama role
            echo "CHYBA: neznámá role '$role'";
            exit;
    }
}
?>

<!DOCTYPE html>
<html lang="cs-cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login OpenStreetMap</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="container signin__container">

    <form class="form__signin" method="post" class="form">

        <div class="row login__wrap_img">
            <img class="mt-4 mb-4" src="../img/avatar.png" alt="">
        </div>


        <h1 class="h3 mb-3 font-weight-normal d-flex justify-content-center">OpenStreetMap</h1>

        <label for="inputLogin" class="sr-only">Login</label>
        <input type="text" name="log" id="inputLogin" class="form-control mb-3" placeholder="Login" required
               autofocus minlength="5">

        <label for="inputPassword" class="sr-only">Heslo</label>
        <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Heslo" required
               minlength="5">

        <!-- если ошибка вывести алерт -->
        <!-- показываем ошибку, если есть -->
        <br>
        <?php if (!empty($error_text)) : ?>
            <div class="alert alert-danger" role="alert"><?php echo $error_text; ?></div> <?php endif ?>
        <!-- -->

        <!-- spinner при отправке сделать -->
        <button class="btn btn-lg btn-primary btn-block" name="sub" type="submit">Přihlásit se</button>


    </form>

</div>


<!-- jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous">
</script>

</body>

</html>
