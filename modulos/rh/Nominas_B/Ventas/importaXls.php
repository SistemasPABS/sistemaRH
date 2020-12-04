<?php 
    require '../../../../config/cookie.php';
?>

<?php
  //ESTILOS...
  echo '<link href="../styles.css" type="text/css" rel="stylesheet">';
  //CONFIGURACIONES
  setlocale(LC_MONETARY, 'es_MX'); //Locacion para el formato de moneda...   
  date_default_timezone_set('America/Mexico_City'); //para obtener decha y hora...
  $fecha=date("Ymd"); 
  $hora=date("H:i:s");
  
  include ('../sql.php'); 
  echo '<script  src="./functions.js"></script>';
  echo '<script type="text/javascript" src="./exportarXls.js"></script>';

  //Operaciones sql
  /**Recuperacione de inicio de sesion */
  session_start();
  $usid=$_SESSION['us_id'];
  
  $con= new sqlad();
  $con->abre_conexion("0");
  $conexion=$con->conexion;
 
  /*Recibimos valores del post */
  $op = base64_decode($_POST['op']);
  $plaza= $_POST['plazas']; 
  $text= $_POST['plazas.text'];
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
  $num=0;
  $fila=0;
  
  //Temporales
  $con->plaza_suc($plaza, $sucursal);

    echo '<div class="cont2">';
/**************************Cabecera de la nomina*************************************/      
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
/**************************Fin CAbecera***********************************************/  

/*******************************Header de la tabla - comisiones************************/
//$sucursal
  
      $sqls="select * from comisiones where emp_id = 1 and suc_id = '13' order by co_id";
      $result=pg_query($conexion,$sqls) or die("Error X: ". pg_last_error());
      
      
      echo '<table id="nominaTb" class="blueTable">';
        echo '<thead>';
          echo '<tr>';
            echo '<td>No</td>';
            echo '<td>Nombre</td>';
            echo '<td>Comision Xp</td>';
            while ($row = pg_fetch_row($result)) {
              $num++;
              echo '<td id="'.$row[0].'">'.$row[1].'</td>';
            }
          echo '</tr>';
        echo '</thead>'; 

 /******************************* Unificando nombres *************************************/
      $sqlsP="select persona_id, nombrecompleto from vw_personas where plaza_id = 4 order by nombrecompleto";
      $resultP=pg_query($conexion,$sqlsP) or die("Error A: ". pg_last_error());
      
      while ($rowA = pg_fetch_row($resultP)) {
       
        $idP = $rowA[0];
        $nombreP = $rowA[1];
       // echo $idP."   ". $nombreP ."</br>";
        
        $ex = 0;
        $total = 0;
        
        $sqlB = "select * from alias_personas where persona_id = $idP";
        $resultB = pg_query ($conexion,$sqlB);
                     
        while ($rowB = pg_fetch_row($resultB)) {
          $idAlias = $rowB[0];
          $alias = $rowB[2];

        //  echo $alias;
          for ($row = 2; $row <= $highestRow; $row++){ 
            
            $cob = $sheet->getCell('A'.$row)->getFormattedValue();
            $ing = $sheet->getCell('B'.$row)->getValue();

            if ($alias === $cob) {
              $ex = 1;
              $total = $total + $ing;
            }

          }
                
        }
        if ($ex == 1) {
        //  if ($total!=0){ //ELIMINA LAS FILAS DEL XP CON CANTIDADES EN 0 

          $fila = $fila+1;
          echo '<tr>';
            
            echo '<td>'.$fila.'</td>';
            echo '<td id="'.$idP.'">'.$nombreP.'</td>';
            
/**/            echo '<td> '.money_format('%n', $total).'</td>';
          
          for ($i=0; $i < $num; $i++) { 
/**/            echo '<td contenteditable="true"> '.money_format('%n', "0").'</td>';
          }
          echo '</tr>';
        //}

      }

        
      }
      
      /**************************Validacion de alias no registrados en sistema ********************/

      for ($row = 2; $row <= $highestRow; $row++){ 
            
        $cob = $sheet->getCell('A'.$row)->getValue();
        $ing = $sheet->getCell('B'.$row)->getValue();
        
        $sqlC = "select * from alias_personas where alias = '$cob'";
        $resultC = pg_query($conexion, $sqlC) or die("Error X: ". pg_last_error());
        
        $rs = pg_fetch_assoc($resultC);
        if (!$rs) {
          $fila = $fila+1;
          echo '<tr>';
              echo '<td>'.$fila.'</td>';
              echo '<td id="no_asig" onclick="popup(\'./agrega_alias.php\',\''. base64_encode($plaza).'\',\''. base64_encode($cob).'\',\''. base64_encode($plaza).'\');">'.$cob.'</td>';
/**/              echo '<td>'.money_format('%n', $ing).'</td>';
            
              for ($i=0; $i < $num; $i++) { 
/**/                echo '<td contenteditable="true"> '.money_format('%n', "0").'</td>';
              }
          echo '</tr>';
        }
      }


      /***************************Fin de validacion ***********************************************/
      echo '</table>';
    echo '<form action="">';
      
    
      /*
        $sql="insert into public.b_xps(plaza_id, fecha, nombre, cantidad, user_id, tipo, no_nomina)" 
        ."VALUES($plaza, '$fecha', '$cob', $ing, $usid, 'Ingreso', 5);";
        pg_query($conexion, $sql) or die("Error db: ".pg_last_error());
      */

       
/**Accíones para  */
      echo '<div class="row">';
        echo '<button type="button" id="forward" onclick="valida_campos(\''.$op.'\');" class="btn_aceptar" > Guardar </button>'; 
        echo '<button type="button" id="forward" onclick="exportTableToExcel(nominaTb)" class="btn_xls " > Exportar </button>';   
        echo '<button type="button" id="cancel"  onclick="self.close();"    class="btn_cancelar" >Cancelar</button>';
       echo '</div>';
      echo '</form>';
  echo '</div>';
  $con->cierra_conexion("0");
?>
