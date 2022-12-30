<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Registro de ventas</h1>

            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                         <li class="nav-item">
                            <a href="<?php echo base_url(); ?>/ventas/eliminados" class="btn btn-info">Eliminados</a>
                        </li>
                    </ul>
                    <!--<form class="d-flex" role="search">
                        <a href="<?php echo base_url(); ?>/ventas/muestraClientesPdf" class="btn btn-outline-info me-2 disabled">Reporte PDF</a>
                    </div>
                </form>-->
                </div>
            </nav>
            
            <br>
            
            <table class="table display border table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Folio</th>
                        <th>Cajero</th>
                        <th>Cliente</th>
                        <th>Total</th>

                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($datos as $dato) { ?>

                        <tr>
                            <td><?php echo $dato['fecha_alta']; ?></td>
                            <td><?php echo $dato['folio']; ?></td>
                            <td><?php echo $dato['cajero']; ?></td>
                            <td><?php echo $dato['cliente']; ?></td>
                            <td><?php echo $dato['total']; ?></td>

                            
                            <td>
                                <!--EDITAR-->
                                <a href="<?php echo base_url(); ?>/ventas/muestraTicket/<?php echo $dato['id']; ?>" class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver detalle</a>
                            </td>
                            <td>
                                <!--BORRAR-->
                                <a href="#" data-href="<?php echo base_url(); ?>/ventas/eliminar/<?php echo $dato['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-confirma"  title="Eliminar registro" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Borrar</a>
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
