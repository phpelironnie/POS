<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/productos" class="btn btn-info">Productos</a>
                </p>
            </div>
            
            <table id="example" class="display border border-success" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Código</th>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Existencias</th>

                        <th>ACCION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($datos as $dato) { ?>

                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['codigo']; ?></td>
                            <td><img src="<?php echo base_url() . '/images/productos/'.$dato['id'].'.png';?>" alt="" width="100px"></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td><?php echo $dato['precio_venta']; ?></td>
                            <td><?php echo $dato['existencias']; ?></td>

                            <!--RESTAURAR-->
                            <td>
                                <a href="#" data-href="<?php echo base_url(); ?>/productos/reingresar/<?php echo $dato['id']; ?>" 
                                data-bs-toggle="modal" data-bs-target="#modal-confirma"  title="Reingresar registro" 
                                class="btn btn-danger"><i class="fa-solid fa-trash-arrow-up"></i> Restaurar</a>
                            </td>
                        </tr>

                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </main>

    <!--ELIMINADOS/MODAL-->
    <div class="modal fade" id="modal-confirma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Restaurar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Desea restaurar este producto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <a  class="btn btn-success btn-ok">Confirmar</a>
                </div>
            </div>
        </div>
    </div>
