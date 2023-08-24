<?php

$cat_id_del = clear_texts($_GET['category_id_del']);

// Verficando categoria
$checkCategory = connection()->query("SELECT category_id FROM categoria WHERE category_id = '$cat_id_del' ");

if( $checkCategory->rowCount() == 1){
    
    $checkProduct = connection()->query("SELECT category_id FROM producto WHERE category_id = '$cat_id_del' LIMIT 1 ");
    if ( $checkProduct->rowCount() <= 0) {
        $delete_category = connection()->prepare("DELETE FROM categoria WHERE category_id = :id ");
        $delete_category->execute([":id" => $cat_id_del]);

        if( $delete_category->rowCount() == 1) {
            echo '
                <div class="notification is-info is-light">
                    <h2>¡Ocurrio un error inesperado!</h2>
                    <p>El usuario ha sido correctamente eliminado</p>
                </div>
            ';
        }else {
            echo '
                <div class="notification is-danger is-light">
                    <h2>¡Ocurrio un error inesperado!</h2>
                    <p>No se pudo eliminar el usuario, intente de nuevo </p>
                </div>  
            ';
        }
        $delete_category = null;

    } else {
        echo '
            <div class="notification is-danger is-light">
                <h2>¡Ocurrio un error inesperado!</h2>
                <p>No podemos eliminar el usuario ya que tiene productos asociados.</p>
            </div>
        ';
    }
    $checkProduct = null;
    
}else {
    echo '
        <div class="notification is-danger is-light">
            <h2>¡Ocurrio un error inesperado!</h2>
            <p>El usuario que desea eliminar no existe.</p>
        </div>
    ';
}
$checkCategory = null;