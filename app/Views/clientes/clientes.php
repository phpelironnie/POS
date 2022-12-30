<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>/clientes/nuevo" class="btn btn-success me-2">Agregar</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>/clientes/eliminados" class="btn btn-info">Eliminados</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <a href="<?php echo base_url(); ?>/clientes/muestraClientesPdf" class="btn btn-outline-info me-2">Reporte PDF</a>
                    </form>
                    </div>
                </div>
            </nav>
            
            <br>
            
            <table id="example" class="table display border table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Correo</th>

                        <th>ACCIONES</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($datos as $dato) { ?>

                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td><?php echo $dato['direccion']; ?></td>
                            <td><?php echo $dato['telefono']; ?></td>
                            <td><?php echo $dato['correo']; ?></td>

                            
                            <td>
                                <!--EDITAR-->
                                <a href="<?php echo base_url(); ?>/clientes/editar/<?php echo $dato['id']; ?>" 
                                class="btn btn-warning"><i class="fa-solid fa-square-pen"></i></a>
                                     
                                <!--BORRAR-->
                                <a href="#" data-href="<?php echo base_url(); ?>/clientes/eliminar/<?php echo $dato['id']; ?>" 
                                data-bs-toggle="modal" data-bs-target="#modal-confirma"  title="Eliminar registro" class="btn btn-danger"><i 
                                class="fa-solid fa-trash-can"></i></a>
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
