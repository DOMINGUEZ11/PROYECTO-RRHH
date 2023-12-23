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
$query = "SELECT *from modulos";
$resultado = mysqli_query($conexion,$query);
$fecha_actual=date('Y-m-d H:i:s');
 
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
          <img src=".../vistas/assets/img/gallo.jpg" alt="">
          <h1>Reporte de Modulos Registrados</h1>
          <h2>Sorteos Reales</h2>';
          $contenido .='<span> Fecha: ' . $fecha_actual;
          $contenido .='<br><br>';
          $contenido .='<span> Generado por: ' . $_SESSION['usuario_login'];
          $contenido .='<table>
            <br>
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Tipo</th>
              </tr>
            </thead>
            <tbody>';

            while ($fila = mysqli_fetch_array($resultado)) {
                $contenido .='<tr>';
                $contenido .='<td>' . $fila['id_modulo'] . '</td>';
                $contenido .= '<td>' . $fila["modulo"] . '</td>';
                $contenido .= '<td>' . $fila["descripcion"] . '</td>';
                $contenido .= '<td>' . $fila["tipo_modulo"] . '</td>';
                $contenido .='</tr>';
            }
            $contenido .='</tbody>
          </table>
        </body>
      </html>';
      $contenido = sprintf($contenido);
 
      // Nombre del pdf
      $filename = 'Reporte de Módulos '. $fecha_actual. '.pdf';
   
      // Opciones para prevenir errores con carga de imágenes
      $options = new Options();
      $options->set('isRemoteEnabled', true);
 
      // Instancia de la clase
      $dompdf = new Dompdf($options);
 
      // Cargar el contenido HTML
      $dompdf->loadHtml($contenido);
 
      // Formato y tamaño del PDF
      $dompdf->setPaper('A4', 'portrait');
 
      // Renderizar HTML como PDF
      $dompdf->render();

      $footer ='Página: {PAGE_NUM}/{PAGE_COUNT}';
      $dompdf->get_canvas()->page_text(270, 800, $footer, null, 10, array(0, 0, 0));
 
      // Salida para descargar
      $dompdf->stream($filename,['Attachment' => $download]);
 
    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::to('home');
    } catch (DomException $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::to('home');
    }
 
