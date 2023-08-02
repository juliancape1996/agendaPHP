

<?php include("includes/header.php") ?>
<?php
    // Insertar los datos

    if (isset($_POST["crearCategoria"])) {
        $nombre= $_POST["nombre"];

        //validamos si nombre esta vacio
        if (empty($nombre)) {
            $error="ERROR, Algunos campos obligatorios estan vacios";
            header('Location: crear_categoria.php?error='.$error);
        }else {
            //configuramos la fecha para insecion
            $fechaActual = date("Y-m-d");
            
            $query= "INSERT INTO categorias (nombre,fecha_creacion) VALUES(:nombre,:fecha_creacion)";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":nombre",$nombre,PDO::PARAM_STR);
            $stmt->bindParam(":fecha_creacion",$fechaActual,PDO::PARAM_STR);

            $resultado = $stmt->execute();

            if ($resultado) {
                $mensaje ="Categoria Creada correctamente";
                header('Location: categorias.php?mensaje='.$mensaje );
                exit();
                }else {
                $error="ERROR, No se pudo crear el registro";
                header('Location: crear_categoria.php?error='.$error);
                exit();
            }
        }
        
    }
?>
<div class="row">
    <div class="col-sm-12">
        <?php if (isset($_GET['error'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo $_GET['error'] ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
</div>


<div class="row">
        <div class="col-sm-6">
            <h3>Crear una Nueva Categoría</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre">               
            </div>          

            <button type="submit" name="crearCategoria" class="btn btn-primary w-100">Crear Nueva Categoría</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       