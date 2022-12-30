<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/categorias" class="btn btn-info">Regresar</a>
                </p>
            </div>
            
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>ACCION</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($datos as $dato) { ?>

                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>
                            <td><!--EDITAR-->
                                <a href="<?php echo base_url(); ?>/categorias/reingresar/<?php echo $dato['id']; ?>" 
                                class="btn btn-success"><i class="fa-solid fa-trash-arrow-up"></i> Recuperar</a>
                            </td>
                        </tr>

                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </main>
