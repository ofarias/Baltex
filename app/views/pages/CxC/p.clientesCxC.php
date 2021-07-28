<style type="text/css">
    .num {
        width: 5em;
    }
</style>
<br/>
<br/>

<?php   $total=0; 
        foreach($clientes as $key){
            $total += $key->SALDO;
        } 
?>
    
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Clientes con Saldo Pendiente
                <br/><br/>
                <p>Saldo Total: <font color="white">$ <?php echo number_format($total,2)?></font></p>
                <p> Cliente: <font color="black"><input type="text" class="cle" placeholder="Nombre o clave ">&nbsp;&nbsp;</font>
                    Vendedor: <font color="black"><input type="text" class="vnd" placeholder="Vendedor">&nbsp;&nbsp;</font>
                    Fecha Inicial: <font color="black"><input type="date" class="fini">&nbsp;&nbsp;</font>
                    Fecha Final: <font color="black"><input type="date" class="ffin">&nbsp;&nbsp;</font>
                    Empresa: <font color="black"><select class="emp">
                                <option value="3">Seleccione Empresa</option>
                                <option value="Baltex">Baltex</option>
                                <option value="Prueba">Prueba</option>
                            </select></font>&nbsp;&nbsp;</font>
                    <input type="button" class="btn-sm btn-primary filtrar" value="Filtrar">&nbsp;&nbsp;&nbsp;
                    <input type="button" class="btn-sm btn-success xls" value="Xls">

                </p>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-clientes">
                        <thead>
                            <tr>
                                <th>%</th>
                                <th>CLAVE</th>
                                <th>NOMBRE </th>
                                <th>SALDO</th>
                                <th>DOCUMENTOS <br/> (pendientes de pago)</th>
                                <th>DOC + Antiguo <br/> DOC + Reciente</th>
                                <th>DIAS DE CREDITO <br/>(Actual)</th>
                                <th>VENDEDOR</th>
                                <th>EMPRESA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=0;  foreach($clientes as $clie): $i++; 
                            ?>
                            <tr class="color" id="linc<?php echo $i?>">
                                <td><?php echo number_format($clie->SALDO / $total * 100,2)?> %</td>
                                <td><?php echo '<font color="blue">'.$clie->ID_CLIENTE.'</font>'?></td>
                                <td><?php echo utf8_decode($clie->CLIENTE)?></td>
                                <td align="right"><b><?php echo '$ '.number_format($clie->SALDO,2)?></b></td>
                                <td align="center"><?php echo $clie->DOCUMENTOS?></td>
                                <td><font color = 'red'><?php echo substr($clie->FMIN,0,10).'</font><br/><font color="green">'.substr($clie->FMAX,0,10)?></font></td>
                                <td align="center"><?php echo $clie->DIASCRED?></td>
                                <td><b><?php echo $clie->VENDEDOR?></b></td>
                                <td><?php echo $clie->EMPRESA?></td>
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
<script>

const opc = <?php echo "'".$opc."'"?>

$(".filtrar").click(function (){
    const cle = $(".cle").val()
    const vnd = $(".vnd").val()
    const fini = $(".fini").val()
    const ffin = $(".ffin").val()
    const emp = $(".emp").val()
    window.open("index.cxc.php?action=menuCxC&opc=c:"+cle+":"+vnd+":"+fini+":"+ffin+":"+emp, "_self")
})

$(".xls").click(function(){
    //window.open("index.cxc.php?action=menuCxC&opc=x"+opc, "_self")
    //$.alert('genera excel')

    $.confirm({
            content: function () {
                var self = this;
                return $.ajax({
                            url:'index.cxc.php',
                            type:'post',
                            dataType:'json',
                            data:{report:1, t:'x', opc},
                }).done(function (data) {
                    self.setContent('Se ha descargado el archivo');
                    self.setTitle('Reportes del almacen');
                        if(data.status == 'ok'){
                                window.open( data.completa , 'download')
                      }
                }).fail(function(){
                    self.setContent('Algo ocurrio y no pude procesarlo, intente nuevamente.');
                });
            }
        }); 
})
</script>