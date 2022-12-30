<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>
            
            <?php \Config\Services::validation()->listErrors() ?>

            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/productos/actualizar" autocomplete="off" >
            
            <?php csrf_field(); ?>

            <input type="hidden" name="id" id="id" value="<?php echo $productos['id']; ?>">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Código:</label>
                        <input id="codigo" class="form-control" type="text" value="<?php echo $productos['codigo']; ?>" name="codigo" autofocus required />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Nombre:</label>
                        <input id="nombre" class="form-control" type="text" value="<?php echo $productos['nombre']; ?>" name="nombre" autofocus required />
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Unidad:</label>
                        <select class="form-control" id="id_unidad" name="id_unidad" required>
                            <option value="">Seleccionar unidad</option>
                            <?php foreach($unidades as $unidad){ ?>
                                <option value="<?php echo $unidad['id']; ?>" <?php if($unidad['id'] == $productos['id_unidad']) {echo 'selected';} ?>> <?php echo $unidad['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Categoria:</label>
                        <select class="form-control" id="id_categoria" name="id_categoria" required>
                            <option value="">Seleccionar unidad</option>
                            <?php foreach($categorias as $categoria){ ?>
                                <option value="<?php echo $categoria['id']; ?>" <?php if($categoria['id'] == $productos['id_categoria']) {echo 'selected';} ?>> <?php echo $categoria['nombre']; ?></option>
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
                        <input id="precio_venta" value="<?php echo $productos['precio_venta']; ?>" 
                        class="form-control" type="text" name="precio_venta" required />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Precio Compra:</label>
                        <input id="precio_compra" value="<?php echo $productos['precio_compra']; ?>" 
                        class="form-control" type="text" name="precio_compra" required />
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Stock Minimo:</label>
                        <input id="stock_minimo" value="<?php echo $productos['stock_minimo']; ?>" class="form-control" type="text" name="stock_minimo" required />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Es inventariable:</label>
                        <select class="form-control" id="inventariable" name="inventariable" required>
                            <option value="1" <?php if($productos['inventariable'] == 1) echo 'selected'; ?>>Si</option>
                            <option value="0" <?php if($productos['inventariable'] == 0) echo 'selected'; ?>>No</option>
                        </select>
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Imagen</label><br>
                        <img class="img-thumbnail" src="<?php echo base_url() . '/images/productos/'.$productos['id'].'.png';?>" width="100px" alt="">
                        <input class="form-control" type="file" id="img_producto" name="img_producto" accept="image/png/jpg">
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