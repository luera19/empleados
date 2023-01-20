<?php
if(!isset($_SESSION)){
    session_start();
}

$url_base = "http://localhost/empleados/";

if(!isset($_SESSION['usuario'])){
    header("Location:".$url_base."login.php");
  }

?>

<!doctype html>
<html lang="es">

<head>
    <title>Sistema de Empleados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <!--datatables-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <!--Sweet Alert-->
    <script src="http://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>

    <!--NAVBAR-->
    <!--bs5-navbar-minimal-ul-->
    <nav class="navbar navbar-expand navbar-light bg-light">
        <ul class="nav navbar-nav">

            <li class="nav-item">
                <a class="nav-link active" href="#" aria-current="page">Sistema Web<span class="visually-hidden">(current)</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= $url_base; ?>secciones/empleados/">Empleados</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= $url_base; ?>secciones/puestos/">Puestos</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= $url_base; ?>secciones/usuarios/">Usuarios</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= $url_base;?>cerrar.php">Cerrar Sesión</a>
            </li>

        </ul>
    </nav>

    <!--MAIN-->
    <main class="container">
        <?php if (isset($_GET['mensaje'])) { ?>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "<?php echo $_GET['mensaje']; ?>"
                });
            </script>
        <?php } ?>