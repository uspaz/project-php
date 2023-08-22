<?php

$init = ($page > 0) ? (($page * $registers) - $registers) : 0;
$table = "";

if (isset($search) && $search != "") {
    $query_data = "SELECT * FROM categoria WHERE category_name LIKE '%$search%' OR category_ubication LIKE '%$search%' ORDER BY category_name ASC limit $init,$registers ";
    $query_total = "SELECT COUNT(category_id) FROM categoria WHERE category_name LIKE '%$search%' OR category_ubication LIKE '%$search%'";
} else {
    $query_data = "SELECT * FROM categoria ORDER BY category_name ASC limit $init,$registers ";
    $query_total = "SELECT COUNT(category_id) FROM categoria";
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
            <th>Nombre</th>
            <th>Ubicación</th>
            <th>Productos</th>
            <th colspan="2">Opciones</th>
        </tr>
    </thead>
    <tbody>
             
';

if ($total >= 1 && $page <= $Npages) {
    $count = $init + 1;
    $pag_initial = $init + 1;
    foreach ($data as $rows) {
        $table .= '
            <tr class="has-text-centered" >
                <td>' . $count . '</td>
                <td>' . $rows['category_name'] . '</td>
                <td>' . substr($rows['category_ubication'], 0, 25) . '</td>
                <td>
                        <a href="index.php?view=product_category&category_id=' . $rows['category_id'] . '" class="button is-link is-rounded is-small">Ver productos</a>
                    </td>
                <td>
                    <a href="index.php?view=category_update&category_id_up=' . $rows['category_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="' . $url . $page . '&category_id_del=' . $rows['category_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
        ';
        $count++;
    }
    $pag_final = $count;


} else {
    if ($total >= 1) {
        $table .= '
            <tr class="has-text-centered" >
                <td colspan="6">
                    <a href="#" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    } else {
        $table .= '
            <tr class="has-text-centered" >
                <td colspan="6">
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

if ($total > 0 && $page <= $Npages) {
    $table .= '
        <p class="has-text-right">Mostrando categorias
            <strong>' . $pag_initial . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>
            total de ' . $pag_final . '</strong>
        </p>
    ';
}


$connection = null;
echo $table;

if ($total >= 1 && $page <= $Npages) {
    echo pagination($page, $Npages, $url, 7);
}