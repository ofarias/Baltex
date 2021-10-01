<style type="text/css">
    #izq0{
        height:50%;
        /*background-color:#BDD2EF;*/
        float:left;
        width:50%;
        margin-left:auto;
        margin-right:auto;
        margin-top:auto;
        left:10; right:10; top:3;
    }
    #der0{
        height:50%;
        /*background-color:#DAF7E2;*/
        float:right;
        width:50%;
        margin-left:auto;
        margin-right:auto;
        margin-top:auto;
        left:10; right:10; top:3;

    }
    #izq1{
        height:50%;
        /*background-color:#BDD2EF;*/
        float:left;
        width:50%;
        margin-left:auto;
        margin-right:auto;
        margin-top:auto;
        left:10; right:10; top:3;
    }
    #der1{
        height:50%;
        /*background-color:#DAF7E2;*/
        float:right;
        width:50%;
        margin-left:auto;
        margin-right:auto;
        margin-top:auto;
        left:10; right:10; top:3;
    }
</style>

<div>
    <h2>Filtro</h2>
    <p>Fecha inicial: <input type="date" > &nbsp;&nbsp;&nbsp;&nbsp; Fecha Final: <input type="date"> &nbsp;&nbsp;&nbsp;&nbsp; Cliente: <input type="text" placeholder="Cliente"> &nbsp;&nbsp;&nbsp;&nbsp; Vendedor <input type="text" placeholder="vendedor"> 
    &nbsp;&nbsp;&nbsp;&nbsp; Empresa <select>
        <option value="3">Seleccione empresa</option>
        <option value="1">Baltex</option> 
        <option value="2">Prueba</option>
    </select>
    </p>
    <p><b>Se muestra la estadistica del <?php echo $fi ?> al <?php echo $ff?></b></p>
</div>
<br/>
<div>
            <div >
                <div id="izq0" align="center"  style="margin: 0px;">
                    <img src="app/views/pages/graphs/cxcporven.php?fi=<?php echo $fi?>&ff=<?php echo $ff?>&anio=<?php echo $anio?>"  class="grafica " id="gfs0"/> 
                </div>
                <div id="der0" align="center" style="margin: 0px;">
                    <img src="app/views/pages/graphs/cxcporvenrango.php?fi=<?php echo $fi?>&ff=<?php echo $ff?>&anio=<?php echo $anio?>"  class="grafica " id="gfs1"/> 
                </div>
            </div>
<br/>
<br/>
            <div >
                <div id="izq1" align="center" style="margin: 0px;">
                    <img src="app/views/pages/graphs/alphabarex1.php?fi=<?php echo $fi?>&ff=<?php echo $ff?>&anio=<?php echo $anio?>"  class="grafica " id="gfs2"/> 
                </div>
                <div id="der1" align="center" style="margin: 0px;">
                    <img src="app/views/pages/graphs/alphabarex1.php?fi=<?php echo $fi?>&ff=<?php echo $ff?>&anio=<?php echo $anio?>"  class="grafica " id="gfs3"/> 
                </div>
            </div>
<br/>
<br/>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                Indicadores de rendimiento (KPI)
                <br/><br/>
                <p><label>Fecha Inicial: <?php echo $kpi['fi']?></label></p>
                <p><label>Fecha Final: <?php echo $kpi['ff']?></label></p>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-kpi">
                        <thead>
                            <tr>
                                <th>%</th>
                                <th>Antigüedad</th>
                                <th>Monto</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;  foreach($info as $key => $val): $i++; 
                            ?>
                            <tr class="color" id="linc<?php echo $i?>">
                                <td>%</td>
                                <td><?php echo '<font color="blue">'.$key.'</font>'?></td>
                                <td><?php echo '$ '.number_format($val,2)?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="14"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                Indicadores de rendimiento (KPI)
                <br/><br/>
                <p><label>Fecha Inicial: <?php echo $kpi['fi']?></label></p>
                <p><label>Fecha Final: <?php echo $kpi['ff']?></label></p>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-kpi">
                        <thead>
                            <tr>
                                <th>%</th>
                                <th>Antigüedad</th>
                                <th>Monto</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;  foreach($info as $key => $val): $i++; 
                            ?>
                            <tr class="color" id="linc<?php echo $i?>">
                                <td>%</td>
                                <td><?php echo '<font color="blue">'.$key.'</font>'?></td>
                                <td><?php echo '$ '.number_format($val,2)?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="14"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div>
    <h2>Historico  <input type="checkbox" > </h2>
    <p>Fecha inicial: <input type="date" > &nbsp;&nbsp;&nbsp;&nbsp; Fecha Final: <input type="date"> &nbsp;&nbsp;&nbsp;&nbsp; Cliente: <input type="text" placeholder="Cliente"> &nbsp;&nbsp;&nbsp;&nbsp; Vendedor <input type="text" placeholder="vendedor"> 
    &nbsp;&nbsp;&nbsp;&nbsp; Empresa <select>
        <option value="3">Seleccione empresa</option>
        <option value="1">Baltex</option> 
        <option value="2">Prueba</option>
    </select>
</p>
</div>
<img src="app/views/pages/graphs/alphabarex1.php?fi=<?php echo $fi?>&ff=<?php echo $ff?>&anio=<?php echo $anio?>" width="1000px" height="600px"/>
-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>