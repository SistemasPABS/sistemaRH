<?php

class sqlad{

    public $conexion;
    public $select;
    public $plazaN="Plaza de origen";
    public $sucursalN="Sucursal de origen";

    public function abre_conexion($perfil) {
        
        include '../../../../config/config.php';
        
        switch ($perfil) {
            case 0:
                //postgres
                //$this->conexion = $server0.' '.$dbname0.' '.$user0.' '.$passwd0.' '.$port0;
                $this->conexion = pg_connect("host=$server0 port=$port0 dbname=$dbname0 user=$user0 password=$passwd0") or die ("Error de conexion Abrir C. ". pg_last_error());;                
            break;
            
            case 1:
                //mssql
                //echo $server1.$dbname1.$user1.$password1;
                //$this->conexion = odbc_connect ("Driver={ODBC Driver 13 for SQL Server};Server=$server1;Database=$dbname1;", "$user1", "$passwd1");                                               
            break;

            case 2:
                //mysql
                //$this->conexion = odbc_connect ("Driver={ODBC Driver 13 for SQL Server};Server=$server2;Database=$dbname2;", "$user2", "$passwd2");
            break;
        
            case 3:
                //maria_db
                //$this->conexion = new mysqli($server3, $user3, $passwd3, $dbname3);
            break;

            default:
            break;
        }
    }
    
    public function cierra_conexion($perfil) {
        
        switch ($perfil) {
            case 0:
                //postgres
                pg_close($this->conexion);
            break;
            
            case 1:
                //mssql
                
            break;

            case 2:
                //mysql
                
            break;
        
            case 3:
                //maria_db
                
            break;

            default:
            break;
        }
    }
  

    public function selects_creator($sql,$nombre,$valor,$texto,$apartado,$change,$default) {
        $resultcds = pg_query($this->conexion,$sql) or die("Error cds: ". pg_last_error());//creador de selects
        $this->select = ' <select class="dropdown-select" id="'.$nombre.'" name='.$nombre.' '.$change.'>';
        $this->select.='<option value="1000"> --- Selecciona '.$apartado.' --- </option>';
        if($rowcds = pg_fetch_array($resultcds)){
            do{
                if($rowcds[$valor] == $default){$vd='selected';}else{$vd='';}
                $this->select.='<option value="'.$rowcds[$valor].'" '.$vd.'>'.$rowcds[$texto].'</option>';
            }
            while($rowcds = pg_fetch_array($resultcds));
        }
        $this->select.='</select>'; 
    }


    public function plaza_suc($p, $s){

        $sqlP="select plaza_nombre from plazas where plaza_id =$p";
        $resultP = pg_query($this->conexion,$sqlP) or die("Error plzN: ". pg_last_error());
        if($row = pg_fetch_array($resultP)){   
            do{
                $this->plazaN=$row['plaza_nombre'];       
            }
            while($row = pg_fetch_array($resultP));
        }
        
        $sqlS="select suc_nombre from sucursales where suc_id =$s";
        $resultS = pg_query($this->conexion,$sqlS) or die("Error sucN: ". pg_last_error());
        if($row = pg_fetch_array($resultS)){   
            do{
                $this->sucursalN=$row['suc_nombre'];       
            }
            while($row = pg_fetch_array($resultS));
        }       
        
        
    }
   

    /*Fin de las funciones */
}

?>