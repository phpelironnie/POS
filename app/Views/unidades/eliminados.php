<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/unidades" class="btn btn-info">Regresar</a>
                </p>
            </div>
            
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Nombre Corto</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($datos as $dato) { ?>

                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td><?php echo $dato['nombre_corto']; ?></td>
                            <!--EDITAR-->
                            <td>
                                <a href="#" data-href="<?php echo base_url(); ?>/unidades/reingresar/<?php echo $dato['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-confirma"  title="Reingresar registro" class="btn btn-danger"><i class="fa-solid fa-trash-arrow-up"></i> Restaurar</a>
                            </td>
                        </tr>

                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </main>

    <!--para reingrar eliminados-->
    <div class="modal fade" id="modal-confirma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Restaurar Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Desea restarurar este registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <a  class="btn btn-success btn-ok">Confirmar</a>
                </div>
            </div>
        </div>
    </div>
