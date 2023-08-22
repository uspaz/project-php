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
        
        $checkUser = connection()->query("SELECT * FROM usuario WHERE user_id = '$id'");
        if ( $checkUser->rowCount() > 0) {
            $user = $checkUser->fetch();
    ?>
	<div class="form-res mb-6 mt-6"></div>

	<form action="./php/user_update.php" method="POST" class="FormAjax"  >

		<input type="hidden" name="user_id" value="<?php echo $user['user_id'] ?>" required />
		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombres</label>
				  	<input class="input" type="text" value="<?php echo $user['user_name'] ?>" name="user_name" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Apellidos</label>
				  	<input class="input" type="text" value="<?php echo $user['user_lastname'] ?>" name="user_lastname" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" value="<?php echo $user['user'] ?>" name="user" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" value="<?php echo $user['user_email'] ?>" name="user_email" maxlength="70" >
				</div>
		  	</div>
		</div>
		<br><br>
		<p class="has-text-centered">
			SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
		</p>
		<br>
		<div class="columns">
			<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="user_password" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Repetir clave</label>
				  	<input class="input" type="password" name="user_pass_conf" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
				</div>
		  	</div>
		</div>
		<br><br><br>
		<p class="has-text-centered">
			Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
		</p>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Usuario</label>
				  	<input class="input" type="text" name="admin_user" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="admin_pass" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
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
        $checkUser = null;
    ?>
</div>