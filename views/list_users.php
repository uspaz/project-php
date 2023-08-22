<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Lista de usuarios</h2>
</div>

<div class="container pb-6 pt-6">

<?php
    require_once './php/main.php';

    if(isset($_GET['user_id_del'])){
        require_once "./php/user_delete.php";
    }

    if ( !isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = (int) $_GET['page'];
        if($page <= 1){
            $page = 1;
        }
    }
    
    $page = clear_texts($page);
    $url = "index.php?view=list_users&page=";
    $registers = 10;
    $search = "";
    
    require_once './php/user_list.php';
?>

</div>