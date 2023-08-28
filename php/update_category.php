<?php 
require_once "./main.php";

$id = clear_texts($_POST['category_id']);

$checkCategory = connection()->query("SELECT * FROM categoria WHERE category_id = '$id' ");

if ($checkCategory->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El usuario no existe en el sistema</p>
        </div>
    ';
    exit();
} else {
    $data = $checkCategory->fetch();
}

$checkCategory = null;

$cat_name = clear_texts($_POST['category_name']);
$cat_ubi = clear_texts($_POST['category_ubication']);

if( $cat_name == ""){
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>No has llenado todos los campos obligatorios.</p>
        </div>
    ';
    exit();
}

if(validate_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $cat_name)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El nombre no coincide con el formato solicitado.</p>
        </div>';
    exit();
}

if ($cat_ubi != "") {
    
    if(validate_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}", $cat_ubi)) {
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>La ubicación no coincide con el formato solicitado.</p>
            </div>';
        exit();
    }
}

if( $cat_name != $data['category_name']){
    $checkName = connection()->query("SELECT category_name FROM categoria WHERE category_name = '$cat_name'");
    if ($checkName->rowCount() > 0) {
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>El correo ingresado ya se encuentra registrado.</p>
            </div>';
        exit();
    }
    $checkName = null;
}


$updateCategory = connection()->prepare("UPDATE categoria SET category_name = :cat_name, category_ubication = :cat_ubi WHERE category_id = :id");

$markers = [
    "cat_name" => $cat_name,
    "cat_ubi" => $cat_ubi,
    ":id" => $id,
];

if ($updateCategory->execute($markers)) {
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
$updateCategory = null;