<?php 
require_once "../inc/session_start.php";
require_once "./main.php";

$id = clear_texts($_POST['user_id']);

$checkUser = connection()->query("SELECT * FROM usuario WHERE user_id = '$id' ");

if ($checkUser->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El usuario no existe en el sistema</p>
        </div>
    ';
    exit();
} else {
    $data = $checkUser->fetch();
}

$checkUser = null;

$admin_user = clear_texts($_POST['admin_user']);
$admin_pass = clear_texts($_POST['admin_pass']);

if ( $admin_user == '' || $admin_pass == '' ) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>No has llenado todos los campos obligatorios.</p>
        </div>
    ';
    exit();
}


if(validate_data("[a-zA-Z0-9]{4,20}", $admin_user)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El usuario no coincide con el formato solicitado.</p>
        </div>';
    exit();
}

if(validate_data("[a-zA-Z0-9$@.-]{7,100}", $admin_pass)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>La contraseña no coincide con el formato solicitado.</p>
        </div>';
    exit();
}

$checkAdmin = connection()->query("SELECT user, user_pass FROM usuario WHERE user = '$admin_user' AND user_id = '".$_SESSION['id']."' ");

if( $checkAdmin->rowCount() == 1){
    $checkAdmin = $checkAdmin->fetch();

    if( $checkAdmin['user'] != $admin_user || !password_verify($admin_pass, $checkAdmin['user_pass'])){
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>Usuario o clave de administrador incorrectos.</p>
            </div>
        ';
        exit();
    }



}else {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>Usuario o clave de administrador incorrectos.</p>
        </div>
    ';
    exit();
}

$checkAdmin = null;


$nombre = clear_texts($_POST['user_name']);
$lastname = clear_texts($_POST['user_lastname']);

$user = clear_texts($_POST['user']);
$email = clear_texts($_POST['user_email']);

$password = clear_texts($_POST['user_password']);
$confirPass = clear_texts($_POST['user_pass_conf']);

if( $nombre == "" || $lastname == "" || $user == ""){
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>No has llenado todos los campos obligatorios.</p>
        </div>
    ';
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

if(validate_data("[a-zA-ZáéíöûÁÉÍÖÚñÜ ]{3,40}", $lastname)) {
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

if ($email != "" && $data['user_emal' != $email]) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $checkEmail = connection()->query("SELECT user_email FROM usuario WHERE user_email = '$email'");
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

if ($user != $data['user']) {
        
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
}

if ( $password != "" || $confirPass != "" ) {
    if (validate_data("[a-zA-Z0-9$@.-]{7,100}", $password) || validate_data("[a-zA-Z0-9$@.-]{7,100}", $confirPass)) {
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>Las contraseñas no coincide con el formato solicitado.</p>
            </div>';
        exit();
    }else {
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
    }
}else {
    $pass = $data['user_pass'];

}

$updateUser = connection()->prepare("UPDATE usuario SET user_name = :nombre, user_lastname = :lastname, user = :user, user_pass = :pass, user_email = :email WHERE user_id = :id");

$markers = [
    ":nombre" => $nombre,
    ":lastname" => $lastname,
    ":user" => $user,
    ":email" => $email,
    ":pass" => $pass,
    ":id" => $id,
];

if ($updateUser->execute($markers)) {
    echo '
    <div class="notification is-info is-light">
        <p>Los datos se modificaron correctamente</p>
    </div>';
} else {
    echo '
    <div class="notification is-danger is-light">
        <h2>¡Ocurrio un error inesperado!</h2>
        <p>No se pudo actualizar el usuario, por favor intente de nuevo</p>
    </div>';
}
$updateUser = null;