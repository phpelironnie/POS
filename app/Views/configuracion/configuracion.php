<div id="layoutSidenav_content" style="background: rgb(249, 247, 193)">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <?php if(isset($validation)){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php }?>

            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/configuracion/actualizar" autocomplete="off" >
            
            <?php csrf_field(); ?>


            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-6"> 
                        <img src="<?php echo base_url(); ?>/images/logo.png" class="img-responsive img-fluid rounded mx-auto d-block" class="img-responsive" width="470">
                    </div><!--width="100" height="500"-->

                    <div class="col-12 col-sm-6">
                        <label>Nombre de la tienda</label>
                        <input id="tienda_nombre" value="<?php echo $nombre['valor'] ?>" class="form-control" type="text" name="tienda_nombre" autofocus required />
                            <br>
                        <label>RUC</label>
                        <input id="tienda_rfc" value="<?php echo $rfc['valor'] ?>" class="form-control" type="text" name="tienda_rfc" required />
                            <br>
                        <label>Correo de la tienda</label>
                        <input id="tienda_email" value="<?php echo $email['valor'] ?>" class="form-control" type="text" name="tienda_email" required />
                            <br>
                        <label>Telefono de la tienda</label>
                        <input id="tienda_telefono" value="<?php echo $telefono['valor'] ?>" class="form-control" type="text" name="tienda_telefono" required />
                    </div>

                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>Direccion de la tienda</label>
                        <textarea class="form-control" id="tienda_direccion" name="tienda_direccion" rows="3" required><?php echo $direccion['valor'] ?></textarea>
                    </div> 

                    <div class="col-12 col-sm-6">
                        <label>Leyenda del ticket</label>
                        <textarea class="form-control" id="ticket_leyenda" name="ticket_leyenda" rows="3" required><?php echo $leyenda['valor'] ?></textarea>
                    </div>
                </div>
            </div>

            <br>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <label>LOGOTIPO</label><br>
                        <input class="form-control" type="file" id="tienda_logo" name="tienda_logo" accept="image/png">
                        <p class="text-success">Cargar imagen en formato png</p>
                    </div>       
                    <div class="col-12 col-sm-6">
                        <br>
                        <a href="<?php echo base_url(); ?>/configuracion" class="btn-lg btn btn-primary">Regresar</a>
                        <button type="submit" class="btn-lg btn btn-success">Guardar</button>
                    </div>                             
                </div>
            </div> 

            </form>
            
        </div>
    </main>
    
    <!--BORRAR/MODAL-->
    <div class="modal fade" id="modal-confirma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Eliminar Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Desea eliminar este registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <a  class="btn btn-success btn-ok">Confirmar</a>
                </div>
            </div>
        </div>
    </div>
