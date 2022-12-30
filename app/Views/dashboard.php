<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <br>

            <div class="row">
                <div class="col-12 col-sm-3">
                    <a href="<?php echo base_url(); ?>/productos" class="text-white" style="text-decoration: none">
                        <div class="card text-center shadow text-white bg-info mb-3">
                            <div class="card-header">
                                Total de productos
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <h1><?php echo $totalProductos?> productos</h1>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-3">
                    <a href="<?php echo base_url(); ?>/ventas" class="text-white" style="text-decoration: none">
                        <div class="card text-center shadow text-white bg-warning mb-3">
                            <div class="card-header">
                                Ventas del dia
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <h1><?php echo $NumeroVentas?> ventas</h1>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-3">
                    <a href="<?php echo base_url(); ?>/ventas" class="text-white" style="text-decoration: none">
                        <div class="card text-center shadow text-white bg-success mb-3">
                            <div class="card-header">
                                Ganancias del dia
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    <h1>S/. <?php echo $totalVentas['total'] ?></h1>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="card text-center shadow text-white bg-danger mb-3">
                        <div class="card-header">
                            Productos en stock minimo
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <h1><?php echo $minimos ?> en stock</h1>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <!--<div class="row">
                <div class="col-12 col-sm-3">
                    <div class="card text-center shadow mb-3">
                        <div class="card-header">
                            Cantidad de productos
                        </div>
                        <div class="card-body">
                            <canvas id="chart2" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="card text-center shadow mb-3">
                        <div class="card-header">
                            Ventas de cada producto
                        </div>
                        <div class="card-body">
                            <canvas id="chart1" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="card text-center shadow mb-3">
                        <div class="card-header">
                            Entretenimiento
                        </div>
                        <div class="card-body">
                            <img src="<?php echo base_url();?>/ent/perritos.gif" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>-->

    <script>
        <?php
            foreach ($productosnombre as $producto) {
                $nombre_producto[]   = $producto['nombre'];
                $venta_producto[]  = $producto['ventas'];
                $cantidad_producto[]  = $producto['existencias'];
            }
        ?>

        const char_producto = document.getElementById('chart1').getContext('2d');
        const Productos = new Chart(char_producto, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($nombre_producto); ?>,
                datasets: [{
                    label: 'ventas',
                    data: <?php echo json_encode($venta_producto); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 20,
                    }
                }
            }
        });
        
        const char_cliente  = document.getElementById('chart2').getContext('2d');
        const Clientes = new Chart(char_cliente, {
            type: 'pie',
            data: {
                labels:  <?php echo json_encode($nombre_producto); ?>,
                datasets: [{
                    label: '# of Votes',
                    data: <?php echo json_encode($cantidad_producto); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
        });
    </script>