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
        &nbsp;&nbsp;Documento a Revisar:<br/>
        <br/>
        <form action="index.php" method="post">
         &nbsp;&nbsp; &nbsp;&nbsp;Factura:&nbsp;&nbsp; <input type="text" name="doc" placeholder="Documento a Revisar" > &nbsp;&nbsp;<button type="submit" name="cuadre" value="invDia">Consultar</button><input type="hidden" name="emp" value="<?php echo $emp?>">
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
                                            <th>Partida</th>
                                            <th>Articulo</th>
                                            <th>Cantidad</th>
                                            <th>Piezas</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($info as $data): 
                                         ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><font color="" ><b><?php echo $data->NUM_PAR;?></b></font></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->CANT?></td>
                                            <td><?php echo $data->NUMPZAS?></td>
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
<?php if(count($infoM)>0){?>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <center><h2>M O V I M I  E N T O S  A L  I N V E N T A R I O </h2></center>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Documento</th>
                                            <th>Partida</th>
                                            <th>Articulo</th>
                                            <th><font color="red">Piezas Mov</font> <br/><font color="blue"> Piezas Doc</font></th>
                                            <th><font color="red">Cantidad Mov</font> <br/><font color="blue"> Cantidad Mov</font></th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        foreach ($infoM as $data):
                                         ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->FECHA_DOCU;?></td>
                                            <td><?php echo $data->REFER;?></td>
                                            <td><font color="" ><b><?php echo $data->NUM_PAR;?></b></font></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td align="center"><font color="red"><?php echo $data->PIEZA_MOV?></font><br/><font color="blue"><?php echo $data->NUMPZAS?></font></td>
                                            <td align="center"><font color="red"><?php echo $data->MOV?></font><br/><font color="blue"><?php echo $data->CANT?></font>
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