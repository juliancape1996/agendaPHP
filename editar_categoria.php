<?php include("includes/header.php") ?>

<?php
    //validar si se recibío el id de la categoría por la url
    if (isset($_GET['id'])) {
        $idCategiria=$_GET['id'];      
    }

    //editamos datos
    if (isset($_POST["editarCategoria"])) {
        $nombre= $_POST["nombre"];

        //validamos si nombre esta vacio
        if (empty($nombre)) {
            $error="ERROR, Algunos campos obligatorios estan vacios";
            header('Location: editar_categoria.php?error='.$error);
        }else {
            //configuramos la fecha para insecion
            $fechaActual = date("Y-m-d");
            
            $query= "UPDATE categorias SET nombre=:nombre WHERE id=:id";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":nombre",$nombre,PDO::PARAM_STR);
            $stmt->bindParam(":id",$idCategiria,PDO::PARAM_INT);

            $resultado = $stmt->execute();

            if ($resultado) {
                $mensaje ="Categoria editada correctamente";
                header('Location: categorias.php?mensaje='.$mensaje );
                exit();
                }else {
                $error="ERROR, No se pudo editar el registro";
                header('Location: categorias.php?error='.$error);
                exit();
            }
        }
        
    }

    //$OBTENER LA CATEGORIA
    $query="SELECT * FROM categorias WHERE id=:id";
    $stmt= $conn->prepare($query);
    $stmt->bindParam(":id",$idCategiria, PDO::PARAM_INT);
    $stmt->execute();

    $categoria = $stmt->fetch(PDO::FETCH_OBJ);
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
            <h3>Editar Categoría</h3>
        </div>            
    </div>
    <div class="row">
        <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre" 
                value="<?php if($categoria)echo $categoria->nombre?>">               
            </div>          

            <button type="submit" name="editarCategoria" class="btn btn-primary w-100">Editar Categoría</button>
            </form>
        </div>
    </div>
<?php include("includes/footer.php") ?>
       