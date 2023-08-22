<?php
$user = clear_texts($_POST['user']);
$pass = clear_texts($_POST['password']);

if ( $user == "" || $pass == "") {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>Por favor, complete todos los campos.</p>
        </div>
    ';
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

if (validate_data("[a-zA-Z0-9$@.-]{7,100}", $pass) ) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>La contraseña no coincide con el formato solicitado.</p>
        </div>';
    exit();
}

$checkUser = connection()->query("SELECT * FROM usuario WHERE user = '$user'");
if($checkUser->rowCount() == 1){
    $checkUser = $checkUser->fetch();

    if ( $checkUser['user'] == $user && password_verify($pass, $checkUser['user_pass'])) {
        $_SESSION['id'] = $checkUser['user_id'];
        $_SESSION['name'] = $checkUser['user_name'];
        $_SESSION['lastName'] = $checkUser['user_lastname'];
        $_SESSION['user'] = $checkUser['user'];

        if (headers_sent()) {
            echo "<script>window.location.href='index.php?view=home'</script>";
        }else{
            header("Location: index.php?view=home");
        }
    } else {
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>Usuario o clave incorrectos.</p>
            </div>
        ';
    }
    
}else {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>Usuario o clave incorrectos.</p>
        </div>
    ';
}
$checkUser = null;


