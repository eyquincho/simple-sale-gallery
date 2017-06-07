<?php
session_start();
header('Content-Type: text/html; charset=UTF-8'); 
ob_start();
require("php/class.upload.php");
include("php/conDB.php");
conexionDB();

$tabla_usuarios = "usuarios";
$tabla_oportunidades = "oportunidades";

//Añadir elemento
function SumarOcasion () {
//Actualizar datos una vez pulsado el actualizar
	if (isset ($_POST['NewOcasionAdded'])) {
		if (!isset ($_POST['TituloNuevoOcasion'],$_POST['DescNuevoOcasion'],$_POST['PrecioNuevoOcasion'])) {
			echo "<div class=\"alert alert-danger\" role=\"alert\">Debes completar todos los campos a la hora de añadir un nuevo elemento. Inténtalo de nuevo.</div>";
			echo $_POST['TituloNuevoOcasion'].$_POST['DescNuevoOcasion'].$_POST['PrecioNuevoOcasion'].$_POST['ConsultarPrecio'];
		} else {
			$NuevoNombre = $_POST['TituloNuevoOcasion'];
			$NuevoDesc = $_POST['DescNuevoOcasion'];
			$NuevoPrecio = $_POST['PrecioNuevoOcasion'];
			$NuevoFoto = $_POST['FotoNuevoOcasion'];
			
			if (isset ($_POST['ConsultarPrecio'])) {
				$NuevoCons = 1;
			} else {
				$NuevoCons = 0;
			}
			
			//Implementar class.upload.php
			//https://github.com/verot/class.upload.php
			//La variable que viene es $FotoNuevoOcasion
			$handle = new upload($_FILES['FotoNuevoOcasion']);
			if ($handle->uploaded) {
			  $handle->file_new_name_body   = $NuevoNombre;
			  $handle->file_name_body_add	= '_volgruma.com';
			  $handle->file_name_body_pre	= 'oportunidad_';
			  $handle->file_safe_name = true;
			  $handle->image_resize         = true;
			  $handle->image_x              = 440;
			  $handle->image_y              = 320;
			  $handle->image_ratio        	= true;
			  $handle->process('img/op/');
			  if ($handle->processed) {
				$NuevoFoto = $handle->file_dst_pathname;
				$handle->clean();
			  } else {
				echo 'error : ' . $handle->error;
			  }
			}
			
			//Falta por asignar los nombres correctos de las columnas
			//Hay que añadir una columna nueva a la base de datos que sea "consultar" dónde meta el dato que acabo de recoger
			$save_newocasion= "INSERT INTO `oportunidades`(`titulo`, `descripcion`, `precio`, `foto`, consultar) VALUES ('$NuevoNombre','$NuevoDesc','$NuevoPrecio','$NuevoFoto','$NuevoCons')";
			if (mysqli_query($_SESSION['con'], $save_newocasion)or die(mysqli_error($_SESSION['con']))) {
				echo "<div class=\"alert alert-success\" role=\"alert\">Añadido <strong>".$NuevoNombre."</strong> correctamente</div>";
			}else {
				echo "<div class=\"alert alert-warning\" role=\"alert\">Ha ocurrido un error y no se han podido guardar los cambios.</div>";
			}
		}
	}else {}
}

function BorrarOcasion () {
//Actualizar datos una vez pulsado el actualizar
if (isset ($_POST['DeleteOcasion'])) {
	$IDCadaver = $_POST['IDOcasion'];
	$NombreCadaver = $_POST['NombreOcasion'];
	$delete_op= "DELETE FROM `oportunidades` WHERE `ID` = '$IDCadaver'";
					if (mysqli_query($_SESSION['con'], $delete_op)or die(mysqli_error($_SESSION['con']))) {
									echo "<div class=\"alert alert-success\" role=\"alert\"><em>Au revoir</em> <strong>".$NombreCadaver."</strong></div>";
								}else {
									echo "<div class=\"alert alert-warning\" role=\"alert\">Ha ocurrido un error y no se han podido guardar los cambios.</div>";
								}
}else {}
}

