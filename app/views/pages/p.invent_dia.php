<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Inventario por fecha: 
                        </div>
<br />
<div class="row">
    <div class="col-md-8">
        &nbsp;&nbsp;Seleccione un rango de Fechas:<br/>
        <br/>
        <form action="index.php" method="post">
         &nbsp;&nbsp; &nbsp;&nbsp;Del: &nbsp;&nbsp;<input type="text" class="date" name="inicio" value="<?php echo date('d.m.Y')?>"> &nbsp;&nbsp;al &nbsp;&nbsp;<input type="text" class="date" name="fin" value="<?php echo date('d.m.Y')?>"> &nbsp;&nbsp; <button type="submit" name="invDia" value="invDia">Consultar</button><input type="hidden" name="emp" value="<?php echo $emp?>">
        </form>
        <br />
    </div>
</div>
<br/>

<?php if(count($info)>0){ ?>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <center><h2>F A C T U  R A S </h2></center>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Documento</th>
                                            <th>Clave</th>
                                            <th>Cliente / Proveedor</th>
                                            <th>Articulo</th>
                                            <th>Descipción</th>
                                            <th>Piezas</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Agente</th>
                                            <th>Comision</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($info as $data):
                                        
                                         ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo substr($data->FECHA,0,10);?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td align="center" ><?php echo $data->CLAVE ?></td>
                                            <td><font color="" ><b><?php echo $data->NOMBRE;?></b></font></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><font color="brown"><b><?php echo $data->DESCRIPCION;?></b></font></td>
                                            <td align="center"><?php echo $data->PZAS;?></td>        
                                            <td align="center"><?php echo $data->CANTIDAD;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO,2);?></td>        
                                            <td><?php echo $data->AGENTE;?></td>  
                                            <td><?php echo number_format($data->COMISION,2).' % ';?></td>  
                                            <td align="right"><?php echo '$ '.number_format($data->TOTAL + $data->IMPUESTO,2);?></td>  

                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>



<?php }?>

<?php if(count($infoC)>0){?>

    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <center><h2>C O M  P R A S </h2></center>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Documento</th>
                                            <th>Clave</th>
                                            <th>Cliente / Proveedor</th>
                                            <th>Articulo</th>
                                            <th>Descipción</th>
                                            <th>Piezas</th>
                                            <th>Cantidad</th>
                                            <th>Costo</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($infoC as $data):
                                            //$porc=$data->COMISION / $data->TOTAL; 
                                         ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo substr($data->FECHA,0,10);?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td align="center"><?php echo $data->CLAVE?></td>
                                            <td><font color="" ><b><?php echo $data->NOMBRE;?></b></font></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><font color="brown"><b><?php echo $data->DESCRIPCION;?></b></font></td>
                                            <td align="center"><?php echo $data->PZAS;?></td>        
                                            <td align="center"><?php echo $data->CANTIDAD;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COST,2);?></td>        
                                            <td align="right"><?php echo '$ '.number_format($data->TOTAL + $data->IMPUESTO,2);?></td>  

                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<?php }?>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
  $(document).ready(function() {
    $(".date").datepicker({dateFormat: 'dd.mm.yy'});
    var mensaje = document.getElementById('mensaje').value;
    if(mensaje !=''){
      alert(mensaje);
    }
  } );
  function ocultar(a){
    if(a == ''){
      //alert('El valor esta vacio' + a);
    }else{
      document.getElementById('btnPago').classList.add('hide');
    }
  }
  
</script>