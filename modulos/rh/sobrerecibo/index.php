<?php 
include_once ('../prenominas/index.php');
$em=base64_decode($_GET['em']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$query = "SELECT * from vw_nomina_periodo_saltipo";
$result = pg_query($conexion,$query);
while($mostrar=pg_fetch_array($result)){}
?>

<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>


<!--- SCRIPT PARA MANEJO DE CALCULOS PESTAÑA PERCEPCIONES-->
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

<!--- SCRIPT PARA MANEJO DE CALCULOS PESTAÑA DEDUCCIONES-->
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

<!--- SCRIPT PARA MANEJO DE CALCULOS PESTAÑA INCIDENCIAS-->
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


<!--- SCRIPT PARA MANEJO DE CALCULOS PESTAÑA OTROS-->
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


<!--- AQUI VA EL FUNCIONAMIENTO DE LAS PESTAÑAS DEL SOBRERECIBO --->
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
<!--- AQUI TERMINA EL FUNCIONAMIENTO DE LAS PESTAÑAS DEL SOBRERECIBO --->


    <body>
            <div class="tab">
                <button class="tablinks" onclick="opensobrerecibo(event, 'percepciones')">Percepciones</button>
                <button class="tablinks" onclick="opensobrerecibo(event, 'deducciones')">Deducciones</button>
            </div>


            <!--- AQUI VA EL CONTENIDO DEL SOBRERECIBO!--->
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

    <!--- Aqui va el contenido de las deducciones --->
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

<!--- AQUI VAN LAS INCIDENCIAS -->
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

<!--- AQUI VAN OTROS CALCULOS -->
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
</style>