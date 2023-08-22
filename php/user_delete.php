<?php

$user_id_del = clear_texts($_GET['user_id_del']);

// Verficando usuario
$checkUser = connection()->query("SELECT user_id FROM usuario WHERE user_id = '$user_id_del' ");

if( $checkUser->rowCount() == 1){
    
    $checkProduct = connection()->query("SELECT user_id FROM producto WHERE user_id = '$user_id_del' LIMIT 1 ");
    if ( $checkProduct->rowCount() <= 0) {
        $delete_user = connection()->prepare("DELETE FROM usuario WHERE user_id = :id ");
        $delete_user->execute([":id" => $user_id_del]);

        if( $delete_user->rowCount() == 1) {
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
        $delete_user = null;

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
$checkUser = null;