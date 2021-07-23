<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        </div>
                        <div>        
                            <button id="verComprobantes">Ver Comprobantes</button>
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-pago">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Cliente</th>
                                            <th>Fecha<br/>Elaboracion</th>
                                            <th>Fecha <br/> Aplicacion</th>
                                            <th>Documento de Pago</th>
                                            <th>Importe</th>
                                            <th>Tipo de Pago <br/> SAT</th>
                                            <th>Concepto SAE</th>
                                            <th>Documento</th>
                                            <th>Importe Documento</th>
                                            <th>Saldo Documento </th>
                                            <th>Importe Aplicado</th>
                                            <th>Saldo Insoluto</th>
                                            <th>Seleccionar Todos <br/>
                                                <input type="checkbox" id="select_all"> 
                                            </th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $ln = 0;
                                        foreach ($pagos as $data):
                                            $saldoInsoluto=$data->IMPORTE_DOC - $data->IMPORTE;
                                            $saldo= $data->SALDOINS + $data->IMPORTE;
                                            $ln++;
                                            $color="";
                                            if($data->SELECCION == 1){
                                                $color="style='background-color:#99ccff'";
                                            }
                                        ?>
                                       <tr id="ln_<?php echo $ln?>" class="odd gradeX" <?php echo $color?> >
                                            <td><?php echo $ln?></td>
                                            <td><?php echo '('.$data->CVE_CLIE.')'.$data->NOMBRE;?></td>
                                            <td align="center"><?php echo $data->FECHAELAB;?></td>
                                            <td align="center"><?php echo $data->FECHA_APLI?></td>
                                            <td><?php echo $data->DOCTO?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,6)?></td>
                                            <td align="center"><?php echo $data->FORMADEPAGOSAT?></td>
                                            <td align="center"><?php echo $data->NUM_CPTO.'-'.$data->NOM_CPTO?><br/></td>
                                            <td><?php echo $data->NO_FACTURA?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE_DOC,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($saldo,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTE,6)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDOINS,6);?></td>
                                            <td><input type="checkbox" name="seleccionar" 
                                                doc="<?php echo $data->NO_FACTURA?>"
                                                monto="<?php echo $data->IMPORTE?>"
                                                clie="<?php echo $data->CVE_CLIE?>"
                                                idp="<?php echo $data->IDP?>"
                                                ln="<?php echo $ln?>"
                                                class="sel"
                                                id="sel_<?php echo $ln?>"
                                                <?php echo $data->SELECCION==1? 'checked':''?>
                                                >
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                 </tbody>
                                 </table>
                                 <a class="btn btn-success cep" >Elaborar CEP</a>
                      </div>
            </div>
        </div>
    </div>
</div>
<form action="index.php" method="post" id="FORM_ACTION">
    <input type="hidden" name="fol" value="" id="folios">    
    <input type="hidden" name="realizaCEP" value="" >    

</form>
<input type="button" value="cargarXMLs" onclick="caragXML()" class="btn btn-success" >

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    var i = 0;
    $('#select_all').on('click', function(){
        if(this.checked){
            $('.sel').each(function(){
                this.checked = true
                    var idp =$(this).attr('idp')
                    var l = $(this).attr('ln')
                    var tipo = 0
                    var renglon=document.getElementById("ln_"+l)
                tipo=1
                $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{selPago:1, idp, tipo},
                success:function(data){
                    if(tipo == 1){
                        renglon.style.background="#99ccff"
                    }else if(tipo ==0){
                        renglon.style.background="white"
                    }
                },
                error:function(){
                    alert('algo no va bien...')
                    renglon.style.background="white"
                    document.getElementById("sel_"+l)
                    /// Se debe de deseleccionar el pago.
                }
                });
            })
        }else{
                this.checked = false
                var idp =$(this).attr('idp')
                    var l = $(this).attr('ln')
                    var tipo = 0
                    var renglon=document.getElementById("ln_"+l)
                tipo=0
                $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{selPago:1, idp, tipo},
                success:function(data){
                    if(tipo == 1){
                        renglon.style.background="#99ccff"
                    }else if(tipo ==0){
                        renglon.style.background="white"
                    }
                },
                error:function(){
                    alert('algo no va bien...')
                    renglon.style.background="white"
                    document.getElementById("sel_"+l)
                    /// Se debe de deseleccionar el pago.
                }
                });
        }
    })

    $(".sel").click(function(){
        var idp =$(this).attr('idp')
        var l = $(this).attr('ln')
        var tipo = 0
        var renglon=document.getElementById("ln_"+l)
        if($(this).prop('checked')){
            tipo=1
        }
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{selPago:1, idp, tipo},
                success:function(data){
                    if(tipo == 1){
                        renglon.style.background="#99ccff"
                    }else if(tipo ==0){
                        renglon.style.background="white"
                    }
                },
                error:function(){
                    alert('algo no va bien...')
                    renglon.style.background="white"
                    document.getElementById("sel_"+l)
                    /// Se debe de deseleccionar el pago.
                }
            });
    })

    $(".cep").click(function(){
        var docs = '';
        var folios = "";
        $("input:checked").each(function(index){
            folios+= $(this).attr('doc')+ ':' + $(this).attr('clie') +',';
        });
        folios = folios.substr(0, folios.length-1);
        document.getElementById('folios').value=folios;
        $("#FORM_ACTION").submit();
    })
      
    function caragXML(){
        //alert('Carga los archivos')
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{cargaXML:1},
            success:function(data){
                alert('Se ha completado')
            },
            error:function(){
                alert('ocurrio un error')
            }
        })
    }  

    $("#verComprobantes").click(function(){
        window.open('index.php?action=verComprobantes&tipo=T', "_self");
    })
    
</script>
