<?php
session_start();
if(isset($_SESSION['plogin'])){
    unset($_SESSION['plogin']);
}
?>

<script type="text/javascript" src="librerias/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="librerias/md5-min.js"></script>
    <script type="text/javascript">
    window.onload = function(){
        navegador();
    };
    
    function navegador(){
        //se recoge el valor del navegador que esta siendo utilizado
        var a = navigator.userAgent;
        var a = btoa(a);
        var b = btoa('<?php echo gethostbyaddr($_SERVER['REMOTE_ADDR']);?>');
        //alert("Navegador autorizado "+a+" "+b);
        var url="acceso/valida.php";
            $.ajax({
                type: "POST",
                url:url,
                data:{chk1:a,chk2:b},
                success: function(data){
                //alert(data);    
                window.location.replace(data);
                }
            });
    };

    </script>
</html>