function EdicionOcasion () {
//Actualizar datos una vez pulsado el actualizar
if (isset ($_POST["EdicionOcasion"])) {
	$IDOcasion = $_POST["IDOcasion"];
	$NuevoTitulo = $_POST["EditarTitulo".$IDOcasion];
	$NuevoDescripcion = $_POST["EditarDescripcion".$IDOcasion];
	$NuevoPrecio = $_POST["EditarPrecio".$IDOcasion];
	$guardar_actualizacion= "UPDATE oportunidades SET `titulo`='$NuevoTitulo',`descripcion`='$NuevoDescripcion',`precio`='$NuevoPrecio' WHERE `id`= '$IDOcasion'";
					if (mysqli_query($_SESSION['con'], $guardar_actualizacion)or die(mysqli_error($_SESSION['con']))) {
									echo "<div class=\"alert alert-success\" role=\"alert\">Has editado el artículo <strong>".$NuevoOcasion."</strong> correctamente</div>";
								}else {
									echo "<div class=\"alert alert-danger\" role=\"alert\">Ha ocurrido un error y no se han podido guardar los cambios.</div>";
								}	
				}
else {}
}
// Definimos $usuario y lo purgamos, por si hay cosas malas

if (!isset($_SESSION["usuario"])) {
	// Definimos $dni y lo purgamos, por si hay cosas malas

	$user=$_POST['usuario'];

	$user = mysqli_real_escape_string($_SESSION['con'], $user);
	$pass = md5($_POST['pass']);

	// Vemos si el dni está en la BBDD
	$sql="SELECT * FROM $tabla_usuarios WHERE usuario='$user' AND pass='$pass'";
	$result=mysqli_query($_SESSION['con'], $sql);
	$usuario = mysqli_fetch_object($result);

	// Contamos cuantas lineas salen en el resultado, si es 1, es que existe
	$existe=mysqli_num_rows($result);

	if($existe==0){
		//Si no existe, mostrar mensaje y botón de volver
		header("location:index.php?e=1");
	}
	else {
		//Si existe guardo la variable usuario como variable de sesión
		$usuario = $usuario->usuario;
		$_SESSION["usuario"]= $usuario;
	}
}else {}


	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<title>Backend</title>
</head>
<body>
<div class="container">

