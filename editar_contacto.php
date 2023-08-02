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

 if (isset($_POST["editarContacto"])) {
    $nombre= $_POST["nombre"];
    $apellido= $_POST["apellido"];
    $telefono= $_POST["telefono"];
    $email= $_POST["email"];
    $categoria= $_POST["categoria"];

   

    //validamos si nombre esta vacio
    if (empty($nombre)||empty($apellido)||empty($telefono)||empty($email)
    ||empty($categoria)) {
        $error="ERROR, Algunos campos obligatorios estan vacios";
        header('Location: editar_contacto.php?error='.$error);
    }else {
        
        $query= "UPDATE contactos SET nombre=:nombre, apellido=:apellido, telefono=:telefono,email=:email,id_categoria=:idCategoria 
        WHERE id=:id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":nombre",$nombre,PDO::PARAM_STR);
        $stmt->bindParam(":apellido",$apellido,PDO::PARAM_STR);
        $stmt->bindParam(":telefono",$telefono,PDO::PARAM_STR);
        $stmt->bindParam(":email",$email,PDO::PARAM_STR);
        $stmt->bindParam(":idCategoria",$categoria,PDO::PARAM_INT);
        $stmt->bindParam(":id",$idContacto,PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if ($resultado) {
            $mensaje ="Contacto Editado correctamente";
            header('Location: contactos.php?mensaje='.$mensaje );
            exit();
            }else {
            $error="ERROR, No se pudo editar el registro";
            header('Location: contactos.php?error='.$error);
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
        <h3>Editar Contacto</h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 offset-3">
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" value="<?php if($contacto)echo $contacto->nombre?>" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" value="<?php if($contacto)echo $contacto->apellido?>"  class="form-control" name="apellido" id="apellidos" placeholder="Ingresa los apellidos">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="number"value="<?php if($contacto)echo $contacto->telefono?>"  class="form-control" name="telefono" id="telefono" placeholder="Ingresa el teléfono">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php if($contacto)echo $contacto->email?>"  id="email" placeholder="Ingresa el email">
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
            <button type="submit" name="editarContacto" class="btn btn-primary w-100"><i class="bi bi-person-bounding-box"></i> Editar Contacto</button>
        </form>
    </div>
</div>
<?php include("includes/footer.php") ?>