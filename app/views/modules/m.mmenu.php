<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <div>
                <label> Bienvenido: </label><?php echo $usuario?><br/>
                <label> Empresa Seleccionada: </label><?php echo $emp?>
            </div>
            <br/>
        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><h4>Reporte</h4></center>
                    </div>
                    <div class="panel-body">
                        <p>Empresa <?php echo $emp?></p>   
                        <center><a href="index.php?action=reporte&emp=<?php echo $emp?>" class="btn btn-default"><img src="app/views/images/bootstrapper.jpg" width="60px" height="60px"></a></center>
                    </div>
                </div>
        </div>
        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><h4>Inventario por dia</h4></center>
                    </div>
                    <div class="panel-body">
                        <p>Empresa <?php echo $emp?></p>   
                        <center><a href="index.php?action=invDia&emp=<?php echo $emp?>" class="btn btn-default"><img src="app/views/images/JGOLAVMYC.jpg" width="60px" height="60px"></a></center>
                    </div>
                </div>
        </div>
        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><h4>Piezas Totales y Kardex</h4></center>
                    </div>
                    <div class="panel-body">
                        <p>Empresa <?php echo $emp?></p>   
                        <center><a href="index.php?action=pzas_totales&emp=<?php echo $emp?>" class="btn btn-default"><img src="app/views/images/pzast.jpg" width="60px" height="60px"></a></center>
                    </div>
                </div>
        </div>
        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><h4>Cuadre</h4></center>
                    </div>
                    <div class="panel-body">
                        <p>Empresa <?php echo $emp?></p>   
                        <center><a href="index.php?action=cuadre&emp=<?php echo $emp?>" class="btn btn-default"><img src="app/views/images/genre-engineering.jpg" width="60px" height="60px"></a></center>
                    </div>
                </div>
        </div>
        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><h4>Cancelaciones</h4></center>
                    </div>
                    <div class="panel-body">
                        <p>Empresa <?php echo $emp?></p>   
                        <center><a href="index.php?action=cancelar&emp=<?php echo $emp?>" class="btn btn-default"><img src="app/views/images/cancel.jpg" width="60px" height="60px"></a></center>
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
                    <center><a href="index.php?action=verPagos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                </div>
            </div>
        </div>
    </div>
</div>
    