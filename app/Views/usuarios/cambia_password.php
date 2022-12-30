<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <?php if(isset($validation)){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php }?>
            
            <?php if(isset($mensaje)){?>
                <div class="alert alert-success" role="alert">
                    <?php echo $mensaje; ?>
                </div>
            <?php }?>

            <form method="POST" action="<?php echo base_url(); ?>/usuarios/actualizar_password" autocomplete="off" >
            
            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Usuario:</label>
                        <input id="usuario" value="<?php echo $usuario['usuario']; ?>" class="form-control" type="text" name="usuario" disabled />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Nombre:</label>
                        <input id="nombre" value="<?php echo $usuario['nombre']; ?>" class="form-control" type="text" name="nombre" disabled />
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Contraseña:</label>
                        <input id="password" name="password" class="form-control" type="password" required />
                    </div>

                    <div class="col-12 col-sm-6">
                        <label>Confirma contraseña:</label>
                        <input id="repassword" name="repassword" class="form-control" type="password" required />
                    </div>
                </div>
            </div>

            <br>

            <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">Regresar</a>
            <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </main>