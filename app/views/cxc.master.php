<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema Baltex</title>
    
    <!--Jquery UI-->
    <!-- Bootstrap Core CSS -->
    <link href="app/views/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="app/views/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="app/views/bower_components/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    
    <link href="app/views/dist/css/baltexcxc.css" rel="stylesheet">
    
    <!--<link href="app/views/dist/css/datosprov.css" rel="stylesheet">-->
    <!--confim-->
    <link href="app/views/dist/confirm/css/jquery-confirm.css" rel="stylesheet" />
    <!-- Custom Fonts -->
    <!--<link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" href="app/views/bower_components/font-awesome/css/font-awesome.min.css">
    <!--jQuery UI Core-->
    <link rel="stylesheet" href="app/views/bower_components/jquery-ui/themes/smoothness/jquery-ui.css">
    <!--<link rel="stylesheet" href="/resources/demos/style.css">-->
    <!--jQuery time-->
    <!--<link rel="stylesheet" href="app/views/dist/css/bootstrap-timepicker.css" />-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
            <div class="row">
                <br/><br/>
            </div>
            <div class="row">
                <div class="col-lg-12">
                      <div class="form-group">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" name="c" value="Clientes" class="btn-sm btn-info exec">
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" name="d" value="Documentos" class="btn-sm btn-success exec">
                        &nbsp;&nbsp;&nbsp;
                        <!--<input type="button" name="" value="Cartera" class="btn-sm btn-warning exec">
                        &nbsp;&nbsp;&nbsp;-->
                        <input type="button" name="k" value="KPI" class="btn-sm btn-primary exec">
                        &nbsp;&nbsp;&nbsp;
                        <!--<input type="button" name="r" value="Reportes" class="btn btn-secondary exec">
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" name="o" value="Monitor de Ordenes" class="btn btn-primary exec">
                        -->
                      </div>  
                </div>
            </div>

</head>
<body>
    <div class="container-fluid">
        <!--<div id="wrapper">-->
            <!-- header  -->
        
            <div id="header">        
               #HEADER#
            </div>
            <!-- end: header  -->       
            <!-- columna izquierda  -->
            <!--<div id="leftcolumn">        
              #MENULEFT#
            </div>-->
            <!-- end: columna izquierda  -->         
            <!-- contenido -->
            <div id="content">      
              #CONTENIDO#        
            </div>
            <!-- end: contenido -->     
        <!--</div>--> 
        <!--<div id="footer">
            #FOOTER#
        </div>-->
    </div>
    <!-- jQuery -->
    <!--<script type="text/javascript" language="JavaScript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>-->
    <script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="app/views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="app/views/bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <!-- DataTables JavaScript -->
    <!-- <script type="text/javascript" language="JavaScript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> -->
    <script type="text/javascript" language="JavaScript" src="app/views/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <!--<script src="app/views/bower_components/DataTables/media/js/jquery.dataTables.js"></script>      
    <script src="app/views/bower_components/DataTables/media/js/dataTables.bootstrap.js"></script>-->    
    <!-- Custom Theme JavaScript -->
    <script src="app/views/dist/js/sb-admin-2.js"></script> 
    <!--confirm-->
    <script src="app/views/dist/confirm/js/jquery-confirm.js"></script>  
    <!--jQuery UI JS-->
    <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
    <script type="text/javascript" language="JavaScript" src="app/views/dist/js/jquery-ui/jquery-ui.min.js"></script>
    <!--JS Timepicker-->
    <!--<script type="text/javascript" language="JavaScript" src="app/views/dist/js/bootstrap-timepicker.js"></script>-->
     <!--<script>
          $(function() {
            $( ".datepicker" ).datepicker({ 
                dateFormat: 'dd/mm/yy', 
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] }).val();
          });
    </script>-->
    <script>
    //$(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true,
                lengthMenu: [[200,-1], [200,"Todo"]],
                columnDefs:[
                    {
                        targets: [3,5,6],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });


        $('#dataTables-clientes').DataTable({
                responsive: true,
                lengthMenu: [[100,-1], [100,"Todo"]],
                columnDefs:[
                    {
                        targets: [0,1,2,4,5],
                        searchable: true
                    }
                ],
                order: [[ 0, "desc" ]],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // si es string lo cambiamos a entero
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // muestra total en todas las paginas la suma es unicamente por pagina
                    total = api
                        .column( 1 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // total de la pagina actual
                    pageTotal = api
                        .column( 1, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    // actualiza totales en el footer
                    $( api.column( 1 ).footer() ).html(
                        '$'+pageTotal
                    )
                }
        });

    $('#dataTables-documentos').DataTable({
            responsive: true,
            lengthMenu: [[500,-1], [500,"Todo"]],
            columnDefs:[
                {
                    targets: [0],
                    searchable: false
                }
            ],
            "order":[[10, "desc"]],
            language: {
                lengthMenu: "Mostrando _MENU_ por pagina",
                zeroRecords: "No hay dato para mostrar",
                info: "Mostrando página _PAGE_ de _PAGES_",
                sSearch: "Buscar: ",
                sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                oPaginate: {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                            }
            }
    });

          $('#dataTables-kpi').DataTable({
                responsive: true,
                lengthMenu: [[200,-1], [200,"Todo"]],
                columnDefs:[
                    {
                        targets: [0],
                        searchable: false
                    }
                ],
                language: {
                    lengthMenu: "Mostrando _MENU_ por pagina",
                    zeroRecords: "No hay dato para mostrar",
                    info: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch: "Buscar: ",
                    sInfoFiltered:   "(Filtrado de un total de _MAX_ registros)",                   
                    oPaginate: {
                                    "sFirst":    "Primero",
                                    "sLast":     "Último",
                                    "sNext":     "Siguiente",
                                    "sPrevious": "Anterior"
                                }
                }
        });

    </script>  

<script>
              
  $(function() {
    $( "#dialog" ).dialog({
      autoOpen: false,
      width: 400,
      height: 200,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#opener" ).click(function() {
      $( "#dialog" ).dialog( "open" );
    });
  });
        </script>
        <script>
              
  $(function() {
    $( "#dialoga" ).dialog({
      autoOpen: false,
      width: 400,
      height: 200,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#openera" ).click(function() {
      $( "#dialoga" ).dialog( "open" );
    });
  });
        </script>
        <script>
              
  $(function() {
    $( "#dialogU" ).dialog({
      autoOpen: false,
      width: 700,
      height: 500,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#openeU" ).click(function() {
      $( "#dialogU" ).dialog( "open" );
    });
  });
        </script>
        <script>
              
  $(function() {
    $( "#dialogAP" ).dialog({
      autoOpen: false,
      width: 1200,
      height: 500,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });
 
    $( "#openeAP" ).click(function() {
      $( "#dialogAP" ).dialog( "open" );
    });
  });
        </script>
    <script>
        $(".exec").click(function(){
            var opc = $(this).attr('name')
            window.open('index.cxc.php?action=menuCxC&opc='+opc, '_self')
        })
    </script>
</body>
</html>