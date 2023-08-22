<?php

$init = ($page > 0) ? (($page * $registers) - $registers) : 0;
$table = "";

if (isset($search) && $search != "") {
    $query_data = "SELECT * FROM usuario WHERE ((user_id != '" . $_SESSION['id'] . "') AND (user_name LIKE '%$search%' OR user_lastname LIKE '%$search%' OR user LIKE '%$search%' OR user_email LIKE '%$search%')) ORDER BY user_name ASC limit $init,$registers ";
    $query_total = "SELECT COUNT(*) FROM usuario WHERE ((user_id != '" . $_SESSION['id'] . "') AND (user_name LIKE '%$search%' OR user_lastname LIKE '%$search%' OR user LIKE '%$search%' OR user_email LIKE '%$search%'))";
} else {
    $query_data = "SELECT * FROM usuario WHERE user_id != '" . $_SESSION['id'] . "' ORDER BY user_name ASC limit $init,$registers ";
    $query_total = "SELECT COUNT(*) FROM usuario WHERE user_id != '" . $_SESSION['id'] . "' ";
}
$connection = connection();
$data = $connection->query($query_data);
$data = $data->fetchAll();

$total = $connection->query($query_total);
$total = (int) $total->fetchColumn();

$Npages = ceil($total / $registers);

$table .= '
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
             
';

if ( $total >= 1 && $page <= $Npages ) {
    $count = $init + 1;
    $pag_initial = $init + 1;
    foreach ($data as $rows) {
        $table .= '
            <tr class="has-text-centered" >
                <td>'.$count.'</td>
                <td>'.$rows['user_name'].'</td>
                <td>'.$rows['user_lastname'].'</td>
                <td>'.$rows['user'].'</td>
                <td>'.$rows['user_email'].'</td>
                <td>
                    <a href="index.php?view=update_user&user_id_up='.$rows['user_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="'.$url.$page.'&user_id_del='.$rows['user_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
        ';
        $count++;
    }
    $pag_final = $count;
    

} else {
   if ($total >= 1 ) {
        $table .= '
            <tr class="has-text-centered" >
                <td colspan="7">
                    <a href="#" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
   } else {
        $table .= '
            <tr class="has-text-centered" >
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
   }
   
}

$table .= '
</tbody>
</table>
</div> 
';

if( $total > 0 && $page <= $Npages ) {
    $table .= '
        <p class="has-text-right">Mostrando usuarios
            <strong>'.$pag_initial.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>
            total de '.$pag_final.'</strong>
        </p>
    ';
}


$connection = null;
echo $table;

if ( $total >= 1 && $page <= $Npages) {
    echo pagination($page, $Npages, $url, 7);
}