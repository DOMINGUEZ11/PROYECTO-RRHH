<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="icon" type="image/x-icon" href="../vistas/assets/img/logo.ico" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Docentes | Sistema X</title>
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>

<style>
    .datos-docente {
        background: white;
        border-radius:3px;
        border-collapse: collapse;
        height: 320px;
        margin: auto;
        width: 800px;
        padding:5px;
        width: 100%;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        animation: float 5s infinite;
        text-align: center;
    }

    .datos-docente th {
    color:#D5DDE5;;
    background:#1b1e24;
    border-bottom:4px solid #9ea7af;
    border-right: 1px solid #343a45;
    font-size:18px;
    font-weight: 100;
    padding:24px;
    text-align:center;
    }

    .datos-docente th:first-child {
    border-top-left-radius:3px;
    }

    .datos-docente th:last-child {
    border-top-right-radius:3px;
    border-right:none;
    }
    
    .datos-docente tr {
    border-top: 1px solid #C1C3D1;
    border-bottom: 1px solid #C1C3D1;
    color:#080808;
    font-size:16px;
    font-weight:normal;
    }

    .datos-docente tr:hover td {
    background:#4E5066;
    color:#FFFFFF;
    border-top: 1px solid #22262e;
    }

    .datos-docente tr:first-child {
    border-top:none;
    }

    .datos-docente tr:last-child {
    border-bottom:none;
    }

    .datos-docente tr:nth-child(odd) td {
    background:#EBEBEB;
    }

    .datos-docente tr:nth-child(odd):hover td {
    background:#4E5066;
    }

    .datos-docente tr:last-child td:first-child {
    border-bottom-left-radius:3px;
    }

    .datos-docente tr:last-child td:last-child {
    border-bottom-right-radius:3px;
    }

    .datos-docente td {
    background:#FFFFFF;
    padding:20px;
    text-align:center;
    vertical-align:middle;
    font-weight:300;
    font-size:18px;
    border-right: 1px solid #C1C3D1;
    }

    .datos-docente td:last-child {
    border-right: 0px;
    }
</style>
<body id="body">
    <?php include './assets/inc/menuLateral.php' ?>

    <main>
        <h1>LISTADO DE DOCENTES</h1>
        <br>
        <table class="datos-docente">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Grado</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Ver Archivos</th>
                </tr>
            </thead>
            
        </table>
    </main>
</body>
</html>
