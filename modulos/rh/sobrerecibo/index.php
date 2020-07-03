<?php 
include_once ('../prenominas/index.php');
include_once ('../../../config/conectasql.php');
session_start();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Ymd");
$hora=date("H:i:s");
$us_id=$_SESSION['us_id'];
$plaza=base64_decode($_GET['oc1']);//plaza
$empid=base64_decode($_GET['oc2']); //empid
$tipoperiodo=base64_decode($_GET['oc3']);//tipoperiodo
$fechaperiodo=base64_decode($_GET['oc4']); //fechaperiodo
$numservicios=base64_decode($_GET['oc5']);//numservicios
$ventasdirectas=base64_decode($_GET['oc6']);//ventasdirectas
$cobrosporventa=base64_decode($_GET['oc7']);//cobrosporventa
$saldo=base64_decode($_GET['oc8']);//saldo
$cobrosanteriores=base64_decode($_GET['oc9']);//cobrosanteriores
$observaciones=base64_decode($_GET['oc10']);//observaciones
$pc=gethostbyaddr($_SERVER['REMOTE_ADDR']);//computadora de donde se hace
/*echo $oc1,$oc2,$oc3,$oc4,$oc5,$oc6,$oc7,$oc8,$oc9,$oc10;*/
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;

$sql1="SELECT * FROM periodos WHERE idperiodo=$fechaperiodo";
$result1 = pg_query($conexion,$sql1) or die("Error al obtener los periodos");
$row1 = pg_fetch_array($result1);

$sql2="INSERT into tmp_base_nom (us_id,fecha,hora,plaza_id,num_ventas,venta_directa,cobros,saldo,cobros_per_ant,observaciones,emp_id,sal_tipo_id,fecha_inicio,fecha_fin,pc) values ($us_id,'$fecha','$hora',$plaza,$numservicios,$ventasdirectas,$cobrosporventa,$saldo,$cobrosanteriores,'$observaciones',$empid,$tipoperiodo,'".$row1['fecha_inicio']."','".$row1['fecha_final']."','$pc')";
$result2 = pg_query($conexion,$sql2) or die("Error en la insercion de datos temporales de base nom");

$sql3="select * from vw_contratos where con_status = 1 and sal_tipo_id = $tipoperiodo and emp_id  = $empid and plaza_id = $plaza";
$result3= pg_query($conexion,$sql3);
if($row3= pg_fetch_array($result3)){
    do{
        $monos.= '
        <tbody>
                <tr>
                    <td colspan="20" class="page-header">
                        <input hidden value="'.$row3['persona_id'].'" name="persona[]"></input>
                        <button type="button" class="tbtn"><i class="fa fa-plus-circle fa-minus-circle"></i>'.$row3['nombrecompleto'].'</button>
                        <button type="button"  onclick="traerpercepcionesdeducciones(\'percepcion\',this)">Agregar percepcion</button>   
                        <button type="button"  onclick="traerpercepcionesdeducciones(\'deduccion\',this)">Agregar deduccion</button>
                        
                    </td>
                    
                </tr>
                <tr class="toggler toggler1">
                        
                        <td rowspan="9999"></td>
                            
                            <td>SUELDO DE LA PERSONA</td>
                            <td><input  class="sueldo" value="'.$row3['persona_id'].'"  name="'.$row3['persona_id'].'sueldo[]" hidden></input></td>
                            <td></td>
                            <td><input type="number" name="'.$row3['persona_id'].'cantidadsuelo[]" value="'.$row3['sal_monto_con'].'" readonly></input></td>
                            <td><input type="text" name="'.$row3['persona_id'].'observacionessueldo[]"></input></td>
                      </tr>
                    </tbody>
                
                
        ';
        //$monos.= $row3['persona_id'].'--'.$row3['nombrecompleto'].'<br>';
        
        $sql4="select * from vw_puestos_comisiones where persona_id = ".$row3['persona_id']." and co_activo = 1;";
        $result4= pg_query($conexion,$sql4);
        if($row4= pg_fetch_array($result4)){
            do{
            $monos .='
                      
                      <tr class="toggler toggler1">
                        
                        <td rowspan="9999"></td>
                            
                            <td><input value="'.$row4['co_id'].'" name="'.$row3['persona_id'].'comision[]" hidden>'.$row4['co_nombre'].'</td>
                            <td>'.$row4['co_monto'].'</td>
                            <td>'.$row4['co_porcentaje'].'</td>
                            <td><input type="number" name="'.$row3['persona_id'].'cantidadcom[]"></input></td>
                            <td><input type="text" name="'.$row3['persona_id'].'observacionescom[]"></input></td>
                      </tr>
                    </tbody>';
                //$monos.='*'.$row4['co_id'].'--'.$row4['co_nombre'].'<br>';
                
            }while ($row4 = pg_fetch_array($result4));
         //$monos.='</tbody>';  
        }
        
    }while($row3= pg_fetch_array($result3));
    
}else{
    echo 'No hubo personas que cumplan con los criterios capturados';
}


