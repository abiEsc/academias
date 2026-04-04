<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-content">

        <section class="row justify-content-center align-items-center">
            <h4>Paquetes promocionales</h4>
            <?php if (isset($promociones) && !empty($promociones)) : ?>
                <?php foreach ($promociones as $value) : ?>
                    <div class="col-lg-4 col-6">
                        <div class="box card border" style="box-shadow: 0 0.5rem 1rem <?php echo $value["color"] ?> !important; background-color: <?php echo $value["color"] ?>;">
                            <div class="ribbon"><span>Promoción</span></div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $value["promocion_nombre"] ?></h4>
                                <hr>
                                <p class="card-text"><strong> Cantidad de Clases: </strong><?php echo $value["promocion_clases"] ?></p>
                                <p class="card-text"><strong> Precio: </strong><?php echo $value["promocion_precio"] ?> Bs.</p>
                                <p class="card-text"><strong> Disponible del: </strong><?php echo $value["promocion_inicio"] ?> al <?php echo $value["promocion_fin"] ?></p>
                            </div>
                        </div>
                        <div class="card shadow">


                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                            <p>
                                <i class="bi bi-info-circle-fill"></i>
                                Aún no contamos con promociones vigentes.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </section>

        <section class="row justify-content-center align-items-center">
            <h4>Paquetes Regulares</h4>
            <?php if (isset($paquetes) && !empty($paquetes)) : ?>
                <?php foreach ($paquetes as $key => $value) : ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card border" style="box-shadow: 0 0.5rem 1rem <?php echo $value["color"] ?> !important; background-color: <?php echo $value["color"] ?>;">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $value["paquete_nombre"] ?></h4>
                                <hr>
                                <p class="card-text"><strong> Cantidad de Clases: </strong><?php echo $value["paquete_clases"] ?></p>
                                <p class="card-text"><strong> Precio: </strong><?php echo $value["paquete_precio"] ?> Bs.</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                            <p>
                                <i class="bi bi-info-circle-fill"></i>
                                Aún no contamos con paquetes disponibles
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </section>

        <section class="row justify-content-center align-items-center">
            <h4>Ritmos Disponibles</h4>
            <?php if (isset($cursos) && !empty($cursos)) : ?>
                <?php foreach ($cursos as $value) : ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card border" style="box-shadow: 0 0.5rem 1rem <?php echo $value["color"] ?> !important; background-color: <?php echo $value["color"] ?>;">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $value["curso_nombre"] ?></h4>
                                <hr>
                                <p class="card-text"><strong> Instructor: </strong><?php echo $value["nombre_instructor"] ?></p>
                                <p class="card-text"><strong> Horarios: </strong><?php echo $value["horario_ini"] ?> - <?php echo $value["horario_fin"] ?></p>
                                <p class="card-text"><strong> Días: </strong><?php echo $value["dias"] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="alert alert-primary" role="alert">
                            <p>
                                <i class="bi bi-info-circle-fill"></i>
                                Aún no contamos con promociones vigentes.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </section>
    </div>
</div>