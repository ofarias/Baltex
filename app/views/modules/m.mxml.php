<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <p><input type="text" name="docf" placeholder="Migrar Factura" onchange="migrar(this.value)" id="mf" ></p>
            <p><input type="text" name="docf" placeholder="Ver Factura" onchange="factura(this.value)" id="vf"></p>
            <form action="index.php" method="post">
            <p>Documento:<input type="text" name="docf"></p>
            <p>Caja: <input type="text" name="caja"></p>
            <button name="generaJson" value="Enviar" type="submit">Facturar</button>
            <p><input type="text" name="creaCaja" onchange="creaCaja(this.value)" placeholder="Crear Caja"></p>
            </form>
            <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">Carga de XML</i></h4>
                </div>
                <div class="panel-body">
                    <p>Carga de XML</p>
                    <center><a href="index.php?action=facturaUploadFile&tipo=F" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
            
        </div>
           <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">Carga de XML Cancelados</i></h4>
                </div>
                <div class="panel-body">
                    <p>Carga de XML</p>
                    <center><a href="index.php?action=facturaUploadFile&tipo=C" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
           <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">Calcular Impuestos</i></h4>
                </div>
                <div class="panel-body">
                    <p>Calcular impuestos de XML</p>
                    <center><a href="index.php?action=calcularImpuestos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">Descargas XML</i></h4>
                </div>
                <div class="panel-body">
                    <p>Descargas de XML</p>
                    <center><a href="index_xml.php?action=''" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt"> Trabajar XML</i></h4>
                </div>
                <div class="panel-body">
                    <p>Ver XML sin Procesar</p>
                    <center><a href="index.php?action=verXMLSP" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt"> Verifica IDs Preoc</i></h4>
                </div>
                <div class="panel-body">
                    <p>Verifica las Preordenes de compra</p>
                    <center><a href="index.php?action=verificaPreOC" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
         <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt"> Ver Pagos CEP</i></h4>
                </div>
                <div class="panel-body">
                    <p>Ver Pagos</p>
                    <center><a href="index.v.php?action=verPagos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
         
        </div>
    </div>
<form action="index.php" method="post" id="migrar">
    <input type="hidden" name="docf" id="doc" value="<?php echo $docf?>">
    <input type="hidden" name="refacturarFecha" value="">
    <input type="hidden" name="opcion" value="3">
    <input type="hidden" name="nfecha" value="">
    <input type="hidden" name="obs" placeholder="Observaciones" value="X" id="obs" size="250">
</form>
    <script type="text/javascript">
        
        function creaCaja(docf){
            if(confirm('Crear la caja para la facutra ' + docf)){
                $.ajax({
                    url:'index.php',
                    type:'post',
                    dataType:'json',
                    data:{creaCaja:docf},
                    success:function(data){
                        alert(data.mensaje);
                    }
                });
            }
        }

        function migrar(docf){
            var docf = docf.toUpperCase();
            if(confirm("Se envia a migracion de facturas" + docf)){
                document.getElementById('doc').value=docf;
                var form=document.getElementById('migrar');
                form.submit();

            }else{
                alert('No se proceso la factura');
                document.getElementById("mf").value="";
            }
        }

        function factura(docf){
            var docf = docf.toUpperCase();
            if(confirm('Busca: ' + docf )){
                $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{verFactura:docf},
                success:function(data){
                    if(data.status == 'ok'){
                        alert('Si existe');
                    }
                    },
                error:function(data){
                    var verfact="index.php?action=verFactura&docf="+docf; 
                    window.open(verfact, 'popup', 'width=1200,height=820');
                    return false;
                    }
                })    
            }else{
                document.getElementById("vf").value="";
            }
            
        }
    </script>