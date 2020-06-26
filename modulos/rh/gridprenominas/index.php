<?php 
include_once ('../prenominas/index.php');
$em=base64_decode($_GET['em']);
$con= new conectasql();
$con->abre_conexion("0");
$conexion=$con->conexion;
$query = "SELECT * from vw_prenomina_general";
$result = pg_query($conexion,$query) or die("Error en la consulta SQL");
do{
$renglonesloquesea .='
  <tr>  
  <td> '.$mostrar['nombrecompleto'].'</td>
  <td> '.$mostrar['sal_monto_con'].'
  <td> '.$mostrar['nom_t_percepciones'].'</td>
  <td> '.$mostrar['nom_t_deducciones'].'</td>
  <td><button>Abrir Sobrerecibo</button></td> 
</tr> ';
}while($mostrar=pg_fetch_array($result))
?>
<html>
    <head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        
    </head>
    
    <style>
        body {
        font-family: "Microsoft JhengHei", "Open Sans", sans-serif;
        line-height: 1.25;
        }

@media screen and (max-width: 600px) {
    .table-wrap table thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }
    .table-wrap table tr {
        border-bottom: 3px solid #ddd;
        display: block;
        margin-bottom: .625em;
    }
    .table-wrap table td {
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: .8em;
        text-align: right;
    }
    .table-wrap table td::before {
        /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
        margin-right: 5px;
    }
    .table-wrap table td:last-child {
        border-bottom: 0;
    }
}
        
    </style>
    
    <script>
        /* main function when page is opened  */

    $(document).ready(function () {
        /* function for adding a new row */
        var r = 0;

        $(".addRow").on("click", function () {
            r++;

            $("#sponsorTable").append(
                '<tr id="row' +
                r +
                '" class="item"><td data-label="商品名稱"><input type="text" name="sponsor" class="form-control" /></td><td data-label="市 價"><div class="input-group"><div class="input-group-addon">$</div><input type="number" name="price" class="form-control price amount" min="0" /></div></td><td data-label="贊助份數"><input type="number" name="quantity" class="form-control qnty amount" min="1" /></td><td data-label="小 計"><input type="number" name="total" class="form-control total" id="total1" readonly /></td><td data-label=" "><button type="button" name="remove" id="' +
                r +
                '" class="btn btn-success btn-sm btn_remove"><i class="fa fa-trash-o"></i> 刪除</button></td></tr>'
            );
        });
        /* remove row when X is clicked */
        $(document).on("click", ".btn_remove", function () {
            var button_id = $(this).attr("id");
            $("#row" + button_id + "").remove();
        });
        /* calculate everything  */
        $(document).on("keyup", ".amount", calcAll);
        /* $(".amount").on("change", calcAll);  */
    });

    /* function for calculating everything  */
    function calcAll() {
        /* calculate total for one row  */

        $(".item").each(function () {
            var qnty = 0;
            var price = 0;
            var total = 0;

            if (!isNaN(parseFloat($(this).find(".qnty").val()))) {
                qnty = parseFloat(
                    $(this).find(".qnty").val()
                );
            }
            if (!isNaN(parseFloat($(this).find(".price").val()))) {
                price = parseFloat(
                    $(this).find(".price").val()
                );
            }

            total = qnty * price;

            $(this).find(".total").val(total.toFixed(0));
        });

        /*$(".amount").each(function () {

            if (!isNaN(this.value) && this.value.length != 0) {
                product *= parseFloat(this.value);
            }
            $("#total1").val(product.toFixed(2));
            if (!isNaN($(this).find(".qnty"))) {

            }
        });  */

        /*  sum all totals  */
        var sum = 0;
        $(".total").each(function () {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
        });
        /* show values in netto, steuer, brutto fields  */

        $("#CostTotal").val(sum.toFixed(0));

    }>

    /* change cell when edited */
    $("input").change(function () {
        $(this).addClass("edited");
    });
    </script>
    
    <body>
        
        <div class="container">
            <div class="row">
        <div class="col-xs-12 col-md-12">
            <!---<div class="pull-right">
                <button type="button" class="btn btn-warning btn-sm addRow"><i class="fa fa-plus-circle"></i> Agregar Percepcion</button>
                <div class="clearfix"></div>
            </div>-->
            <div class="table-wrap">
                <table id="sponsorTable" class="table table-condensed table-striped table-hover">
                    <thead>
                        <tr class="warning">
                            <th width="35%" class="text-center" scope="col">Empleado</th>
                            <th width="20%" class="text-center" scope="col">Monto</th>
                            <!---<th width="15%" class="text-center" scope="col">贊助份數</th>-->
                            <th width="20%" class="text-center" scope="col">Total</th>
                            <th width="35%" class="text-center" scope="col">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="item">
                            <td data-label="empleado">
                                <label type="text" name="sponsor" class="form-control" />
                            </td>
                            <td data-label="monto">
                                <div class="input-group">
                                  <div class="input-group-addon">$</div>
                                  <input type="number" name="price" class="form-control price amount" min="0" />
                                </div>
                            </td>
                            <!--<td data-label="贊助份數">
                                <input type="number" name="quantity" class="form-control qnty amount" min="1" />
                            </td>-->
                            <td data-label="total">
                                <input type="number" name="total" class="form-control total" id="total1" readonly />
                            </td>
                            <td data-label="observaciones">
                                 <input type="text" name="observaciones" class="form-control" id="observaciones"/>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center">
                                <h4 class="font-bold text-red">Programa de Apoyo de Beneficio Social</h4></b>
                            </td>  
                            <td class="text-right">
                                <input id="CostTotal" readonly="readonly" name="CostTotal" type="number" class="form-control" />
                            </td>
                            <td>
                                 
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
        
    </body>
    
</html>

<!---
<!DOCTYPE html>
<html>
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
        <body>
            <div>
                <button class="button disabled">Autorizar Nómina</button>
                <button class="button">Editar Nómina</button>
                <button class="button">Exportar a Excel</button>
            </div> 

            <div id="sailorTableArea">
                <table>
                        <tr id="titletable">
                            <td>Nombre Completo</td>
                            <td>Percepciones</td>
                            <td>Deducciones</td>
                            <td>Sueldo</td>
                            <td>Sobrerecibo</td>
                        </tr>
                <?php echo $renglonesloquesea; ?>
                </table> 
              </div>  
            
        </body>  
    </html>
</table>-->




