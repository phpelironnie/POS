<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/compras/eliminados" class="btn btn-info">Eliminados</a>
                </p>
            </div>
            
            <table class="table display border table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Folio</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Información</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($compras as $compra) { ?>

                        <tr>
                            <td><?php echo $compra['id']; ?></td>
                            <td><?php echo $compra['folio']; ?></td>
                            <td><?php echo $compra['total']; ?></td>
                            <td><?php echo $compra['fecha_alta']; ?></td>

                            <!--Visualizar Compra al detalle-->
                            <td>
                                <a href="<?php echo base_url(); ?>/compras/muestraCompraPdf/<?php echo $compra['id']; ?>" 
                                class="btn btn-warning"><i class="fa-solid fa-file-circle-info"></i> Detalles</a>
                            </td>
                        </tr>

                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </main>
    
    <!--BORRAR/MODAL-->
    <div class="modal fade" id="modal-confirma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
