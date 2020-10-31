<?php 
    require '../../../../config/cookie.php';
?>
<?php
  //ESTILOS...

  echo '<link href="../styles.css" type="text/css" rel="stylesheet">';

  //CONFIGURACIONES
  setlocale(LC_MONETARY, 'es_MX'); //Locacion para el formato de moneda...   
  date_default_timezone_set('America/Mexico_City');
  $fecha=date("Ymd");
  $hora=date("H:i:s");
  

  //include ('../../../../../config/conectasql.php');
  include ('../sql.php');
  session_start();
  $usid=$_SESSION['us_id'];
  $con= new sqlad();
  $con->abre_conexion("0");
  $conexion=$con->conexion;
  $op = base64_decode($_POST['op']);
  $plaza= $_POST['plazas']; $text=$_POST['plazas.text'];
  $sucursal= $_POST['sucursales'];
  $archivo = $_FILES['archivo']['tmp_name'];
 
  /* LECTURA DEL ARCHIVO DE EXCEL*/
  include '../lib/phpexcel/Classes/PHPExcel.php';
  include '../lib/phpexcel/Classes/PHPExcel/IOFactory.php';

  $inputFileType = 'Excel2007';
  $objReader = PHPExcel_IOFactory::createReaderForFile($archivo);
  $objPHPExcel = $objReader->load($archivo);
  $sheet = $objPHPExcel->getSheet(0); 
  $highestRow = $sheet->getHighestRow(); 
  $highestColumn = $sheet->getHighestColumn();
  $num=1;

  //Temporales
  $con->plaza_suc($plaza, $sucursal);

    echo '<div class="cont2">';
      echo '<div id="barra_T">';
        echo '<div class="row">';
          echo '<div class="col-3">';
          
            echo '<label class="titulo_2">Plaza: </label>';
            echo '<label>'.$con->plazaN.'</label><br>';
            echo '<label class="titulo_2">Sucursal: </label>';
            echo '<label>'.$con->sucursalN.'</label>';
          echo '</div>';
          echo '<div class="col-3">';

          echo '</div>';
          echo '<div class="col-6">';
          echo '<h1 class="titulo_1">Nomina</h1>';    
           
          echo '</div>';
        echo '</div>';
      echo '</div>';

          $sqls="select * from comisiones where emp_id = 4 order by co_id";
          $result=pg_query($conexion,$sqls) or die("Error cnlt: ". pg_last_error());
          $no_rows = pg_num_rows($result);
          $rowprs= pg_fetch_array($result);
          $data=$rowprs;

      echo '<div class="row">';
        echo '<div class="columnaNombre">';
          echo '<label>Nombre</label>';
        echo '</div>';
          echo '<div class="columnaCobranza">';
          echo '<input class="ajustable" name="ing"'.$num.'" value="XP">';
      echo '</div>';

      while ($row = pg_fetch_row($result)) {
        echo '<div class="columnaCobranza">';
            echo '<input class="ajustable" name="col'.$row[0].'" value="'.$row[1].'">';
        echo '</div>';
      }

    echo '</div>';

    echo '<form action="">';
      
      for ($row = 2; $row <= $highestRow; $row++){ 
        $num++;
        $cob = $sheet->getCell('A'.$row)->getFormattedValue();
        $ing = $sheet->getCell('B'.$row)->getValue();

      /*
        $sql="insert into public.b_xps(plaza_id, fecha, nombre, cantidad, user_id, tipo, no_nomina)" 
        ."VALUES($plaza, '$fecha', '$cob', $ing, $usid, 'Ingreso', 5);";
        pg_query($conexion, $sql) or die("Error db: ".pg_last_error());
      */

        echo '<div class="row">';
          echo '<div class="columnaNombre">';
            echo '<input class="ajustable" name="nom'.$num.'" value="'.$cob.'" readonly>';
          echo '</div>';
          $ingp = $ing*0.07;

          echo '<div class="columnaCobranza">';
              echo '<input class="ajustable" name="xp'.$num.'" value="'.money_format('%n', $ing).'">';
            echo '</div>';
          echo '<div class="columnaCobranza">';
              echo '<input class="ajustable" name="cf'.$num.'" value="'.money_format('%n', $ingp).'">';
            echo '</div>';
          for ($i=1; $i < 15; $i++) { 
            echo '<div class="columnaCobranza">';
              echo '<input class="ajustable" name="ing'.$num.'" value="">';
            echo '</div>';
          }
        
        echo '</div>';
      }

      echo '<div class="row">';

        echo '<button type="button" id="forward" onclick="valida_campos(\''.$op.'\');" class="btn_aceptar" > Guardar </button>'; 
        echo '<button type="button" id="forward" onclick="valida_campos(\''.$op.'\');" class="btn_xls " > Exportar </button>';   
        echo '<button type="button" id="cancel"  onclick="self.close();"    class="btn_cancelar" >Cancelar</button>';

      echo '</div>';

    echo '</form>';
  echo '</div>';

  $con->cierra_conexion("0");
?>
