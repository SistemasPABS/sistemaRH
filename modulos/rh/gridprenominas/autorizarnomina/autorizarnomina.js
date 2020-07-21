function autorizarnomina(btn){
    var papatd = btn.parentNode;
    var papatr = papatd.parentNode;
    var hermanotd = papatr.childNodes[1];
    var sobrinotd = hermanotd.childNodes[1].value;

    //alert(sobrinotd);

    var url = "autorizarnomina/autorizarnomina.php";
    $.ajax({
        type: "POST",
        url:url,
        data:{idnomautorizar:btoa(sobrinotd)},
        success: function(data){
        alert(data);
        location.reload();  
        }
      });
}   

function reload(){
  location.reload();
}