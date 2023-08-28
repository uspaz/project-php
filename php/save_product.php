<?php 

require_once "../inc/session_start.php";
require_once "main.php";

$code = clear_texts($_POST['product_code']);
$name = clear_texts($_POST['product_name']);
$price = clear_texts($_POST['product_price']);
$stock = clear_texts($_POST['product_stock']);
$category = clear_texts($_POST['product_category']);

if ($code == "" || $name == "" || $price == "" || $stock == "" || $category == "") {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>Debes completar todos los campos.</p>
        </div>  
    ';
    exit();
}

if(validate_data("[a-zA-Z0-9- ]{1,70}", $code)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El código no coincide con el formato solicitado.</p>
        </div>';
    exit();
}
if(validate_data("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}", $name)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El nombre no coincide con el formato solicitado.</p>
        </div>';
    exit();
}
if(validate_data("[0-9.]{1,25}", $price)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El precio no coincide con el formato solicitado.</p>
        </div>';
    exit();
}
if(validate_data("[0-9]{1,25}", $stock)) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El stock no coincide con el formato solicitado.</p>
        </div>';
    exit();
}

$checkCode = connection()->query("SELECT product_code FROM producto WHERE product_code = '$code'");
if ($checkCode->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El código ingresado ya se encuentra registrado.</p>
        </div>  
    ';
    exit();
}
$checkCode = null;

$checkName = connection()->query("SELECT product_name FROM producto WHERE product_name = '$name'");
if ($checkName->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El nombre ingresado ya se encuentra registrado.</p>
        </div>  
    ';
    exit();
}
$checkName = null;

$checkCategory = connection()->query("SELECT category_id FROM categoria WHERE category_id = '$category'");
if ($checkCategory->rowCount() <= 0) {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>La categoría ingresada no existe.</p>
        </div>  
    ';
    exit();
}
$checkCategory = null;

$img_dir = "../img/products/";

if ($_FILES['product_image']['name'] != "" && $_FILES['product_image']['size'] > 0) {
    if (!file_exists($img_dir)) {
        if (!mkdir($img_dir, 0777)) {
            echo '
                <div class="notification is-danger is-light">
                    <h2>¡Ocurrio un error inesperado!</h2>
                    <p>Erro al crear el directorio de imagenes.</p>
                </div>  
            ';
            exit();
        }
    }

    if(mime_content_type($_FILES['product_image']['tmp_name']) != "image/jpeg" &&
    mime_content_type($_FILES['product_image']['tmp_name']) != "image/png"){
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>El formato de imagen que ha seleccionado no esta permitido.</p>
            </div>  
        ';
        exit();
    }

    if($_FILES['product_image']['size'] / 1024 > 3072 ){
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>Esta imagen supera el peso permitido.</p>
            </div>  
        ';
        exit();
    }

    switch (mime_content_type($_FILES['product_image']['tmp_name'])) {
        case 'image/jpeg':
            $img_ext = '.jpg';
        break;
        case 'image/png':
            $img_ext = '.png';
        break;
    }

    chmod($img_dir, 0777);

    $img_name = rename_photo($name);
    $img = $img_name.$img_ext;

    if (!move_uploaded_file($_FILES['product_image']['tmp_name'], $img_dir.$img)) {
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>No se pudo subir la imagen.</p>
            </div>  
        ';
        exit();
    }
}else {
    $img = "";
}

$saveProduct = connection()->prepare("INSERT INTO producto (product_code, product_name, product_price, product_stock, product_image, category_id, user_id) VALUES (:code, :prod_name, :prod_price, :prod_stock, :prod_img, :cat_id, :user_id)");

$markers = [
    ":code" => $code,
    ":prod_name" => $name,
    ":prod_price" => $price,
    ":prod_stock" => $stock,
    ":prod_img" => $img,
    ":cat_id" => $category,
    ":user_id" => $_SESSION['id']
];

$saveProduct->execute($markers);
if ($saveProduct->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <h2>El producto se registro con exito!</h2>
        </div>  
    ';
}else {
    if (is_file($img_dir.$img)) {
        chmod($img_dir.$img, 0777);
        unlink($img_dir.$img);
    }
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El producto no se pudo registrar, intente nuevamente.</p>
        </div>  
    ';
    }
$saveProduct = null;