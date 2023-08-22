<?php
require_once 'main.php';

$nombre = clear_texts($_POST['name']);
$lastName = clear_texts($_POST['lastName']);
$user = clear_texts($_POST['user']);
$email = clear_texts($_POST['email']);
$password = clear_texts($_POST['password']);
$confirPass = clear_texts($_POST['confirmPass']);

if ($nombre == "" || $lastName == "" || $user == "" || $email == "" || $password == "" || $confirPass == "") {
    echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>Por favor, complete todos los campos.</p>
            </div>';
    exit();
}

if(validate_data("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El nombre no coincide con el formato solicitado.</p>
        </div>';
    exit();
}

if(validate_data("[a-zA-ZáéíöûÁÉÍÖÚñÜ ]{3,40}", $lastName)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El apellido no coincide con el formato solicitado.</p>
        </div>';
    exit();
}


if (validate_data(("[a-zA-Z0-9]{4,20}"), $user)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El usuario no coincide con el formato solicitado.</p>
        </div>';
    exit();
}

if (validate_data("[a-zA-Z0-9$@.-]{7,100}", $password) || validate_data("[a-zA-Z0-9$@.-]{7,100}", $confirPass)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>Las contraseñas no coincide con el formato solicitado.</p>
        </div>';
    exit();
}


if ($email != "") {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $checkEmail = connection()->query("SELECT user_email FROM usuarios WHERE email = '$email'");
        if ($checkEmail->rowCount() > 0) {
            echo '
                <div class="notification is-danger is-light">
                    <h2>¡Ocurrio un error inesperado!</h2>
                    <p>El correo ingresado ya se encuentra registrado.</p>
                </div>';
            exit();
        }
        $checkEmail = null;
    } else {
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>El correo no coincide con el formato solicitado.</p>
            </div>';
        exit();
    }

}
$checkUser = connection()->query("SELECT user FROM usuario WHERE user = '$user'");
if ($checkUser->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El correo ingresado ya se encuentra registrado.</p>
        </div>';
    exit();
}
$checkUser = null;

if ($password != $confirPass) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>Las contraseñas no coinciden.</p>
        </div>';
    exit();
} else {
    $pass = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]);
}

$saveUser = connection();
$saveUser = $saveUser->prepare("INSERT INTO usuario(user_name, user_lastName, user, user_pass, user_email) VALUES( :nombre, :lastName,:user,:pass,:email)" );

$markers = [
    ":nombre" => $nombre,
    ":lastName" => $lastName,
    ":user" => $user,
    ":pass" => $pass,
    ":email" => $email,
]; 

$saveUser->execute($markers);

if($saveUser->rowCount() == 1){
    echo '
        <div class="notification is-info is-light">
            <h2>Bienvenido</h2>
            <p>El usuario se registro correctamente.</p>
        </div>
    ';
}else{
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>No se pudo registrar el usuario, intente nuevamente</p>
        </div>
    ';
}

$saveUser = null;