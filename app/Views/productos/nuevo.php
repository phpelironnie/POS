<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>
            
            <?php if(isset($validation)){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php }?>

            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/productos/insertar" autocomplete="off" >
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Código:</label>
                        <input id="codigo" value="<?php echo set_value('codigo') ?>" class="form-control" type="text" name="codigo"  />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Nombre:</label>
                        <input id="nombre" value="<?php echo set_value('nombre') ?>" class="form-control" type="text" name="nombre"  />
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Unidad:</label>
                        <select class="form-control" id="id_unidad" name="id_unidad" >
                            <option value="">Seleccionar unidad</option>
                            <?php foreach($unidades as $unidad){ ?>
                                <option value="<?php echo $unidad['id']; ?>"><?php echo $unidad['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Categoria:</label>
                        <select class="form-control" id="id_categoria" name="id_categoria" >
                            <option value="">Seleccionar unidad</option>
                            <?php foreach($categorias as $categoria){ ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Precio Venta:</label>
                        <input id="precio_venta" value="<?php echo set_value('precio_venta') ?>" 
                        class="form-control" type="text" name="precio_venta" autofocus required />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Precio Compra:</label>
                        <input id="precio_compra" value="<?php echo set_value('precio_compra') ?>" 
                        class="form-control" type="text" name="precio_compra" autofocus required />
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Stock Minimo:</label>
                        <input id="stock_minimo" value="<?php echo set_value('stock_minimo') ?>" 
                        class="form-control" type="text" name="stock_minimo" autofocus required />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Es inventariable:</label>
                        <select class="form-control" id="inventariable" name="inventariable" required>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Imagen</label>
                         
                        <input class="form-control" type="file" id="img_producto" name="img_producto">
                        <p class="text-success">Cargar imagen en formato jpg</p>
                    </div>
                </div>
            </div>

            <br>

            <a href="<?php echo base_url(); ?>/productos" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </main>