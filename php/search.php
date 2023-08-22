<?php 

$module_searcher = clear_texts($_POST['module_searcher']);
$modules = ["user", "category", "product"];

if( in_array($module_searcher, $modules) ){

    $modules_url = [
        "user" => "user_search",
        "category" => "category_search",
        "product" => "product_search"
    ];
    $modules_url = $modules_url[$module_searcher];
    $module_searcher = $module_searcher."_search";

    if ( isset($_POST['txt_searcher'])) {
        $text = clear_texts($_POST['txt_searcher']);

        if ($text == "") {
            echo '
                <div class="notification is-danger is-light">
                    <h2>¡Ocurrio un error inesperado!</h2>
                    <p>Debes introducir un texto para realizar la busqueda.</p>
                </div>
            ';
        } else {

            if( validate_data('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}', $text) ){
                echo '
                    <div class="notification is-danger is-light">
                        <h2>¡Ocurrio un error inesperado!</h2>
                        <p>El texto introducido no coincide con el formato solicitado.</p>
                    </div>
                ';
            }else{
                $_SESSION[$module_searcher] = $text;
                header("Location: index.php?view=$modules_url", true, 303);
                exit();
            }
        }
        
    }

    if(isset($_POST['delete_search'])){
        unset( $_SESSION[$module_searcher]);
        header("Location: index.php?view=$modules_url", true, 303);
        exit();
    }

}else {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>No podemos procesar la petición.</p>
        </div>
    ';
}