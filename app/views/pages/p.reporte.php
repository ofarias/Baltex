<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Reporte Compra /Venta
                        </div>
<br />
<div class="row">
    <div class="col-md-8">
        <form action="index.php" method="post">
            <select name="opcion" required="required">
                <option value="">-Elige una opcion-</option>
                <option value="compc01">Compra</option>
                <option value="compr01">Compra Recepción</option>
                <option vslue="compo01">Compra Pedido</option>
                <option value="factf01">Factura</option>
                <option value="factr01">Factura Remision</option>
                <option value="factp01">Factura Pedido</option>
            </select>
            <input type="text" placeholder="clave de documento" name="doc" maxlength="50" required=""/>
            <input type="hidden" name="emp" value="<?php echo $emp?>">
            <input type="submit" value="Buscar" name="reporte" />
        </form>
        <br />
    </div>
</div>
<br/>

<?php if(count($docs)>0){ ?>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Documento
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Documento</th>
                                            <th>Cliente / Proveedor</th>
                                            <th>Articulo</th>
                                            <th>Descipción</th>
                                            <th>Cantidad</th>
                                            <th>Piezas</th>
                                            <th>Costo Uni</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        $sub=0;
                                        $pzas=0;
                                        foreach ($docs as $data):
                                            $sub= $sub + $data->SUBTOTAL;
                                            $pzas =$pzas + $data->PZAS; 
                                         ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><font color="" ><b><?php echo $data->NOMBRE;?></b></font></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><font color="brown"><b><?php echo $data->DESCRIPCION;?></b></font></td>
                                            <td align="center"><?php echo $data->CANTIDAD;?></td>
                                            <td align="center"><?php echo $data->PZAS;?></td>        
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO,2);?></td>        
                                            <td align="right"><?php echo '$ '.number_format($data->SUBTOTAL,2);?></td>  
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td></td><td></td><td></td><td></td><td></td><td>Total Piezas</td><td align="center" ><font color ='red'><?php echo $pzas?></font></td>
                                            <td>SubTotal:</td>
                                            <td align="right"><?php echo '$ '.number_format($sub,2)?></td>
                                        </tr>  
                                         <tr>
                                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                            <td>IVA:</td>
                                            <td align="right"><?php echo '$ '.number_format($sub*.16,2)?></td>
                                        </tr>  
                                         <tr>
                                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                                            <td>Total:</td>
                                            <td align="right"><font color="blue"><?php echo '$ '.number_format($sub*1.16,2)?></font></td>
                                        </tr>    
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>

<?php }?>

