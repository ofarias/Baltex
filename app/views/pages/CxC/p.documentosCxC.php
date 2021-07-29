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
                <p>Filtros:</p>
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-documentos">
                        <thead>
                            <tr>
                                <th>Ln <input type="checkbox" class="selAll"></th>
                                <th>CLAVE</th>
                                <th>NOMBRE</th>
                                <!--<th>Acumulado</th>-->
                                <th>DOCUMENTO</th>
                                <th>DIAS VENCIDO</th>
                                <th>FECHA DOCUMENTO</th>
                                <th>FECHA VENCIMIENTO</th>
                                <th>IMPORTE&nbsp; DOCUMENTO &nbsp;&nbsp;</th>
                                <th>CARGOS</th>
                                <th>ABONOS</th>
                                <th>SALDO &nbsp;ACTUAL&nbsp;&nbsp;&nbsp;</th>
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
                                <td><input type="checkbox" value="<?php echo $docs->DOCUMENTO?>" class="sel"></td>
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
    var opc = <?php echo "'".$opc."'"?>;
    var ctrl= 0;

    $(".cle").autocomplete({
        source: "index.cxc.php?cliente=1",
        minLength: 2,
        select: function(event, ui){
        }
    })
    
    $(".vnd").autocomplete({
        source: "index.cxc.php?vendedor=1",
        minLength: 2,
        select: function(event, ui){
        }
    })

    $(".filtrar").click(function (){
        const cle = $(".cle").val()
        const vnd = $(".vnd").val()
        const fini = $(".fini").val()
        const ffin = $(".ffin").val()
        const emp = $(".emp").val()
        window.open("index.cxc.php?action=menuCxC&opc=d:"+cle+":"+vnd+":"+fini+":"+ffin+":"+emp, "_self")
    })

    $(".xls").click(function(){
        ctrl = seleccion()
        if(ctrl >= 1 ){
            $.confirm({
                title:'Generador de XLS',
                content:'Se detectó por lo menos una selección, desea generar el excel con:',
                buttons:{
                    Seleccion:function(){
                        imprimeSel()
                    }, 
                    Todo:function(){
                        generaXLS()
                    },
                    Cancelar:function(){
                        return
                    }
                }
            })
        }else{
            generaXLS()
        }
    })

    function seleccion(){
        ctrl = 0;
        $(".sel").each(function(index){
            if($(this).prop("checked")){
                ctrl= ctrl +1;  
            }
        })
        return ctrl
    }

    function imprimeSel(){
        var docs= [];
        $(".sel").each(function(index){
            if($(this).prop("checked")){
                docs.push($(this).val());  
            }
        })
        opc = opc+':'+docs
        generaXLS()
    }

    function generaXLS(){
        $.confirm({
                    content: function () {
                        var self = this;
                        return $.ajax({
                                    url:'index.cxc.php',
                                    type:'post',
                                    dataType:'json',
                                    data:{report:1, t:'y', opc},
                        }).done(function (data) {
                            self.setContent('Se ha descargado el archivo');
                            self.setTitle('Reportes del almacen');
                                if(data.status == 'ok'){
                                        window.open( data.completa , 'download')
                                        opc = <?php echo "'".$opc."'"?>;
                              }
                        }).fail(function(){
                            self.setContent('Algo ocurrio y no pude procesarlo, intente nuevamente.');
                            opc = <?php echo "'".$opc."'"?>;

                        });
                    }
            });
    }

    $(".selAll").click(function(){
        if($(this).prop("checked")){
            $(".sel").each(function(index){
                $(this).prop("checked",true)
            })
        }else{
            $(".sel").each(function(index){
                $(this).prop("checked",false)
            })
        }
    })

</script>
