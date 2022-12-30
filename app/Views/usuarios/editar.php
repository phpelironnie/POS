<div id="layoutSidenav_content">
    <main>
    <div class="container-fluid px-4">

            <h1 class="mt-4"><?php echo $titulo; ?></h1>
            
            <?php if(isset($validation)){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php }?>

            <form method="POST" action="<?php echo base_url(); ?>/usuarios/actualizar" autocomplete="off" >
            
            <?php csrf_field(); ?>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Usuario:</label>
                        <input id="usuario" value="<?php echo $usuario['usuario']; ?>" class="form-control" type="text" name="usuario" autofocus required />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Nombre:</label>
                        <input id="nombre" value="<?php echo $usuario['nombre']; ?>" class="form-control" type="text" name="nombre" required />
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Caja:</label>
                        <select class="form-select" aria-label="Default select example" id="id_caja" name="id_caja" required>
                            <option value="">Seleccionar caja</option>
                            <?php foreach($cajas as $caja){ ?>
                                <option value="<?php echo $caja['id']; ?>" <?php if($caja['id'] == $usuario['id_caja']) {echo 'selected';} ?>><?php echo $caja['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Rol:</label>
                        <select class="form-select" aria-label="Default select example" id="id_rol" name="id_rol" required>
                            <option value="">Seleccionar un rol</option>
                            <?php foreach($roles as $rol){ ?>
                                <option value="<?php echo $rol['id']; ?>" <?php if($rol['id'] == $usuario['id_rol']) {echo 'selected';} ?>><?php echo $rol['nombre']; ?></option> 
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <br>

            <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </main>