<div class="row">
<a href="principal.php"><img src="img/logo.jpg" /></a>
	<?php 
		EdicionOcasion();
	  	SumarOcasion ();
		BorrarOcasion ();
	?>
	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#NewOcasion"><i class="fa fa-user-plus" aria-hidden="true"></i> Añadir oportunidad</button>
	<hr>
	<table class="table table-responsive">
	<thead>
    <tr>
      <th>#</th>
      <th>Título</th>
      <th>Descripción</th>
      <th>Precio</th>
	  <th>Foto</th>
	  <th>Edición</th>
    </tr>
	  </thead>
	  <tbody>
	<?php
		//Sacamos todos los datos de los elementos que haya en la tabla
		$sql_oportunidades="SELECT * FROM $tabla_oportunidades";
		$result_oportunidades=mysqli_query($_SESSION['con'], $sql_oportunidades);
		while ($oportunidad = mysqli_fetch_object($result_oportunidades)){
	?>
	
	<tr>
		<th scope="row"><?php echo $oportunidad->ID; ?></th>
		<td width="10%"><?php echo $oportunidad->titulo; ?></td>
		<td width="30%"><?php echo $oportunidad->descripcion; ?></td>
		<?php $numero = number_format($oportunidad->precio, 2, ',', '.'); ?>
		<td width="10%"><strong><?php echo $numero; ?> €</strong></td>
		<td width="30%"><img src="<?php echo $oportunidad->foto; ?>" width="100%" /></td>
		<td width="20%"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#editar<?php echo $oportunidad->ID; ?>"><i class="fa fa-cogs" aria-hidden="true"></i></button><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#borrar<?php echo $oportunidad->ID; ?>"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
	</tr>
	
	<!-- Modal Editar oportunidad -->
	<div class="modal fade" id="editar<?php echo $oportunidad->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="CabeceraEdit" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
			<h4 class="modal-title" id="CabeceraEdit">Editar oportunidad</h4>
		  </div>
		  <div class="modal-body">
			<form enctype="multipart/form-data" id="FormEditOcasion" name="edit_ocasion" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="form-group">
					<label for="EditarTitulo<?php echo $oportunidad->ID; ?>">Titulo</label>
					<input type="text" class="form-control" name="EditarTitulo<?php echo $oportunidad->ID; ?>" value="<?php echo $oportunidad->titulo; ?>">
				</div>
				<div class="form-group">
					<label for="EditarDescripcion<?php echo $oportunidad->ID; ?>">Descripción</label>
					<input type="textarea" rows="5" class="form-control" name="EditarDescripcion<?php echo $oportunidad->ID; ?>" value="<?php echo $oportunidad->descripcion; ?>">
				</div>
				<div class="form-group">
					<label for="EditarPrecio<?php echo $oportunidad->ID; ?>">Precio</label>
					<input type="text" class="form-control" name="EditarPrecio<?php echo $oportunidad->ID; ?>" value="<?php echo $oportunidad->precio; ?>">
				</div>
				<input type="hidden" name="IDOcasion" value="<?php echo $oportunidad->ID; ?>">
			  <button type="submit" class="btn btn-default" name="EdicionOcasion">Actualizar datos</button>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		  </div>
		</div>
	  </div>
	</div>	
	
	<!-- Modal Eliminar ocasion -->
	<div class="modal fade" id="borrar<?php echo $oportunidad->ID; ?>" tabindex="-1" role="dialog" aria-labelledby="CabeceraEliminar" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
			<h4 class="modal-title" id="CabeceraEliminar">Borrar oportunidad</h4>
		  </div>
		  <div class="modal-body">
			<p>Estás a punto de borrar la oportunidad <strong><?php echo $oportunidad->titulo; ?></strong>, esta acción no se puede deshacer (aunque siempre puedes crearla de nuevo...)
			<form enctype="multipart/form-data" id="FormDeleteOcasion" name="del_ocasion" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="IDOcasion" value="<?php echo $oportunidad->ID; ?>">
				<input type="hidden" name="NombreOcasion" value="<?php echo $oportunidad->titulo; ?>">
			  <button type="submit" class="btn btn-danger" name="DeleteOcasion">Eliminar elemento</button>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		  </div>
		</div>
	  </div>
	</div>	
	
	
	
	
	<?php } ?>
	</tbody>
	</table>
	<!-- Modal Añadir ocasion -->
	<div class="modal fade" id="NewOcasion" tabindex="-1" role="dialog" aria-labelledby="CabeceraNewPlayer" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
			<h4 class="modal-title" id="CabeceraNewPlayer">Añadir nueva ocasión</h4>
		  </div>
		  <div class="modal-body">
			<form enctype="multipart/form-data" id="FormEditPlayer" name="edit_player" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="form-group">
					<label for="TituloNuevoOcasion">Nombre</label>
					<input type="text" class="form-control" name="TituloNuevoOcasion">
				</div>
				<div class="form-group">				
					<label for="DescNuevoOcasion">Descripción</label>
					<input type="textarea" rows="5" class="form-control" name="DescNuevoOcasion">
				</div>
				<div class="form-group">
					<label for="PrecioNuevoOcasion">Precio</label>
					<input type="tel" class="form-control" name="PrecioNuevoOcasion">
					
				</div>
				<div class="form-group">
					<label class="form-check-label">
					<input class="form-check-input" name="ConsultarPrecio" type="checkbox"> Consultar
					</label>
				</div>
				<div class="form-group">
					<label for="FotoNuevoOcasion">Foto</label>
					<input type="file" accept="image/*"  class="form-control-file" name="FotoNuevoOcasion" id="FotoNuevoOcasion">
				</div>
			  <button type="submit" class="btn btn-default" name="NewOcasionAdded">Añadir nueva ocasión</button>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		  </div>
		</div>
	  </div>
	</div>	 
</div>


<a class="btn btn-danger" href="php/cerrar.php">
<i class="fa fa-sign-out fa-lg"></i> Cerrar sesión</a>
</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
</body>
</html>