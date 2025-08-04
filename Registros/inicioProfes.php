<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inicion.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>EduSoft</title>
</head>
<body>
<div class="container-form register">
        <div class="information">
            <div class="info-childs">
                <h2 data-i18n="denuevoD">Bienvenido denuevo Profesor</h2>
                <br>
                <img src="../img/3.png" alt="" height="200px" weight="220px">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2 data-i18n="inicioS">Inicio de Sesion</h2>
                <form action="../conexiones/loginProfes.php" method="post" class="form form-register">
                    <div>
                        <label>
                            <i class='bx bxs-user'></i>
                            <input data-i18n="nombre_usuario" type="text" Name="Nombre" placeholder="Nombre Usuario"  >
                        </label>
                    </div>
                    <div>
                        <label >
                            <i class='bx bxs-lock-alt' ></i>
                            <input data-i18n="contraseña" type="password" name="Pass" placeholder="Contraseña"  >
                        </label>
                    </div>
                   <div>
                        <label>
                             <i class='bx bxs-lock-open-alt'></i>
                            <input data-i18n="confirmar" type="password" name="Pass_Confi" placeholder="Confirmar Contraseña" >
                        </label>
                   </div>
                   
                    <input data-i18n="iniciar" type="submit" value="Iniciar">
                    <div class="alerta-error" data-i18n="campos" >Todos los campos son obligatorios</div>
                    <div class="alerta-exito" data-i18n="correcto">Te registraste correctamente</div>
                </form>
            </div>
        </div>
    </div>
     <script src="../principal/lang.js"></script>
      <script src="../principal/idioma.js"></script>
</body>
</html>