<?php
require '../../../../config/cookie.php';
?>
<?php
    $ns = base64_decode($_POST['ns']);
    $op = base64_decode($_POST['op']);
    //echo $ns;
    include ('../../../../config/conectasql.php');
    $nuevoselect = new conectasql();
    $nuevoselect->abre_conexion("0");
   
    if($op == 'suc'){
        $nuevoselect->selects_creator('select * from sucursales where plaza_id='.$ns.' order by suc_id', 'sucursales', 'suc_id', 'suc_nombre', 'sucursal', 'onChange="ver_comisiones(); ver_salarios();"');
         echo $nuevoselect->select;
    }else if($op == 'sal'){
        $nuevoselect->selects_creator('select * from salarios where suc_id='.$ns.' order by sal_id', 'salarios', 'sal_id', 'sal_nombre', 'salarios', 'onChange=""');
        echo $nuevoselect->select;
    }else if($op == 'coms'){
        $nuevoselect->select_multiple('select * from comisiones where suc_id='.$ns.' order by co_id', 'comisiones', 'co_id', 'co_nombre', 'comisiones', 'onChange=""');
        echo $nuevoselect->select;
    }else if($op == 'suc2'){
        $nuevoselect->selects_creator('select * from sucursales where plaza_id='.$ns.' order by suc_id', 'sucursales2', 'suc_id', 'suc_nombre', 'sucursal', 'onChange="ver_jefes();"');
        echo $nuevoselect->select;
    }else if($op == 'jefe'){
        $nuevoselect->selects_creator('select * from puestos where plaza_id='.$ns.' order by puesto_id', 'jefes', 'puesto_id', 'puesto_nombre', 'jefes', 'onChange=""');
        echo $nuevoselect->select;
    }
    $nuevoselect->cierra_conexion("0");
?>
