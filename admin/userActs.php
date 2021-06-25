<?php

error_reporting(0);
require '../common.php';

$json = [];

// данные ошибки 
$json = [
    'error' => 'true',
    'message' => 'Přístup odepřen'
];

if (isset($_GET['getDataById'])) {
    $userData = mysqli_fetch_assoc(query("SELECT * FROM users where id = " . $_GET['getDataById']));
    // проверка, и добавление данных
    $json = [
        'id' => $userData['id'],
        'login' => $userData['log'],
        'password' => $userData['pass'],
        'role' => $userData['role'],
    ];
}

if (isset($_POST['id']) && isset($_POST['login']) && isset($_POST['role'])) {
    $check = query("SELECT * FROM users WHERE log = '{$_POST['login']}' and id != {$_POST['id']}");
    // проверка на существующего пользователя 
    if ($check->num_rows > 0) {
        $json = [
            'success' => false,
            'message' => 'uživatel s tímto jménem již existuje!'
        ];
    } else {
        if (isset($_POST['password'])) {
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $update = query("UPDATE users SET log = '{$_POST['login']}', pass = '{$_POST['password']}', role = '{$_POST['role']}' WHERE id = {$_POST['id']}");
        } else {
            $update = query("UPDATE users SET log = '{$_POST['login']}', role = '{$_POST['role']}' WHERE id = {$_POST['id']}");
        }
        if ($update) {
            $data = [];
            foreach (mysqli_fetch_array(query("SELECT * FROM users ORDER BY id")) as $key => $value) {
                array_push($data, $value);
            }
            $data = query("SELECT * FROM users");
            $arrData = [];
            while ($res = mysqli_fetch_array($data)) {
                array_push($arrData, $res['id'], $res['log'], $res['role']);
            };
            $json = [
                'success' => true,
                'message' => 'uživatel byl úspěšně upraven!',
                'login' => $_POST['login'],
                'role' => $_POST['role'],
                'data' => $arrData
            ];
        } else {
            $json = [
                'success' => false,
                'message' => 'uživatel nebyl editován, chyba!'
            ];
        }
    }
}

if (isset($_POST['addNewUser']) && isset($_POST['addNewUserPassword']) && isset($_POST['addNewUserRole'])) {
    $check = query("SELECT * FROM users WHERE log = '{$_POST['addNewUser']}'");
    if ($check->num_rows > 0) {
        $json = [
            'success' => false,
            'message' => 'uživatel s tímto jménem již existuje!'
        ];
    } else {
        $_POST['addNewUserPassword'] = password_hash($_POST['addNewUserPassword'], PASSWORD_BCRYPT);
        $insert = query("INSERT INTO users (log, pass, role) VALUES ('{$_POST['addNewUser']}','{$_POST['addNewUserPassword']}','{$_POST['addNewUserRole']}')");
        $data = query("SELECT * FROM users");
        $arrData = [];
        while ($res = mysqli_fetch_array($data)) {
            array_push($arrData, $res['id'], $res['log'], $res['role']);
        };
        if ($insert) {
            $json = [
                'success' => true,
                'message' => 'uživatel přidán úspěšně!',
                'data' => $arrData
            ];
        } else {
            $json = [
                'success' => false,
                'message' => 'uživatel nebyl přidán, chyba!'
            ];
        }
    }
}

if (isset($_POST['deleteUserId'])) {
    $check = query("SELECT * FROM users WHERE id = '{$_POST['deleteUserId']}'");
    if ($check->num_rows == 0) {
        $json = [
            'success' => false,
            'message' => 'uživatel nebyl nalezen, chyba!'
        ];
    } else {
        $delete = query("DELETE FROM users WHERE id = {$_POST['deleteUserId']}");
        if ($delete) {
            $data = query("SELECT * FROM users");
            $arrData = [];
            while ($res = mysqli_fetch_array($data)) {
                array_push($arrData, $res['id'], $res['log'], $res['role']);
            };
            $json = [
                'success' => true,
                'message' => 'uživatel úspěšně smazán!',
                'data' => $arrData
            ];
        } else {
            $json = [
                'success' => false,
                'message' => 'uživatel nebyl smazán, chyba'
            ];
        }
    }
}

echo json_encode($json);