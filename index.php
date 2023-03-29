<?php
   session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/app.css?time=<?php echo time(); ?>">
	<title>Agregar atributos a fichas de producto Prestashop</title>
</head>
<body>
<div class="container">
	<div class="row mt-5">
		<h1>Agregar atributos a fichas de producto Prestashop</h1>
		<div class="card col-10 mt-3">
			<div class="card-body">
			<?php
					include "includes/notification.php";
			?>
			<form action="upload.php" method="POST" enctype="multipart/form-data">
				<div class="col-12 mb-3">
					<label class="mb-2">Seleccionar archivo .csv:</label>
					<input type="file" class="form-control" name="file">
				</div>
				<div class="col-5">
					<button type="submit" class="btn btn-success" name="btnSubmit">Procesar</button>
				</div>
			</form>
			</div>
		</div>      
	</div>
</div>
</body>
</html>