<?php include("includes/header.php") ?>

<?php
//validar si se recibío el id de la contacto por la url
if (isset($_GET['id'])) {
    $idContacto = $_GET['id'];
}



//$OBTENER LA CATEGORIA
$query = "SELECT * FROM contactos WHERE id=:id";
$stmt = $conn->prepare($query);
$stmt->bindParam(":id", $idContacto, PDO::PARAM_INT);
$stmt->execute();

$contacto = $stmt->fetch(PDO::FETCH_OBJ);

if (isset($_GET['idCategoria'])) {
    $idCategoria = $_GET['idCategoria'];
}

$query = "SELECT * FROM categorias ";
$stmt = $conn->prepare($query);
$stmt->execute();

$categorias = $stmt->fetchAll(PDO::FETCH_OBJ);



 // editar los datos

 if (isset($_POST["eliminarContacto"])) {

            
    $query= "DELETE FROM contactos WHERE id=:id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id",$idContacto,PDO::PARAM_INT);

    $resultado = $stmt->execute();

    if ($resultado) {
        $mensaje ="Contacto Eliminado correctamente";
        header('Location: contactos.php?mensaje='.$mensaje );
        exit();
        }else {
        $error="ERROR, No se pudo eliminar el registro";
        header('Location: borrar_contacto.php?error='.$error);
        exit();
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
        <h3>Borrar Contacto</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" value="<?php if($contacto)echo $contacto->nombre?>"  readonly class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" value="<?php if($contacto)echo $contacto->apellido?>" readonly class="form-control" name="apellido" id="apellidos" placeholder="Ingresa los apellidos">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number"value="<?php if($contacto)echo $contacto->telefono?>" readonly class="form-control" name="telefono" id="telefono" placeholder="Ingresa el teléfono">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" readonly value="<?php if($contacto)echo $contacto->email?>"  id="email" placeholder="Ingresa el email">
            </div>

            <div class="mb-3">
                <label for="text" class="form-label">Categoría:</label>
                <select class="form-select" aria-label="Default select example" name="categoria">
                    <?php foreach($categorias as $fila):?>
                        <option value="<?php echo $fila->id;?>" <?php if($idCategoria == $fila->id) echo"selected";?>>   
                        <?php echo $fila->nombre;?> </option>
                    <?php endforeach;?>
                </select>

            </div>
            <br />
            <button type="submit" name="eliminarContacto" class="btn btn-danger w-100"><i class="bi bi-person-bounding-box"></i> Borrar Contacto</button>
        </form>
    </div>
</div>
<?php include("includes/footer.php") ?>