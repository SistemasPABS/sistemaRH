<?php
include ('../config/conectasql.php');

class creacambiapas extends conectasql{
    public $usid;
    public $contrasena;
    public $consulta;
    public $flag;

    public function __construct($usid) {
        $this->usid = $usid;
    }
    
    public function librerias() {
        echo '<link href="../estilos/estilo_passwd.css" type="text/css" rel="stylesheet">';
        echo '<script type="text/javascript" src="../librerias/md5-min.js"></script>';
    }
    
    public function jscambiapas() {
        echo '<script>
               
                function valida_cambiapas(){
                    if (document.verifica.c_actual.value.length==0){
                    alert("Ingrese contraseña actual");
                    document.verifica.c_actual.focus();
                    return 0;
                    }
                    if (document.verifica.c_nueva.value.length==0){
                    alert("La cotraseña nueva no puede estar en blanco");
                    document.verifica.c_nueva.focus();
                    return 0;
                    }
                    if (document.verifica.c_confirma.value.length==0){
                    alert("Confirme la nueva contraseña");
                    document.verifica.c_confirma.focus();
                    return 0;
                    }
                    if (document.verifica.c_nueva.value != document.verifica.c_confirma.value){
                    alert("Las contraseñas no coinciden");
                    document.verifica.c_nueva.focus();
                    return 0;
                    }
                    document.verifica.c_actual.value    = hex_md5(document.verifica.c_actual.value);
                    document.verifica.c_nueva.value     = hex_md5(document.verifica.c_nueva.value);
                    document.verifica.c_confirma.value  = hex_md5(document.verifica.c_confirma.value);
                document.verifica.submit();
                }
                
        </script>';
    }
    
    public function interfazpasswd() {
        echo '<form method="post" name="verifica" id="verifica" action="cambiapas.php">';
        echo '<div class="divpasswd" id="divpasswd">';
        echo '<div class="actual"><div class="actual2">Clave actual</div><input class="passwd" style="margin-top:-20px;margin-left:105px;height: 14px;width:170px;" type="password" name="c_actual" id="c_actual"   autocomplete="new-password"></div>';
        echo '<div class="actual"><div class="actual2">Clave nueva </div><input class="passwd" style="margin-top:-20px;margin-left:105px;height: 14px;width:170px;" type="password" name="c_nueva" id="c_nueva"     autocomplete="new-password"></div>';
        echo '<div class="actual"><div class="actual2">Confirma </div><input class="passwd" style="margin-top:-20px;margin-left:105px;height: 14px;width:170px;" type="password" name="c_confirma" id="c_confirma"  autocomplete="new-password"></div>';
        echo '<input class="boton" style="margin-left:90px;margin-top:10px;" name="aceptarpas" id="aceptarpas" type="button" value="Aceptar" onclick="valida_cambiapas();"> <input class="boton" name="cancela" id="cancela" type="button" value="Cancelar" onclick="self.close();" >';
        echo '</div>';
        echo '</form>';
    }
    
    public function verificanuevopas($actual,$ps1,$ps2) {
        $sql="select * from users where us_id = $this->usid";
        $result= pg_query($this->conexion,$sql) or die("Error cvnp: ". pg_last_error());//consulta para validar nuevo password
        $row=pg_fetch_array($result);
        //se compara la contraseña actual
        if($row['us_passwd'] == $actual){
            //se compara que la nueva contraseña coincida con la contraseña confirmada
            if($ps1 == $ps2){
                //si coinciden se actualiza el passwd
                $sqlup="update users set us_passwd = '$ps1' where us_id = $this->usid;";
                $resultup= pg_query($this->conexion,$sqlup) or die("Error anp: ". pg_last_error());//actualiza nuevo password
                $this->flag=1;
            }else{
                $this->flag=0;
            }
        }else{
            $this->flag = 0; 
        }
    }
        
}

?>