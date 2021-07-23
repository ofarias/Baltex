            <br/>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Reporte de Piezas en el Inventario. 
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-8">
                                &nbsp;&nbsp;Catalogo de productos:<br/>
                                <br/>
                                <form action="index.php" method="post">
                                  <input type="hidden" name="emp" value="<?php echo $emp?>">
                                 &nbsp;&nbsp; &nbsp;&nbsp;Producto:&nbsp;&nbsp; 
                                 <input type="text" name="art" placeholder="Clave del Articulo">
                                 &nbsp;&nbsp;
                                 <button type="submit" name="pzas_totales" value="enviar">Verificar</button>
                                </form>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
<br/>
<?php if(count($info)>0){ ?>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <center><h2>INFORMACION DEL PRODUCTO SELECCIONADO </h2></center>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Piezas</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($info as $data): 
                                         ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><font color="" ><b><?php echo $data->CAMPLIB7;?></b></font></td>
                                            
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
<?php if(count($kardex)>0){?>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <center><h2>Movimientos al inventario del producto <?php echo $art?></h2></center>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Articulo</th>
                                            <th>Movimiento</th>
                                            <th>Fecha</th>
                                            <th>Concepto</th>
                                            <th>Documento</th>
                                            <th>Clave Cliente</th>
                                            <th>Precio</th>
                                            <th>Pzas</th>
                                            <th>Cantidad</th>
                                            <th>Exispzas</th>      
                                            <th>Existencia</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($kardex as $f): 
                                         ?>
                                        <tr class="odd gradeX">
                                                <td><?php echo $f->CVE_ART;?></td>
                                                <td><?php echo $f->NUM_MOV; ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($f->FECHA_DOCU));?></td>
                                                <td><?php echo $f->CVE_CPTO; ?></td>
                                                <td><?php echo $f->REFER; ?></td>   
                                                <td>
                                                    <?php echo ($f->CLAVE_CLPV); ?>
                                                </td>
                                                <td align="right"><?php echo "$ ". number_format($f->PRECIO, 2);?></td>           
                                                <td align="right">
                                                    <?php echo $f->NUMPZAS; ?>  
                                                </td>       
                                                <td align="right"><?php echo number_format($f->CANT, 2, '.', ','); ?></td>
                                                <td align="right"><?php echo $f->EXISPZAS;?></td>
                                                <td align="right"><?php echo number_format($f->EXISTENCIA, 2, '.', ','); ?>
                                                </td>
                                            
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