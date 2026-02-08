<html>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">
    <body>
        <?php
        require_once "funciones/verificaEmail.php";
        require_once "funciones/verificaTel.php";
        require_once "funciones/enviarMail.php";
        require_once "funciones/calcularPuntos.php";
            session_start();
            $token = uniqid();
            $_SESSION['token'] = $token;
            if(isset($_POST["datos"])){
                $errores = [];
                $dni=$_POST["dni"];
                if (!preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
                    $errores['dni'] = "Introduce un DNI con formato válido";
                }
                $apellidos=$_POST["apellidos"];
                if(empty($apellidos)){
                    $errores['apellidos'] = "Introduce unos apellidos";
                }
                $nombre=$_POST["nombre"];
                if(empty($nombre)){
                    $errores['nombre'] = "Introduce un nombre";
                }
                $telefono=$_POST["telefono"];
                if (!verificaTel($telefono)) {  
                    $errores['telefono'] = "Introduce un teléfono con formato válido";
                }
                $email=$_POST["email"];
                if (!verificaEmail($email)) {
                    $errores['email'] = "Introduce un email con formato válido";
                }
                $codigocentro=$_POST["codigocentro"];
                if (!is_numeric($codigocentro) || $codigocentro < 4 || $codigocentro > 9999) {
                    $errores['codigocentro'] = "Introduce un código de centro con formato válido";
                }
                $coordeinadortic = isset($_POST['coordeinadortic']) ? 1 : 0;
                $grupotic = isset($_POST['grupotic']) ? 1 : 0;
                $nombregru=$_POST["nombregru"];
                if(empty($nombregru)){
                    $errores['nombregru'] = "Introduce un nombre de grupo";
                }
                $pbilin = isset($_POST['pbilin']) ? 1 : 0;
                $cargo = isset($_POST['cargo']) ? 1 : 0;
                $nombrecargo=$_POST["nombrecargo"];
                $situacion=$_POST["situacion"];
                $fechanacimiento=$_POST["fechaalta"];
                if(empty($fechanacimiento)){
                    $errores['fechaalta'] = "Introduce una fecha de alta";
                }
                $especialidad=$_POST["especialidad"];
                if(empty($especialidad)){
                    $errores['especialidad'] = "Introduce una especialidad";
                }
                $puntos=calcularPuntos($_POST);
                $contrasena=$_POST["contrasena"];
                if(empty($contrasena)){
                    $errores['contrasena'] = "Introduce una contraseña";
                }
                if(empty($errores)){
                    try{
                        $con = new PDO('mysql:host=localhost;dbname=cursoscp;charset=utf8', 'admin', '1234');
                        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $query=$con->prepare("INSERT into solicitantes values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        $query->execute([$dni,$apellidos,$nombre,$telefono,$email,$codigocentro,$coordeinadortic,$grupotic,$nombregru,$pbilin,$cargo,$nombrecargo,$situacion,$fechanacimiento,$especialidad,$puntos,$contrasena]);
                        enviarEmail($email, "Registro en CursosCP", "¡Bienvenido a CursosCP! Tu registro ha sido exitoso.", null);
                        header("Location: login.php?token=$token");
                        exit();
                        $query->closeCursor();
                        $con=null;
                    }catch(PDOException $e){
                        die("Error de conexión: " . $e->getMessage());
                    }
                }
            }
        ?>
        <div id="formulario">
            <h1 class='text-center'>REGISTRO</h1>
            <form class="form-grid" action="registro.php" method="post">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" value="<?php echo $dni ?? '' ?>">
                    <span  class="errores"><?php echo $errores['dni'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos ?? '' ?>">
                    <span  class="errores"><?php echo $errores['apellidos'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre ?? '' ?>">
                    <span  class="errores"><?php echo $errores['nombre'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono:</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo $telefono ?? '' ?>">
                    <span  class="errores"><?php echo $errores['telefono'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email ?? '' ?>">
                    <span  class="errores"><?php echo $errores['email'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" value="<?php echo $contrasena ?? '' ?>">
                    <span  class="errores"><?php echo $errores['contrasena'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="codigocentro">Codigo Centro:</label>
                    <input type="text" id="codigocentro" name="codigocentro" value="<?php echo $codigocentro ?? '' ?>">
                    <span class="errores"><?php echo $errores['codigocentro'] ?? '' ?></span>
                </div>
                
                <div class="form-group">
                    <label for="nombregru">Nombre Grupo:</label>
                    <input type="text" id="nombregru" name="nombregru" value="<?php echo $nombregru ?? '' ?>">
                    <span  class="errores"><?php echo $errores['nombregru'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="nombrecargo">Nombre Cargo:</label>
                    <select id="nombrecargo" name="nombrecargo">
                        <option value="Sin Cargo" <?php echo (!isset($nombrecargo)) ? 'selected' : ''; ?>>Sin Cargo</option>
                        <option value="Director" <?php echo ($nombrecargo ?? '') == 'Director' ? 'selected' : ''; ?>>Director</option>
                        <option value="Subdirector" <?php echo ($nombrecargo ?? '') == 'Subdirector' ? 'selected' : ''; ?>>Subdirector</option>
                        <option value="Jefe de Estudios" <?php echo ($nombrecargo ?? '') == 'Jefe de Estudios' ? 'selected' : ''; ?>>Jefe de Estudios</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="situacion">Situacion:</label>
                    <select id="situacion" name="situacion">
                        <option value="activo" <?php echo ($situacion ?? '') == 'activo' ? 'selected' : ''; ?>>Activo</option>
                        <option value="inactivo" <?php echo ($situacion ?? '') == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fechaalta">Fecha Alta:</label>
                    <input type="date" id="fechaalta" name="fechaalta" value="<?php echo $fechaalta ?? '' ?>">
                    <span  class="errores"><?php echo $errores['fechaalta'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="especialidad">Especialidad:</label>
                    <input type="text" id="especialidad" name="especialidad" value="<?php echo $especialidad ?? '' ?>">
                    <span  class="errores"><?php echo $errores['especialidad'] ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="coordeinadortic">Coordenador TIC:</label>
                    <input type="checkbox" id="coordeinadortic" name="coordeinadortic" <?php echo (isset($coordeinadortic) && $coordeinadortic) ? 'checked' : ''; ?> >
                </div>
                <div class="form-group">
                    <label for="grupotic">Grupo TIC:</label>
                    <input type="checkbox" id="grupotic" name="grupotic" <?php echo (isset($grupotic) && $grupotic) ? 'checked' : ''; ?>>
                </div>
                <div class="form-group">
                    <label for="pbilin">PBilin:</label>
                    <input type="checkbox" id="pbilin" name="pbilin" <?php echo (isset($pbilin) && $pbilin) ? 'checked' : ''; ?>>
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo:</label>
                    <input type="checkbox" id="cargo" name="cargo" <?php echo (isset($cargo) && $cargo) ? 'checked' : ''; ?>>
                </div>
                <input id="boton-registro" type="submit" name="datos" value="Registrarse">
            </form>;
        </div>
        <div class="text-center"><br>
            <a href="login.php">¿Ya tienes una cuenta? Inicia sesión aquí</a><br><br>
            <a href="listaCursos.php">Volver al Menu Principal</a>
        </div>
    </body>
</html>