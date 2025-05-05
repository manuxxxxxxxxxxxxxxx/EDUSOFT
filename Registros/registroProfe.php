<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registro.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>EduSoft</title>
</head>
<body>
<div class="container-form register">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido Docente</h2>
                <br>
                <img src="../img/3.png" alt="" height="200px" weight="220px">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear una Cuenta</h2>
                <form class="form form-register" action="../conexiones/registroProfes.php" method="post">
                    <div>
                        <label>
                            <i class='bx bxs-user'></i>
                            <input type="text"  Name="Nombre" placeholder="Nombre Usuario"  >
                        </label>
                    </div>
                    <div>
                        <label >
                            <i class='bx bxs-envelope' ></i>
                            <input type="email" Name="Email" placeholder="Correo Electronico"  >
                        </label>
                    </div>
                   <div>
                        <label>
                            <i class='bx bxs-lock-alt' ></i>
                            <input type="password" Name="Pass" placeholder="Contraseña" >
                        </label>
                   </div>
                   <div>
                        <label>
                            <i class='bx bxs-lock-alt' ></i>
                            <input type="text" Name="Tel" placeholder="Telefono" >
                        </label>
                   </div>
                   <div>
                        <label>
                            <i class='bx bxs-lock-alt' ></i>
                            <input type="text" Name="DUI" placeholder="DUI" >
                        </label>
                   </div>
                   
                    <input type="submit" value="Registrarse">
                    <div class="alerta-error">Todos los campos son obligatorios</div>
                    <div class="alerta-exito">Te registraste correctamente</div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>