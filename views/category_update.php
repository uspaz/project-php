<?php 
    require_once "./php/main.php";
    $id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0;
    $id = clear_texts($id)
?>

<div class="container is-fluid mb-6">
    <?php if( $id == $_SESSION['id'] ){ ?>
	    <h1 class="title">Mi cuenta</h1>
	    <h2 class="subtitle">Actualizar datos de cuenta</h2>
    <?php }else{ ?>
        <h1 class="title">Usuarios</h1>
	    <h2 class="subtitle">Actualizar usuario</h2>
    <?php }; ?>
</div>

<div class="container pb-6 pt-6">

    <?php 
        include "./inc/btn_back.php";

        $id = (isset($_GET['category_id_up'])) ? $_GET['category_id_up'] : 0;
        $id = clear_texts($id);
        
        $checkCategory = connection()->query("SELECT * FROM categoria WHERE category_id = '$id'");
        if ( $checkCategory->rowCount() > 0) {
            $category = $checkCategory->fetch();
    ?>
	<div class="form-res mb-6 mt-6"></div>

	<form action="./php/update_category.php" method="POST" class="FormAjax">

		<input type="hidden" name="category_id" value="<?php echo $category['category_id'] ?>" required/>
		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" value="<?php echo $category['category_name'] ?>" name="category_name" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required />
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Ubicación</label>
				  	<input class="input" type="text" value="<?php echo $category['category_ubication'] ?>" name="category_ubication" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{5,150}" maxlength="150" />
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
    <?php 
        }else{
            include "./inc/error.php";
        }
        $checkCategory = null;
    ?>
</div>