?>

<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
        <script src="../prenominas/styles/navbar2.js"></script>
        <script src="../prenominas/styles/jquery.js"></script> 
        <script src="validador.js"></script>
    </head>
    
    
    <style>
        .custom-table{border-collapse:collapse;width:100%;border:solid 1px #c0c0c0;font-family:open sans;font-size:11px}
            .custom-table th,.custom-table td{text-align:left;padding:8px;border:solid 1px #c0c0c0}
            .custom-table th{color:#000080}
            .custom-table tr:nth-child(odd){background-color:#f7f7ff}
            .custom-table>thead>tr{background-color:#dde8f7!important}
            .tbtn{border:0;outline:0;background-color:transparent;font-size:13px;cursor:pointer}
            .toggler{display:none}
            .toggler1{display:table-row;}
            .custom-table a{color: #0033cc;}
            .custom-table a:hover{color: #f00;}
            .page-header{background-color: #416db0;}

            .sueldo{
                color: "#FFFFF";
            }
    </style>
    
    <script>
            $(document).ready(function () {
                $(".tbtn").click(function () {
                    $(this).parents(".custom-table").find(".toggler1").removeClass("toggler1");
                    $(this).parents("tbody").find(".toggler").addClass("toggler1");
                    $(this).parents(".custom-table").find(".fa-minus-circle").removeClass("fa-minus-circle");
                    $(this).parents("tbody").find(".fa-plus-circle").addClass("fa-minus-circle");
                    
                });
            });
    </script>
    
    <form name="todalanomina" method="POST" action="crearnomina.php">
    <body>
        <div class="container" id="contenedor"></div>
        <input hidden id="cantpersonas" name="cantpersonas" value=""></input>
        <table class="custom-table">
            <thead>
                <tr> <input hidden value="<?php echo $pc?>" name="pc"></input>
                    <input hidden value="<?php echo $fechaperiodo?>" name="idperiodo"></input>
                    <input hidden value="<?php echo $plaza?>" name="plaza"></input>
                    <input hidden value="<?php echo $tipoperiodo?>" name="tipoperiodo"></input>
                    <input hidden value="<?php echo $empid?>" name="empid"></input>
                    <th>Persona</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Porcentaje</th>
                    <th>Cantidad</th> 
                    <th>Observaciones</th>
                </tr>
            </thead>
            <?php echo $monos ?>
            
        </table>
        
        <button id="submit" type="submit" onclick="enviarnomina()">GUARDAR NOMINA</button>
    </form>    
</div>
</body>
</html>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

<!--- SCRIPT PARA MANEJO DE CALCULOS PESTAÑA PERCEPCIONES
<script>
$(document).ready(function(){
	
	option_list('addr0');
	
    var i=1;
    $("#add_row").click(function(){b=i-1;
      	$('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
      	$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
		option_list('addr'+i);
      	i++; 
  	});
    $("#delete_row").click(function(){
    	if(i>1){
		$("#addr"+(i-1)).html('');
		i--;
		}
		calc();
	});
	
	$(".product").on('change',function(){
	    option_checker(this)
	});
	
	
	$('#tab_logic tbody').on('keyup change',function(){
		calc();
	});
	$('#tax').on('keyup change',function(){
		calc_total();
	});

});

function option_checker(id)
{
	var myOption=$(id).val();
	var s =0;
	$('#tab_logic tbody tr select').each(function(index, element){
         var myselect = $(this).val();
		if(myselect==myOption){
			s += 1;
		}
    });
	if(s>1){
		alert(myOption+' Ya se agregó, intenta con una nueva...')	
	}
}

function option_list(id)
{
	el='#'+id;
	var myArray = ["Percepcion 1", "Percepcion 2", "Percepcion 3", "Percepcion 4"];
	var collect = '<option value="">Percepciones</option>';
    for(var i = 0; i<myArray.length;i++){
        collect += '<option value="'+myArray[i]+'">'+myArray[i]+'</option>';
    }
    $(el+" select").html(collect);
}

function calc()
{
	$('#tab_logic tbody tr').each(function(i, element) {
		var html = $(this).html();
		
			var qty = $(this).find('.qty').val();
			var price = $(this).find('.price').val();
			$(this).find('.total').val(qty*price);
			
			calc_total();
    });
}

function calc_total()
{
	total=0;
	$('.total').each(function() {
        total += parseInt($(this).val());
    });
	$('#sub_total').val(total.toFixed(2));
	tax_sum=total/100*$('#tax').val();
	$('#tax_amount').val(tax_sum.toFixed(2));
	$('#total_amount').val((tax_sum+total).toFixed(2));
}
</script>

<!--- SCRIPT PARA MANEJO DE CALCULOS PESTAÑA DEDUCCIONES
<script>
$(document).ready(function(){
	
	option_list2('addr2');
	
    var i=1;
    $("#add_row").click(function(){b=i-1;
      	$('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
      	$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
		option_list2('addr'+i);
      	i++; 
  	});
    $("#delete_row").click(function(){
    	if(i>1){
		$("#addr"+(i-1)).html('');
		i--;
		}
		calc2();
	});
	
	$(".product").on('change',function(){
	    option_checker2(this)
	});
	
	
	$('#tab_logic tbody').on('keyup change',function(){
		calc2();
	});
	$('#tax').on('keyup change',function(){
		calc_total2();
	});

});

function option_checker2(id)
{
	var myOption=$(id).val();
	var s =0;
	$('#tab_logic tbody tr select').each(function(index, element){
         var myselect = $(this).val();
		if(myselect==myOption){
			s += 1;
		}
    });
	if(s>1){
		alert(myOption+' Ya la agregaste, agrega otra...')	
	}
}

function option_list2(id)
{
	el='#'+id;
	var myArray = ["Deduccion 1", "Deduccion 2", "Deduccion 3", "Deduccion 4"];
	var collect = '<option value="">Deducciones</option>';
    for(var i = 0; i<myArray.length;i++){
        collect += '<option value="'+myArray[i]+'">'+myArray[i]+'</option>';
    }
    $(el+" select").html(collect);
}

function calc2()
{
	$('#tab_logic tbody tr').each(function(i, element) {
		var html = $(this).html();
		
			var qty = $(this).find('.qty').val();
			var price = $(this).find('.price').val();
			$(this).find('.total').val(qty*price);
			
			calc_total2();
    });
}

function calc_total2()
{
	total=0;
	$('.total').each(function() {
        total += parseInt($(this).val());
    });
	$('#sub_total').val(total.toFixed(2));
	tax_sum=total/100*$('#tax').val();
	$('#tax_amount').val(tax_sum.toFixed(2));
	$('#total_amount').val((tax_sum+total).toFixed(2));
}
</script>

<!--- SCRIPT PARA MANEJO DE CALCULOS PESTAÑA INCIDENCIAS
<script>
$(document).ready(function(){
	
    option_list3('addr3');
    var i=1;
    $("#add_row").click(function(){b=i-1;
      	$('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
      	$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        option_list3('addr'+i);
      	i++; 
  	});
    $("#delete_row").click(function(){
    	if(i>1){
		$("#addr"+(i-1)).html('');
		i--;
		}
		calc3();
	});
	
	$(".product").on('change',function(){
	    option_checker3(this)
	});
	
	
	$('#tab_logic tbody').on('keyup change',function(){
		calc3();
	});
	$('#tax').on('keyup change',function(){
		calc_total3();
	});

});

function option_checker3(id)
{
	var myOption=$(id).val();
	var s =0;
	$('#tab_logic tbody tr select').each(function(index, element){
         var myselect = $(this).val();
		if(myselect==myOption){
			s += 1;
		}
    });
	if(s>1){
		alert(myOption+' Ya se seleccionó intenta con otra...')	
	}
}



function option_list3(id)
{
	el='#'+id;
	var myArray = ["Incidencia 1", "Incidencia 2", "Incidencia 3", "Incidencia 4"];
	var collect = '<option value="">Incidencias</option>';
    for(var i = 0; i<myArray.length;i++){
        collect += '<option value="'+myArray[i]+'">'+myArray[i]+'</option>';
    }
    $(el+" select").html(collect);
}


function calc3()
{
	$('#tab_logic tbody tr').each(function(i, element) {
		var html = $(this).html();
		
			var qty = $(this).find('.qty').val();
			var price = $(this).find('.price').val();
			$(this).find('.total').val(qty*price);
			
			calc_total3();
    });
}

function calc_total3()
{
	total=0;
	$('.total').each(function() {
        total += parseInt($(this).val());
    });
	$('#sub_total').val(total.toFixed(2));
	tax_sum=total/100*$('#tax').val();
	$('#tax_amount').val(tax_sum.toFixed(2));
	$('#total_amount').val((tax_sum+total).toFixed(2));
}
</script>


<!--- SCRIPT PARA MANEJO DE CALCULOS PESTAÑA OTROS
<script>
$(document).ready(function(){
	
    option_list4('addr4');
    var i=1;
    $("#add_row").click(function(){b=i-1;
      	$('#addr'+i).html($('#addr'+b).html()).find('td:first-child').html(i+1);
      	$('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
        option_list4('addr'+i);
      	i++; 
  	});
    $("#delete_row").click(function(){
    	if(i>1){
		$("#addr"+(i-1)).html('');
		i--;
		}
		calc4();
	});
	
	$(".product").on('change',function(){
	    option_checker4(this)
	});
	
	
	$('#tab_logic tbody').on('keyup change',function(){
		calc4();
	});
	$('#tax').on('keyup change',function(){
		calc_total4();
	});

});

function option_checker4(id)
{
	var myOption=$(id).val();
	var s =0;
	$('#tab_logic tbody tr select').each(function(index, element){
         var myselect = $(this).val();
		if(myselect==myOption){
			s += 1;
		}
    });
	if(s>1){
		alert(myOption+' Ya se seleccionó intenta con otra...')	
	}
}



function option_list4(id)
{
	el='#'+id;
	var myArray = ["Otros 1", "Otros 2", "Otros 3", "Otros 4"];
	var collect = '<option value="">Otros</option>';
    for(var i = 0; i<myArray.length;i++){
        collect += '<option value="'+myArray[i]+'">'+myArray[i]+'</option>';
    }
    $(el+" select").html(collect);
}


function calc4()
{
	$('#tab_logic tbody tr').each(function(i, element) {
		var html = $(this).html();
		
			var qty = $(this).find('.qty').val();
			var price = $(this).find('.price').val();
			$(this).find('.total').val(qty*price);
			
			calc_total4();
    });
}

function calc_total4()
{
	total=0;
	$('.total').each(function() {
        total += parseInt($(this).val());
    });
	$('#sub_total').val(total.toFixed(2));
	tax_sum=total/100*$('#tax').val();
	$('#tax_amount').val(tax_sum.toFixed(2));
	$('#total_amount').val((tax_sum+total).toFixed(2));
}
</script>


<!--- AQUI VA EL FUNCIONAMIENTO DE LAS PESTAÑAS DEL SOBRERECIBO 
<script>
function opensobrerecibo(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
<!--- AQUI TERMINA EL FUNCIONAMIENTO DE LAS PESTAÑAS DEL SOBRERECIBO 


    <body>
            <div class="tab">
                <button class="tablinks" onclick="opensobrerecibo(event, 'percepciones')">Percepciones</button>
                <button class="tablinks" onclick="opensobrerecibo(event, 'deducciones')">Deducciones</button>
            </div>


            <!--- AQUI VA EL CONTENIDO DEL SOBRERECIBO!
                <div id="percepciones" class="tabcontent">
                
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="tab_logic">
                        <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> Percepciones</th>
                            <th class="text-center"> Cantidad </th>
                            <th class="text-center"> Monto</th>
                            <th class="text-center"> Total </th>
                            <th class="text-center"> Observaciones </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr id='addr0'>
                            <td>1</td>
                            <td><select class="form-control" name='product[]' onChange="option_checker(this);"></select></td>
                            <td><input type="number" name='qty[]' placeholder='Cantidad' class="form-control qty" step="0" min="0"/></td>
                            <td><input type="number" name='price[]' placeholder='Monto unitario' class="form-control price" step="0.00" min="0"/></td>
                            <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
                            <td><input type="text" name='observaciones[]' placeholder='Observaciones' class="form-control total"/></td>
                        </tr>

                        <tr id='addr1'></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left">Agregar percepción</button>
                <button id='delete_row' class="pull-right btn btn-default">Eliminar percepción</button>
                </div>
            </div>

            <div class="row clearfix" style="margin-top:20px">
                <div class="pull-right col-md-4">
                    <table class="table table-bordered table-hover" id="tab_logic_total">
                        <tbody>
                        <tr>
                            <th class="text-center">Sub Total</th>
                            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                        </tr>
                        
                        <tr>
                            <th class="text-center">Gran Total</th>
                            <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--- Aqui va el contenido de las deducciones 
            <div id="deducciones" class="tabcontent">
                
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="tab_logic">
                        <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> Deducciones</th>
                            <th class="text-center"> Cantidad </th>
                            <th class="text-center"> Monto</th>
                            <th class="text-center"> Total </th>
                            <th class="text-center"> Observaciones </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr id='addr2'>
                            <td>2</td>
                            <td><select class="form-control" name='product[]' onChange="option_checker(this);"></select></td>
                            <td><input type="number" name='qty[]' placeholder='Cantidad' class="form-control qty" step="0" min="0"/></td>
                            <td><input type="number" name='price[]' placeholder='Monto unitario' class="form-control price" step="0.00" min="0"/></td>
                            <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
                            <td><input type="text" name='observaciones[]' placeholder='Observaciones' class="form-control total"/></td>
                        </tr>

                        <tr id='addr2'></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left">Agregar deducción</button>
                <button id='delete_row' class="pull-right btn btn-default">Eliminar deducción</button>
                </div>
            </div>

            <div class="row clearfix" style="margin-top:20px">
                <div class="pull-right col-md-4">
                    <table class="table table-bordered table-hover" id="tab_logic_total">
                        <tbody>
                        <tr>
                            <th class="text-center">Sub Total</th>
                            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                        </tr>
                        
                        <tr>
                            <th class="text-center">Gran Total</th>
                            <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!--- AQUI VAN LAS INCIDENCIAS 
            <div id="incidencias" class="tabcontent">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="tab_logic">
                        <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> Incidencias</th>
                            <th class="text-center"> Cantidad </th>
                            <th class="text-center"> Monto</th>
                            <th class="text-center"> Total </th>
                            <th class="text-center"> Observaciones </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr id='addr3'>
                            <td>1</td>
                            <td><select class="form-control" name='product[]' onChange="option_checker3(this);"></select></td>
                            <td><input type="number" name='qty[]' placeholder='Cantidad' class="form-control qty" step="0" min="0"/></td>
                            <td><input type="number" name='price[]' placeholder='Monto Unitario' class="form-control price" step="0.00" min="0"/></td>
                            <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
                            <td><input type="text" name='observaciones[]' placeholder='Observaciones'/></td>
                        </tr>

                        <tr id='addr3'></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left">Agregar Incidencia</button>
                <button id='delete_row' class="pull-right btn btn-default">Eliminar Incidencia</button>
                </div>
            </div>

            <div class="row clearfix" style="margin-top:20px">
                <div class="pull-right col-md-4">
                    <table class="table table-bordered table-hover" id="tab_logic_total">
                        <tbody>
                        <tr>
                            <th class="text-center">Sub Total</th>
                            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                        </tr>
                        
                        <tr>
                            <th class="text-center">Gran Total</th>
                            <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!--- AQUI VAN OTROS CALCULOS 
<div id="otros" class="tabcontent">
                <div class="container">
                    <div class="row clearfix">
                        <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="tab_logic">
                        <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> Otros</th>
                            <th class="text-center"> Cantidad </th>
                            <th class="text-center"> Monto</th>
                            <th class="text-center"> Total </th>
                            <th class="text-center"> Observaciones </th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr id='addr4'>
                            <td>1</td>
                            <td><select class="form-control" name='product[]' onChange="option_checker3(this);"></select></td>
                            <td><input type="number" name='qty[]' placeholder='Cantidad' class="form-control qty" step="0" min="0"/></td>
                            <td><input type="number" name='price[]' placeholder='Monto Unitario' class="form-control price" step="0.00" min="0"/></td>
                            <td><input type="number" name='total[]' placeholder='0.00' class="form-control total" readonly/></td>
                            <td><input type="text" name='observaciones[]' placeholder='Observaciones'/></td>
                        </tr>

                        <tr id='addr4'></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                <button id="add_row" class="btn btn-default pull-left">Agregar Otros</button>
                <button id='delete_row' class="pull-right btn btn-default">Eliminar Otros</button>
                </div>
            </div>

            <div class="row clearfix" style="margin-top:20px">
                <div class="pull-right col-md-4">
                    <table class="table table-bordered table-hover" id="tab_logic_total">
                        <tbody>
                        <tr>
                            <th class="text-center">Sub Total</th>
                            <td class="text-center"><input type="number" name='sub_total' placeholder='0.00' class="form-control" id="sub_total" readonly/></td>
                        </tr>
                        
                        <tr>
                            <th class="text-center">Gran Total</th>
                            <td class="text-center"><input type="number" name='total_amount' id="total_amount" placeholder='0.00' class="form-control" readonly/></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<body>
</html>

<style>
#tab_logic .form-control[readonly],#tab_logic_total .form-control[readonly] {
    border: 0;
    background: transparent;
    box-shadow: none;
    padding: 0 10px;
    font-size: 15px;
}
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>-->