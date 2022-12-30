<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <?php if(isset($validation)){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php }?>

            <form method="POST" action="<?php echo base_url(); ?>/unidades/actualizar" autocomplete="off" >
            
            <input type="hidden" value="<?php echo $datos['id']?>" name="id">

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Nombre:</label>
                        <input id="nombre" value="<?php echo $datos['nombre']?>" 
                        class="form-control" type="text" name="nombre" autofocus required />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Nombre Corto:</label>
                        <input id="nombre_corto" value="<?php echo $datos['nombre_corto']?>" 
                        class="form-control" type="text" name="nombre_corto" required />
                    </div>
                </div>
            </div>

            <br>

            <a href="<?php echo base_url(); ?>/unidades" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </main>