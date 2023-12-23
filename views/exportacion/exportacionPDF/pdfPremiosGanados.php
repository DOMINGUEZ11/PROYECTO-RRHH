<?php
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
$query = "SELECT ps.id_premio_sorteo, ps.id_premio, p.nombre_premio, ps.id_usuario,pr.nombres,
pr.apellidos, ps.estado, ps.fecha_asignacion from premios_sorteo ps
inner join usuarios u on u.id_usuario=ps.id_usuario
inner join personas pr on pr.id_persona=u.id_persona
inner join premios p on p.id_premio=ps.id_premio
order by ps.id_premio_sorteo desc";
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

            h1{
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
          <h1>Informe de Premios Ganados</h1>';
          $contenido .='<span> Fecha: ' . $fecha_actual;
          $contenido .='<table>
            <br>
            <thead>
              <tr>
                <th># Boleto</th>
                <th>Premio</th>
                <th>Comprador</th>
                <th>Fecha</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>';

            while ($fila = mysqli_fetch_array($resultado)) {
                $contenido .='<tr>';
                $contenido .= '<td>' . $fila["id_premio_sorteo"] . '</td>';
                $contenido .= '<td>' . $fila["nombre_premio"] . '</td>';
                $contenido .='<td>' . $fila['nombres'] . ' ' . $fila['apellidos'] . '</td>';
                $contenido .= '<td>' . $fila["fecha_asignacion"] . '</td>';
                $contenido .= '<td>' . $fila["estado"] . '</td>';
                $contenido .='</tr>';
            }
            $contenido .='</tbody>
          </table>
        </body>
      </html>';
      $contenido = sprintf($contenido);
 
      // Nombre del pdf
      $filename = 'a.pdf';
   
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
 
