<br/>
    <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Comprobantes de Pago.
                        </div>

                        <div class="panel-body">
                        <input type="email" placeholder="Correo Adicional, para multiples separar con comas ','' " id="adicional" size="200" value=""><br/><br/>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-comprobantes" >
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>UUID</th>
                                            <th>Cliente (Clave SAE)</th>
                                            <th>Fecha</th>
                                            <th>Fecha Cancelacion</th>
                                            <th>Correo</th>
                                            <th>Enviar</th>
                                            <th>Costo Unitario</th>
                                            <th></th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        $sub=0;
                                        $pzas=0;

                                        foreach ($comprobantes as $data):
                                            $fecha= substr($data->FECHA_CERT, 0,10);
                                            $documento = $data->RFC.'('.$data->SERIE.$data->FOLIO.')'.substr($fecha,8,2).'-'.substr($fecha,5,2).'-'.substr($fecha,0,4);
                                            $color='';
                                            if($data->METODODEPAGO == 'Correo'){
                                                $color= "style='background-color:#DEE99D;'";
                                            }
                                           ?>

                                        <tr class="odd gradeX" <?php echo $color?> >
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->UUID;?></td>
                                            <td><font color="" ><b><?php echo $data->NOMBRE;?></b></font></td>
                                            <td><?php echo $data->FECHA_CERT;?></td>
                                            <td><font color="brown"><b><?php echo $data->FECHA_CANCELA;?></b></font></td>
                                            <td align="left"><?php echo $data->CORREO;?></td>
                                            <td align="center" ><input type="button" value="Enviar"correo="<?php echo $data->CORREO?>" class="ejecutar" tipo="e" docu="<?php echo $documento?>" doc="<?php echo $data->CVE_DOC?>">
                                            </td>        
                                            <td align="right">
                                                <a href='/Facturas/timbradas/<?php echo $documento?>.pdf' download><img src="app/views/images/pdf.jpg" width="25" height="30" border="0"></a>
                                                <a href='/Facturas/timbradas/<?php echo $documento?>.xml' download><img src="app/views/images/xml.jpg" width="25" height="30" border="0"></a></td>        
                                            <td align="right"></td>  
                                        </tr>
                                        <?php endforeach; ?>
                                       
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    $(".ejecutar").click(function(){
        var correo = $(this).attr('correo')
        var docu = $(this).attr('docu')
        var doc = $(this).attr('doc')
        var adi = document.getElementById('adicional').value
            //alert('Se envia el '+ docu +' por correo a ' + correo + ' , ' + adi)
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{enviar:1, docu, correo, adi, doc},
                success:function(datd){
                    alert('Se ha enviado correctamente el comprobante ' +  docu + 'al correo ' + correo)
                }, 
                error:function(){
                    alert('Revise la informacion')
                }
            })
    })

</script>
