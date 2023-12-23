<?php
//verifica si hay sesiones iniciadas
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}

include "../config/conexionAPI.php";
date_default_timezone_set("America/Tegucigalpa");
// Método para el procesamiento del PDF
 
// cargar autoload.php
require_once '../librerias/vendor/autoload.php'; // solo si no lo han incluido anteriormente
 
use Dompdf\Dompdf;
use Dompdf\Option;
use Dompdf\Exception as DomException;
use Dompdf\Options;

// Consulta a la base de datos
$query = "SELECT u.id_usuario, u.id_persona, u.id_rol, u.usuario, p.nombres, p.apellidos, u.estado,r.rol, 
u.correo_electronico,p.dni, p.telefono,p.sexo,p.direccion from usuarios u
inner join roles r on r.id_rol=u.id_rol
inner join personas p on p.id_persona=u.id_persona
where u.id_rol=3";
$resultado = mysqli_query($conexion,$query);
$fecha_actual=date('Y-m-d H:i:s');

//codigo para obtener la imagen de logo de la empresa
$nombreImagen = "../vistas/assets/img/logo-compania.png";
$imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));
 
    try {
    $download  = false;
      $contenido = '<!DOCTYPE html>
      <html>
        <head>
          <style>
            body{
                font-family:sans-serif;
            }

            h1,h2{
                text-align:center;
            }

            table {
              width: 100%%;
              text-align: center;
              border-collapse: collapse;
            } 
              
              th, td {
                padding: 8px;
              }
              
              th {
                background-color: #4CAF50;
                color: white;
              }
              
              tr:nth-child(even) {
                background-color: #f2f2f2;
              }
              
          </style>
        </head>
        <body>
          <img src='. $imagenBase64 .' width="150" height="100" style="margin-left:25rem;"/>
          <h1>Reporte de Participantes Registrados</h1>';
          $contenido .='<span> Fecha: ' . $fecha_actual;
          $contenido .='<br><br>';
          $contenido .='<span> Generado por: ' . $_SESSION['usuario_login'];
          $contenido .='<table>
            <br>
            <thead>
              <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Sexo</th>
                <th>Direccion</th>
                <th>Estado</th>
                <th>Correo Electrónico</th>
              </tr>
            </thead>
            <tbody>';

            while ($fila = mysqli_fetch_array($resultado)) {
                $contenido .='<tr>';
                $contenido .='<td>' . $fila['usuario'] . '</td>';
                $contenido .= '<td>' . $fila["nombres"] . ' ' .$fila["apellidos"].'</td>';
                $contenido .= '<td>' . $fila["dni"] . '</td>';
                $contenido .= '<td>' . $fila["telefono"] . '</td>';
                $contenido .= '<td>' . $fila["sexo"] . '</td>';
                $contenido .= '<td>' . $fila["direccion"] . '</td>';
                $contenido .= '<td>' . $fila["estado"] . '</td>';
                $contenido .= '<td>' . $fila["correo_electronico"] . '</td>';
                $contenido .='</tr>';
            }
            $contenido .='</tbody>
          </table>
        </body>
      </html>';
      $contenido = sprintf($contenido);
 
      // Nombre del pdf
      $filename = 'Reporte de Participantes '. $fecha_actual. '.pdf';
   
      // Opciones para prevenir errores con carga de imágenes
      $options = new Options();
      $options->set('isRemoteEnabled', true);
 
      // Instancia de la clase
      $dompdf = new Dompdf($options);
 
      // Cargar el contenido HTML
      $dompdf->loadHtml($contenido);
 
      // Formato y tamaño del PDF
      $dompdf->setPaper('letter', 'landscape');
 
      // Renderizar HTML como PDF
      $dompdf->render();

      $footer ='Página: {PAGE_NUM}/{PAGE_COUNT}';
      $dompdf->get_canvas()->page_text(380, 550, $footer, null, 10, array(0, 0, 0));
 
      // Salida para descargar
      $dompdf->stream($filename,['Attachment' => $download]);
 
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::to('home');
    } catch (DomException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::to('home');
    }
 
