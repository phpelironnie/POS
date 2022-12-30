<?php 
    $user_session = session();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Inicio Sesion</title>

        <!--DataTable CSS-->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        
        <!--ESTILOS CSS-->
        <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
        
        <!--FONTAWESOME JS-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        
    </head>

    <body style="background: rgb(128, 186, 219)">

        <?php echo $user_session->nombre; ?>

        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Iniciar Sesion</h3></div>
                                    <div class="card-body">
                                        
                    
                                        <?php if(isset($validation)){?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $validation->listErrors(); ?>
                                            </div>
                                        <?php }?>

                                        <?php if(isset($error)){?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $error; ?>
                                            </div>
                                        <?php }?>

                                        <form method="POST" action="<?php echo base_url(); ?>/usuarios/valida" >

                                            <!--USUARIO-->
                                            <label for="basic-url" class="form-label">USUARIO</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user-astronaut"></i></span>
                                                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Ingresa tu usuario" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>

                                            <!--CONTRASEÑA-->
                                            <label for="basic-url" class="form-label">CONTRASEÑA</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>

                                            <br>

                                            <!--BOTTON INGRESO-->
                                            <div class="d-grid gap-2 col-6 mx-auto">
                                                <button class="btn btn-primary" type="submit" href="index.html">Ingresar</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>/assets/demo/chart-area-demo.js"></script>
        <script src="<?php echo base_url(); ?>/assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="<?php echo base_url(); ?>/js/datatables-simple-demo.js"></script>
        
    </body>
</html>
