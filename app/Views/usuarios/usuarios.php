<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/usuarios/nuevo" class="btn btn-success">Agregar</a>
                    <a href="<?php echo base_url(); ?>/usuarios/eliminados" class="btn btn-info">Eliminados</a>
                </p>
            </div>
            
            <table id="example" class="table display border table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($datos as $dato) { ?>

                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['usuario']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>

                            <td>
                                <!--EDITAR-->
                                <a href="<?php echo base_url(); ?>/usuarios/editar/<?php echo $dato['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-square-pen"></i> Editar</a>
                                <!--BORRAR-->
                                <a href="#" data-href="<?php echo base_url(); ?>/usuarios/eliminar/<?php echo $dato['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-confirma"  title="Eliminar registro" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Borrar</a>
                            </td>
                        </tr>

                    <?php } ?>
                    
                </tbody>

            </table>
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
