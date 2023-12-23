//Visualizar los boletos comprados de un usuario especifico 
$(".datos-docente").load("demo.txt", function (responseTxt, statusTxt, xhr)  {
  const tbl = document.querySelector(".datos-docente");
  const tblBody = document.createElement("tbody");
  tblBody.classList.add('body');

  let datos = {
    query:1
  }

  let jsonData = JSON.stringify(datos);
  let formData = new FormData();

// Agregar la cadena JSON como un valor en FormData
  formData.append('query', jsonData);

  $.ajax({
    url: "../controllers/docentesControlador.php",
    type: "POST",
    data: formData,
    processData: false,  // No procesar los datos (FormData se encargará de eso)
    contentType: false,
      success: function(data) {
        if(Object.entries(data).length === 0){
          const row = document.createElement("tr");
          const cellTexto = document.createTextNode(`No hay docentes`);
          row.appendChild(cellTexto);

          tblBody.appendChild(row);
          tbl.appendChild(tblBody);
        }

        const bitacora=JSON.parse(data)
        bitacora.forEach(registro => {
          //Creación de la fila
          const row = document.createElement("tr");
          row.dataset.id=registro.id_oficial
          //Creacion de las columnas
          const cell = document.createElement("td");
          const cell2 = document.createElement("td");
          const cell3 = document.createElement("td");
          const cell4 = document.createElement("td");
          const cell5 = document.createElement("td");

          //Datos recibidos y asignados a una variable
          const cellID = document.createTextNode(`${registro.id_docente}`);
          const cellNombre = document.createTextNode(`${registro.nombre_completo}`);
          const cellGrado = document.createTextNode(`${registro.dni}`);
          const cellFecha = document.createTextNode(`${registro.fecha_nacimiento}`);
          const BotonVerMas = document.createElement('button');
          const enlaceArchivos = document.createElement('a');

          enlaceArchivos.href = `../tinyfilemanager/tinyfilemanager.php${registro.ruta_carpeta}`;
          //Creación de botones
          BotonVerMas.classList.add('btn', 'btn-danger');
          const iconoEditar = document.createElement("i");
          iconoEditar.classList.add('fas', 'fa-arrow-circle-down');
          BotonVerMas.appendChild(iconoEditar); 
          const cellVer = BotonVerMas;
          
          //const BotonVerMas = document.createElement('button');

          //Creación de botones
          cell.appendChild(cellID);
          cell2.appendChild(cellNombre);
          cell3.appendChild(cellGrado);
          cell4.appendChild(cellFecha);
          cell5.appendChild(cellVer);

          enlaceArchivos.appendChild(cell5);

          row.appendChild(cell);
          row.appendChild(cell2);
          row.appendChild(cell3);
          row.appendChild(cell4);
          row.appendChild(enlaceArchivos);

          tblBody.appendChild(row);
          tbl.appendChild(tblBody);
         })
      },

    });

});