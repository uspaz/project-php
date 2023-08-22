<div class="container is-fluid mb-6">
    <h1 class="title">Users</h1>
    <h2 class="subtitle">Search user</h2>
</div>

<div class="container pb-6 pt-6">

    <?php 
        require_once "./php/main.php";

        if( isset($_POST['module_searcher']) ){
            require_once "./php/search.php";
        }

        if ( !isset($_SESSION['user_search']) || empty($_SESSION['user_search'])) {
            
        
    ?>
        <div class="columns">
            <div class="column">
                <form action="" method="POST" autocomplete="off" >
                    <input type="hidden" name="module_searcher" value="user">   
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <input class="input is-rounded" type="text" name="txt_searcher" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                        </p>
                        <p class="control">
                            <button class="button is-info" type="submit" >Buscar</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    <?php 
        } else {
    ?>
        <div class="columns">
            <div class="column">
                <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off" >
                    <input type="hidden" name="module_searcher" value="user"> 
                    <input type="hidden" name="delete_search" value="user">
                    <p>Estas buscando <strong>“<?php echo $_SESSION['user_search'] ?>”</strong></p>
                    <br>
                    <button type="submit" class="button is-danger is-rounded">Eliminar busqueda</button>
                </form>
            </div>
        </div>

    <?php
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
            $search = $_SESSION['user_search'];
            
            require_once './php/user_list.php';
    
        }
    ?>

    
</div>