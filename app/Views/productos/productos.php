<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>/productos/nuevo" class="btn btn-success me-2">Agregar</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>/productos/eliminados" class="btn btn-info me-2">Eliminados</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>/productos/generaBarras" class="btn btn-primary me-2">Codigos de barras</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <a href="<?php echo base_url(); ?>/productos/muestraProductosPdf" class="btn btn-outline-info me-2">Reporte PDF</a>
                    </form>
                    </div>
                </div>
            </nav>
            
            <br>
            
            <table id="productos" class="table display border table-bordered" style="width:100%">
                <thead>
                    <tr>                       
                        <th>Id</th>
                        <th>Código</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Ventas</th> 
                        <th>Existencias</th>

                        <th>ACCIONES</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($datos as $dato) { ?>

                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['codigo']; ?></td>
                            <td><img src="<?php echo base_url() . '/images/productos/'.$dato['id'].'.png';?>" alt="" width="90px"></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td><?php echo $dato['precio_venta']; ?></td>
                            <td><?php echo $dato['ventas']; ?></td>
                            <td><?php echo $dato['existencias']; ?></td>
                            
                            <td>
                                <!--EDITAR-->
                                <a href="<?php echo base_url(); ?>/productos/editar/<?php echo $dato['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-square-pen"></i> &nbsp Editar</a>
                                &nbsp
                                <!--BORRAR-->
                                <a href="#" data-href="<?php echo base_url(); ?>/productos/eliminar/<?php echo $dato['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-confirma"  title="Eliminar registro" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> &nbsp Eliminar</a>
                            </td>
                        </tr>

                    <?php } ?>
                    
                </tbody>
            </table>

        </div>
    </main>
    
    <!--BORRAR/MODAL-->
    <div class="modal fade" id="modal-confirma" data-bs-backdrop="static" data-bs-keyboard="false" 
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Agotar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Esta seguro de ocultar este producto?</p>
                    <p>Al ejecutar esta accion admite que la cantidad del producto seleccionado es 0</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <a  class="btn btn-success btn-ok">Confirmar</a>
                </div>
            </div>
        </div>
    </div>