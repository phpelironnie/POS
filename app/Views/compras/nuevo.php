<?php
    $id_compra = uniqid();
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <br>

            <form method="POST" id="form_compra" name="form_compra" action="<?php echo base_url(); ?>/compras/guarda" autocomplete="off" >
            
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <input id="id_producto" type="hidden" name="id_producto"/>
                            <input id="id_compra" type="hidden" name="id_compra" value="<?php echo $id_compra; ?>"/>
                            <label>Codigo</label>

                            <input id="codigo" class="form-control" type="text" name="codigo" 
                            placeholder="Escribe el codigo" onkeyup="buscarProducto(event, this, this.value)" autofocus/>
                            
                            <label for="codigo" id="resultado_error" style="color: red" ></label>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Nombre del producto</label>
                            <input id="nombre" class="form-control" type="text" name="nombre" disabled />
                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Cantidad</label>
                            <input id="cantidad" class="form-control" type="text" name="cantidad" />
                        </div>

                    </div>
                </div>

                <br>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <label>Precio de compra</label>
                            <input class="form-control" id="precio_compra" name="precio_compra" type="text" disabled/>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label>Subtotal</label>
                            <input class="form-control" id="subtotal" name="subtotal" type="text" disabled/>
                        </div>

                        <div class="col-12 col-sm-4">
                            <label><br><br></label>
                            <button id="agregar_producto" name="agregar_producto" type="button" onclick="agregarProducto(id_producto.value, cantidad.value, '<?php echo $id_compra;?>')" class="btn btn-warning">Agregar Producto</button>
                        </div>
                    </div>
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

                <br>

                <div class="row">
                    <div class="col-12 col-sm-6 offset-md-6">
                        <label style="font-weight: bold; font-size: 30px; text-align: center;"> Total $</label>
                        <input type="text" name="total" id="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;"/>
                        <button type="button" id="completa_compra" class="btn btn-success">Completar compra</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        //AYAX COMPLETAR COMPRA
        $(document).ready(function(){
            $("#completa_compra").click(function(){
                let nFila = $("#tablaProductos tr").length;

                if(nFila < 2){

                }
                else{
                    $("#form_compra").submit();
                }
            });
        });

        //FUNCION BUSCAR
        function buscarProducto(e, tagCodigo, codigo){
            var enterKey = 13;

            //HACER MULTIPLICACION DE CANRIDAD Y SUBTOTAL
            if(codigo != ''){
                if(e.which == enterKey){
                    $.ajax({
                        url: '<?php echo base_url(); ?>/productos/buscarPorCodigo/' + codigo,
                        dataType: 'json',
                        success: function(resultado){
                            if(resultado == 0){
                                $(tagCodigo).val('');
                            }
                            else{
                                $(tagCodigo).removeClass('has-error');

                                $("#resultado_error").html(resultado.error);

                                if(resultado.existe){
                                    $("#id_producto").val(resultado.datos.id);
                                    $("#nombre").val(resultado.datos.nombre);
                                    $("#cantidad").val(1);
                                    $("#precio_compra").val(resultado.datos.precio_compra);
                                    $("#subtotal").val(resultado.datos.precio_compra);
                                    $("#cantidad").focus();
                                }
                                else{
                                    $("#id_producto").val('');
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

        //FUNCION AGREGAR
        function agregarProducto(id_producto, cantidad, id_compra){

            //HACER MULTIPLICACION DE CANRIDAD Y SUBTOTAL
            if(id_producto != null && id_producto != 0 && cantidad > 0){
                $.ajax({
                    url: '<?php echo base_url(); ?>/TemporalCompra/insertar/' + id_producto + "/" + cantidad + "/" + id_compra,
                    
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

        //ELIMINA PRODUCTO
        function eliminaProducto(id_producto, id_compra){

            $.ajax({
                url: '<?php echo base_url(); ?>/TemporalCompra/eliminar/' + id_producto + "/" + id_compra,
                
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
    </script>