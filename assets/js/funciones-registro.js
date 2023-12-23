//constante que obtiene el boton Enviar del formulario de registro
//en caso de que alguna de las validaciones detecte que no se estan ingresando los datos que se debe
//el boton Enviar queda deshabilitado
const boton = document.getElementById("btn-enviar");


  function validarContrasena() {
    // Obtener el valor del input
    const valor = document.getElementById("password").value;
  
    // Definir una expresión regular que solo permita letras
    const caracteresRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
  
    // Validar el valor utilizando la expresión regular
    if (!valor.match(caracteresRegex)) {
      // Mostrar el mensaje de error en el span correspondiente
      document.getElementById("spanClave").textContent = "Ingrese al menos una letra, un número y un carácter especial";
      boton.disabled = true;
    } else {
      // Borrar el mensaje de error si el valor es válido
      document.getElementById("spanClave").textContent = "";
      boton.disabled = false;
    }
  

  }

  // Llamar a la función validarInput() cada vez que se active el evento 'input' en el input correspondiente
  document.getElementById("password").addEventListener("input", validarContrasena);



  function verificarPasswords() {
 
    // Ontenemos los valores de los campos de contraseñas 
    pass1 = document.getElementById('password');
    pass2 = document.getElementById('conf-password');
 
    if (pass1.value!=pass2.value) {
      // Mostrar el mensaje de error en el span correspondiente
      document.getElementById("spanConfClave").textContent = "Las contraseñas no coinciden";
      boton.disabled = true;
    } else {
      // Borrar el mensaje de error si el valor es válido
      document.getElementById("spanConfClave").textContent = "Las contraseñas si coinciden";
      boton.disabled = false;
    }
 
}

  // Llamar a la función validarInput() cada vez que se active el evento 'input' en el input correspondiente
  document.getElementById("conf-password").addEventListener("input", verificarPasswords);
