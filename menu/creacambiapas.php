<?php

class creacambiapas{
    protected $uslogin;
    protected $nav;
    protected $condicion;
    protected $contrasena;
    protected $consulta;
    public    $flag;
    protected $motorbd;

    public function __construct($uslogin,$nav) {
        $uslogin= strtoupper($uslogin);
        $this->uslogin = $uslogin;
        $this->nav = $nav;
    }
    
     public function passwdactual($passwd) {
        $passwd= strtoupper($passwd);
        $this->contrasena=$passwd;
    }
    
    public function condicion($campo1,$campo2,$coincide){
        $this->condicion = ' where '.$campo1.' '. $coincide .' '."'$this->uslogin'"." and $campo2 $coincide '$this->contrasena'".';';
    }
    
    public function query($query) {
        $this->consulta = $query;
    }
    
     public function librerias() {
        echo '<link href="../estilos/estilo_passwd.css" type="text/css" rel="stylesheet">';
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
                document.verifica.submit();
                }
        </script>';
    }
    
    public function interfazpasswd() {
        echo '<form method="post" name="verifica" id="verifica" action="cambiapas.php?var='.$this->uslogin.'&nav='.$this->nav.'">';
        echo '<div class="divpasswd" id="divpasswd">';
        echo '<div class="actual"><div class="actual2">Clave actual</div><input class="passwd" style="margin-top:-20px;margin-left:105px;height: 14px;width:170px;" type="password" name="c_actual" id="c_actual"></div>';
        echo '<div class="actual"><div class="actual2">Clave nueva </div><input class="passwd" style="margin-top:-20px;margin-left:105px;height: 14px;width:170px;" type="password" name="c_nueva" id="c_nueva"></div>';
        echo '<div class="actual"><div class="actual2">Confirma </div><input class="passwd" style="margin-top:-20px;margin-left:105px;height: 14px;width:170px;" type="password" name="c_confirma" id="c_confirma"></div>';
        echo '<input class="boton" style="margin-left:90px;margin-top:10px;" name="aceptarpas" id="aceptarpas" type="button" value="Aceptar" onclick="valida_cambiapas();"> <input class="boton" name="cancela" id="cancela" type="button" value="Cancelar" onclick="self.close();" >';
        echo '</div>';
        echo '</form>';
    }
    
    public function verificanuevopas($nueva,$confirma) {
        include('../config/config.php');
        $con= new config();
        $con->conecta(1);
        $conexion=$con->conexion;
        $sql= $this->consulta . $this->condicion;  
        $result = odbc_exec ($conexion,$sql);
        $row = odbc_fetch_array ($result);
        
        if($this->uslogin = $row['nombre'] && $this->contrasena = $row['pwd']){
            if($nueva = $confirma){
                //$md5passwd=  md5($nueva);
                $sqlupdate = "update tcausr set pwd = '".$nueva."' where nombre = '".$this->uslogin."';";
                $resultupdate = odbc_exec ($conexion,$sqlupdate);
                $this->flag=odbc_errormsg($conexion);
                odbc_close($conexion);
            }
        }
        
        
    }
                
    
   
}

?>