<!DOCTYPE html>
<html>
<head>
	<title>Leer Archivo Excel usando PHP</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<h2>Importacion - PABS a RH</h2>	
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Resultados de archivo de Excel.</h3>
      </div>
      <div class="panel-body">
        <div class="col-lg-12">
            
<?php
require_once '../../../../librerias/phpexcel/Classes/PHPExcel.php';
$archivo = "Importacion_03092020_localhost_test.xlsx";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0);
$ventas = $objPHPExcel ->getSheet(1); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();?>

<table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Clave</th>
          <th>Monto</th>
          <th>Porcentaje</th>
          <th>Monto A Pagar</th>
        </tr>
      </thead>
      <tbody>


<?php
$num=0;
for ($row = 2; $row <= $highestRow; $row++){ $num++;?>
       <tr>
          <th scope='row'><?php echo $num;?>'- Cobranza -'</th>
          <td><?php echo $sheet->getCell("E".$row)->getValue();?></td>
          <td><?php echo $sheet->getCell("F".$row)->getValue();?></td>
          <td><?php echo $sheet->getCell("G".$row)->getValue();?></td>
          <td><?php echo $sheet->getCell("H".$row)->getValue();?></td>
        </tr>

        <tr>
          <th scope='row'><?php echo $num ;?>'- Ventas -'</th>
          <td><?php echo $ventas->getCell("E".$row)->getValue();?></td>
          <td><?php echo $ventas->getCell("F".$row)->getValue();?></td>
          <td><?php echo $ventas->getCell("G".$row)->getValue();?></td>
          <td><?php echo $ventas->getCell("H".$row)->getValue();?></td>
        </tr>
    	
	<?php	
}
?>
          </tbody>
    </table>
  </div>	
 </div>	
 <input type="button">Guardar informacion en sistema y continuar</input>
</div>
</body>
</html>