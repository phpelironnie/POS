<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            
            <?php $idVentaTmp = uniqid(); ?>

            <br>

            <form id="form_venta" name="form_venta" class="form-horizontal" method="POST" action="<?php echo base_url(); ?>/ventas/guarda" autocomplete="off">

            <input type="hidden" name="id_venta" id="id_venta" value="<?php echo $idVentaTmp ?>">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="ui-widget" >
                            <label>Cliente: </label>
                            <input id="id_cliente" name="id_cliente" type="hidden" value="1"/>
                            <input id="cliente" name="cliente" class="form-control" type="text" placeholder="Escribe el nombre del cliente" value="Público en general" onkeyup="" autocomplete="off" required/>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Forma de pago: </label>
                        <select name="forma_pago" id="forma_pago" class="form-select" aria-label="Default select example" required>
                            <option selected>Selecciona una opcion</option>
                            <option value="001">Efectivo</option>
                            <option value="002">Tarjeta de credito/debito</option>
                            <option value="003">Transferencia Movil</option>
                        </select>
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <input id="id_producto" type="hidden" name="id_producto"/>
                        <label>Código de barras</label>

                        <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Escribe el codigo" onkeyup="agregarProducto(event, this.value, 1, <?php echo $idVentaTmp; ?>);" autofocus/>
                    </div>

                    <div class="col-sm-2">
                        <label for="codigo" id="resultado_error" style="color:red" ></label>
                    </div>

                    <div class="col-12 col-sm-4">
                        <label style="font-weight: bold; font-size: 30px; text-align: center;"> Total $</label>
                        <input type="text" name="total" id="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;"/>
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <button type="button" id="completa_venta" class="btn btn-success">Completar venta</button>
            </div>

            <br>
                
            <div class="row">
                <table id="tablaProductos" width="100%" class="table table-responsive table-striped table-hover table-sm tablaProductos ">
                <thead class="table-dark" >
                    <tr>
                        <th>#</th>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th width="1%">-</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th></th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <th></th>
                    </tr>
                </tbody>
                </table>
            </div>

        </div>
    </main>

    <script>
        $(function(){
            $("#cliente").autocomplete({
                source: "<?php echo base_url(); ?>/clientes/autocompleteData",
                minLength: 2,
                select: function(event, ui){
                    event.preventDefault();
                    $("#id_cliente").val(ui.item.id);
                    $("#cliente").val(ui.item.value);
                }
            });
        });

        $(function(){
            $("#codigo").autocomplete({
                source: "<?php echo base_url(); ?>/productos/autocompleteData",
                minLength: 2,
                select: function(event, ui){
                    event.preventDefault();
                    $("#codigo").val(ui.item.value);
                    setTimeout(
                        function(){
                            e = jQuery.Event("keypress");
                            e.which = 13;
                            agregarProducto(e, ui.item.id, 1, '<?php echo $idVentaTmp; ?>');
                        }
                    )
                }
            });
        });

        function agregarProducto(e, id_producto, cantidad, id_venta){
            let enterKey = 13;
            if(codigo != ''){
                if(e.which == enterKey){
                    if(id_producto != null && id_producto != 0 && cantidad > 0){
                        $.ajax({
                            url: '<?php echo base_url(); ?>/TemporalCompra/insertar/' + id_producto + "/" + cantidad + "/" + id_venta,
                            
                            success: function(resultado){
                                if(resultado == 0){
                                    
                                }
                                else{

                                    var resultado = JSON.parse(resultado);

                                    if(resultado.error == ''){
                                        $("#tablaProductos tbody").empty();
                                        $("#tablaProductos tbody").append(resultado.datos);
                                        $("#total").val(resultado.total);

                                        $("#id_producto").val('');
                                        $("#codigo").val('');
                                        $("#nombre").val('');
                                        $("#cantidad").val('');
                                        $("#precio_compra").val('');
                                        $("#subtotal").val('');
                                    }

                                }
                            }
                        })
                    }
                }
            }
        }

        //ELIMINA
        function eliminaProducto(id_producto, id_venta){

            $.ajax({
                url: '<?php echo base_url(); ?>/TemporalCompra/eliminar/' + id_producto + "/" + id_venta,
                
                success: function(resultado){
                    if(resultado == 0){
                        $(tagCodigo).val('');
                    }
                    else{

                        var resultado = JSON.parse(resultado);

                        $("#tablaProductos tbody").empty();
                        $("#tablaProductos tbody").append(resultado.datos);
                        $("#total").val(resultado.total);
                            
                    }
                }
            })
        }

        //completar
        $(function(){
            $("#completa_venta").click(function(){
                let nFilas = $("#tablaProductos tr").length;

                if(nFilas < 2){
                    alert("Debe agregar un producto");
                }
                else{
                    $("#form_venta").submit();
                }
            });
        });

    </script>
    