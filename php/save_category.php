<?php
require_once "main.php";

$category_name = clear_texts($_POST['category_name']);
$category_ubication = clear_texts($_POST['category_ubication']);

if ($category_name == "") {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>Debes completar todos los campos.</p>
        </div>';
    exit();
}

if (validate_data('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}', $category_name)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El nombre de la categoria no es valido.</p>
        </div>';
    exit();
}

if ($category_ubication != "") {

    if (validate_data('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}', $category_ubication)) {
        echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El ubicación no coincide con el formato solicitado.</p>
        </div>';
        exit();
    }
}

$checkCategory = connection()->query("SELECT category_name FROM categoria WHERE category_name = '$category_name'");
if ($checkCategory->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>Esta categoria ya existe.</p>
        </div>';
    exit();
}
$checkCategory = null;

$saveCategory = connection()->prepare("INSERT INTO categoria (category_name, category_ubication) VALUES (:cat_name, :cat_ubi)");

$markers = [
    ":cat_name" => $category_name,
    ":cat_ubi" => $category_ubication,
];

$saveCategory->execute($markers);

if( $saveCategory->rowCount() == 1){
    echo '
        <div class="notification is-info is-light">
            <h2>¡EXITOOOO!</h2>
            <p>La categoría se registro correctamente.</p>
        </div>
    ';
}else{
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>La categoría no se logro registrar, intente nuevamente.</p>
        </div>
    ';
}

$saveCategory = null;