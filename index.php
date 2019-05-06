<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<title>Backoffice</title>
</head>
<body>
<div class="container">
<!-- Modal -->
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <img src="img/logo.jpg"/>
            </div> 
            <!-- Modal Body -->
            <div class="modal-body">
				<?php
				if (isset($_GET['e'])) {
				echo "<div class=\"alert alert-warning\" role=\"alert\">Los datos introducidos no son correctos. Inténtalo de nuevo.</div>";
				} else {}
				?>
                <form enctype="multipart/form-data" id="entrar" name="entrar" action="principal.php" method="post">
                  <div class="form-group">
                    <label for="usuario">Nombre de usuario</label>
                      <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario"/>
                  </div>
                  <div class="form-group">
                    <label for="pass">Contraseña</label>
                      <input type="password" class="form-control" name="pass" id="pass" placeholder="Contraseña"/>
                  </div>
                  <button type="submit" class="btn btn-info">Entrar</button>
                </form>
                
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <span></span>
            </div>
        </div>
    </div>
</div>
    </div>



<!-- Llamadas a los jS, para que cargue al final y ahorrarnos tiempo -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
</body>
</html>
