<html>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">
    <body>
        <?php
            session_start();
            $token = uniqid();
            $_SESSION['token'] = $token;
            if(isset($_POST["datos"])){
                $dni=$_POST["dni"];
                $apellidos=$_POST["apellidos"];
                $nombre=$_POST["nombre"];
                $telefono=$_POST["telefono"];
                $email=$_POST["email"];
                $codigocentro=$_POST["codigocentro"];
                $coordeinadortic = isset($_POST['coordeinadortic']) ? 1 : 0;
                $grupotic = isset($_POST['grupotic']) ? 1 : 0;
                $nombregru=$_POST["nombregru"];
                $pbilin = isset($_POST['pbilin']) ? 1 : 0;
                $cargo = isset($_POST['cargo']) ? 1 : 0;
                $nombrecargo=$_POST["nombrecargo"];
                $situacion=$_POST["situacion"];
                $fechanacimiento=$_POST["fechaalta"];
                $especialidad=$_POST["especialidad"];
                $puntos=$_POST["puntos"];
                $contrasena=$_POST["contrasena"];
                try{
                    $con = new PDO('mysql:host=localhost;dbname=cursoscp;charset=utf8', 'admin', '1234');
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $query=$con->prepare("INSERT into solicitantes values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $query->execute([$dni,$apellidos,$nombre,$telefono,$email,$codigocentro,$coordeinadortic,$grupotic,$nombregru,$pbilin,$cargo,$nombrecargo,$situacion,$fechanacimiento,$especialidad,$puntos,$contrasena]);
                    header("Location: login.php?token=$token");
                    exit();
                    $query->close();
                    $con->close();
                }catch(PDOException $e){
                    die("Error de conexión: " . $e->getMessage());
                }
            }
        ?>
        <div id="formulario">
            <h1 class='text-center'>REGISTRO</h1>
            <form class="form-grid" action="registro.php" method="post">
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" id="dni" name="dni" value="<?php echo $dni ?? '' ?>" required>
                    <span><?php echo $errorDni ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo $apellidos ?? '' ?>" required>
                    <span><?php echo $errorApellidos ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $nombre ?? '' ?>" required>
                    <span><?php echo $errorNombre ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono:</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo $telefono ?? '' ?>" required>
                    <span><?php echo $errorTelefono ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email ?? '' ?>" required>
                    <span><?php echo $errorEmail ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" value="<?php echo $contrasena ?? '' ?>" required>
                    <span><?php echo $errorContrasena ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="codigocentro">Codigo Centro:</label>
                    <input type="text" id="codigocentro" name="codigocentro" value="<?php echo $codigocentro ?? '' ?>" required>
                    <span><?php echo $errorCodigocentro ?? '' ?></span>
                </div>
                
                <div class="form-group">
                    <label for="nombregru">Nombre Grupo:</label>
                    <input type="text" id="nombregru" name="nombregru" value="<?php echo $nombregru ?? '' ?>" required>
                    <span><?php echo $errorNombregru ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="nombrecargo">Nombre Cargo:</label>
                    <select id="nombrecargo" name="nombrecargo" required>
                        <option value="" disabled <?php echo (!isset($nombrecargo)) ? 'selected' : ''; ?>>Seleccione...</option>
                        <option value="Director" <?php echo ($nombrecargo ?? '') == 'Director' ? 'selected' : ''; ?>>Director</option>
                        <option value="Subdirector" <?php echo ($nombrecargo ?? '') == 'Subdirector' ? 'selected' : ''; ?>>Subdirector</option>
                        <option value="Jefe de Estudios" <?php echo ($nombrecargo ?? '') == 'Jefe de Estudios' ? 'selected' : ''; ?>>Jefe de Estudios</option>

                    </select>
                     <span><?php echo $errorNombrecargo ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="situacion">Situacion:</label>
                    <select id="situacion" name="situacion" required>
                        <option value="" disabled <?php echo (!isset($situacion)) ? 'selected' : ''; ?>>Seleccione...</option>
                        <option value="activo" <?php echo ($situacion ?? '') == 'activo' ? 'selected' : ''; ?>>Activo</option>
                        <option value="inactivo" <?php echo ($situacion ?? '') == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                     <span><?php echo $errorSituacion ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="fechaalta">Fecha Alta:</label>
                    <input type="date" id="fechaalta" name="fechaalta" value="<?php echo $fechaalta ?? '' ?>" required>
                    <span><?php echo $errorFechaalta ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="especialidad">Especialidad:</label>
                    <input type="text" id="especialidad" name="especialidad" value="<?php echo $especialidad ?? '' ?>" required>
                    <span><?php echo $errorEspecialidad ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="puntos">Puntos:</label>
                    <input type="text" id="puntos" name="puntos" value="<?php echo $puntos ?? '' ?>" required>
                    <span><?php echo $errorPuntos ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="coordeinadortic">Coordenador TIC:</label>
                    <input type="checkbox" id="coordeinadortic" name="coordeinadortic" <?php echo (isset($coordeinadortic) && $coordeinadortic) ? 'checked' : ''; ?> >
                    <span><?php echo $errorCoordeinadortic ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="grupotic">Grupo TIC:</label>
                    <input type="checkbox" id="grupotic" name="grupotic" <?php echo (isset($grupotic) && $grupotic) ? 'checked' : ''; ?>>
                    <span><?php echo $errorGrupotic ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="pbilin">PBilin:</label>
                    <input type="checkbox" id="pbilin" name="pbilin" <?php echo (isset($pbilin) && $pbilin) ? 'checked' : ''; ?>>
                    <span><?php echo $errorPbilin ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label for="cargo">Cargo:</label>
                    <input type="checkbox" id="cargo" name="cargo" <?php echo (isset($cargo) && $cargo) ? 'checked' : ''; ?>>
                    <span><?php echo $errorCargo ?? '' ?></span>
                </div>
                <input id="boton-registro" type="submit" name="datos" value="Registrarse">
            </form>;
        </div>
    </body>
</html>