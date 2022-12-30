<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"><?php echo $titulo; ?></h1>

            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/categorias/nuevo" class="btn btn-success">Agregar</a>
                    <a href="<?php echo base_url(); ?>/categorias/eliminados" class="btn btn-info">Eliminados</a>
                </p>
            </div>
            
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>EDITAR</th>
                        <th>BORRAR</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($datos as $dato) { ?>

                        <tr>
                            <td><?php echo $dato['id']; ?></td>
                            <td><?php echo $dato['nombre']; ?></td>

                            <td>
                                <a href="<?php echo base_url(); ?>/categorias/editar/<?php echo $dato['id']; ?>" 
                                class="btn btn-warning"><i class="fa-solid fa-square-pen"></i> Editar</a>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>/categorias/eliminar/<?php echo $dato['id']; ?>" 
                                class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Borrar</a>
                            </td>
                        </tr>

                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </main>
