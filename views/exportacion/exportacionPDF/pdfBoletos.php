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

// Opciones para prevenir errores con carga de imágenes
$options = new Options();
$options->set('isRemoteEnabled', true);

// Consulta a la base de datos
$query = "SELECT b.id_boleto, b.id_usuario, b.id_sorteo, p.nombres,p.apellidos, p.dni, s.nombre_sorteo,
b.numero_boleto,b.fecha_compra, u.id_persona from boletos b
inner join usuarios u on u.id_usuario=b.id_usuario
inner join sorteos s on s.id_sorteo=b.id_sorteo
inner join personas p on p.id_persona=u.id_persona
order by b.numero_boleto desc";
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
        <img src='. $imagenBase64 .' width="150" height="100" style="margin-left:17rem;"/>
          <h1>Reporte de Boletos Vendidos</h1>
          <h2>Sorteos Reales</h2>';
          $contenido .='<span> Fecha: ' . $fecha_actual;
          $contenido .='<br><br>';
          $contenido .='<span> Generado por: ' . $_SESSION['usuario_login'];
          $contenido .='<table>
            <br>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th># Boleto</th>
                <th>Fecha de compra</th>
              </tr>
            </thead>
            <tbody>';

            while ($fila = mysqli_fetch_array($resultado)) {
                $contenido .='<tr>';
                $contenido .='<td>' . $fila['nombres'] . ' ' . $fila['apellidos'] . '</td>';
                $contenido .= '<td>' . $fila["dni"] . '</td>';
                $contenido .= '<td>' . $fila["numero_boleto"] . '</td>';
                $contenido .= '<td>' . $fila["fecha_compra"] . '</td>';
                $contenido .='</tr>';
            }
            $contenido .='</tbody>
          </table>
        </body>
      </html>';
      $contenido=sprintf($contenido);
 
      // Nombre del pdf
      $filename = 'Reporte de Boletos ' . date('Y-m-d H:i:s') .'.pdf';
 
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
 
