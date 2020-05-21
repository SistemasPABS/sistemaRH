<script type="text/javascript" src="../scripts/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="lanza.js"></script>
<style>
    .titulo{ font-size: 12pt; font-weight: bold; height: 30pt;}
#marcoVistaPrevia{
    border: 1px solid #008000;
    width: 400px;
    height: 400px;
}
#vistaPrevia{
    max-width: 400px;
    max-height: 400px;            
}

</style>
<div id='botonera'>
    <input id="archivo" type="file" accept="image/*"></input>
    
</div>
<div class="contenedor">
    <!--<div class="titulo">
        <span>Vista Previa:</span> 
        <span id="infoNombre">[Seleccione una imagen]</span><br/>
        <span id="infoTamaño"></span>
    </div>-->
    <div id="marcoVistaPrevia">
        <img id="vistaPrevia" src="" alt="" />
    </div>
</div>

