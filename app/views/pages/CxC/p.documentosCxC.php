<style type="text/css">
    .num {
        width: 5em;
    }
</style>
<br/>
<br/>
<?php $total= 0; foreach($documentos as $d){
    $total = $total + $d->SALDO; 
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Documentos con Saldo Pendiente
                <br/><br/>
                <p>Saldo Total: <font color="white">$ <?php echo number_format($total,2)?></font></p>
            </div>
            <div class="panel-body">
                <p>Filtros:</p>
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-documentos">
                        <thead>
                            <tr>
                                <th>Ln</th>
                                <th>CLAVE</th>
                                <th>NOMBRE</th>
                                <!--<th>Acumulado</th>-->
                                <th>DOCUMENTO</th>
                                <th>Dias vencimiento</th>
                                <th>FECHA DOCUMENTO</th>
                                <th>FECHA VENCIMIENTO</th>
                                <th>IMPORTE</th>
                                <th>CARGOS</th>
                                <th>ABONOS</th>
                                <th>SALDO</th>
                                <!--<th>DIAS DE CREDITO</th>-->
                                <th>VENDEDOR</th>
                                <th>Empresa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;  foreach($documentos as $docs): $i++; 
                            ?>
                            <tr class="color" id="linc<?php echo $i?>">
                                <td><input type="checkbox" value="<?php echo $docs->CVE_DOC?>"></td>
                                <td><?php echo $docs->ID_CLIENTE?></td>
                                <td><?php echo '<b>'.utf8_decode($docs->CLIENTE)?></td>
                                <td><?php echo $docs->DOCUMENTO?></td>
                                <td><?php echo $docs->DIAS_VENCIDO?></td>
                                <td align="center"><?php echo substr($docs->FECHA_DOCUMENTO,0, 10)?></td>
                                <!--<td><?php echo number_format(($docs->SALDO/$total)*100,2) ?> % </td>-->
                                <td align="center"><?php echo substr($docs->FECHA_VEN,0,10)?></td>
                                <td align="right"><b><?php echo '$ '.number_format($docs->TOTAL,2)?></b></td>
                                <td align="right"><b><?php echo '$ '.number_format($docs->CARGOS,2)?></b></td>
                                <td align="right"><b><?php echo '$ '.number_format($docs->PAGOS,2)?></b></td>
                                <td align="right"><font color="red"><b><?php echo '$ '.number_format($docs->SALDO,2)?></b></font></td>
                                <!--<td align="center"><?php echo $docs->DIASCRED?></td>-->
                                <td><b><?php echo $docs->VENDEDOR?></b></td>
                                <td><?php echo $docs->EMPRESA?></td>
                                
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

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
