import './bootstrap';
// Import the functions you need from the SDKs you need

document.addEventListener('DOMContentLoaded', function () {
    var rows = document.querySelectorAll('.clickable-row');
    var deslizamiento = false; // Variable para evitar que se ejecute el evento click al deslizar
    var isPressed = false; // Nueva variable para detectar si se ha hecho "press"

    rows.forEach(function (row) {
        row.addEventListener('click', function (event) {
            if (!deslizamiento && !isPressed) {
                if(row.dataset.href){
                    document.location.href = row.dataset.href;
                }else{
                    if(row.dataset.hrefsumarcantidad == "self"){
                        var formulario2 = document.getElementById("sumarcantidadform");
                        document.getElementById("sumarcantidadformcantidad").value = 1;
                        formulario2.submit();
                    }
                }
            }
            deslizamiento = false;
            isPressed = false; // Reinicia el estado de isPressed después del click
        });

        var hammertime = new Hammer(row);
        
        hammertime.on('swipeleft', function() {
            deslizamiento = true;
            if(row.dataset.borrable){
                if(row.dataset.hrefborrar != null){
                    if(confirm(row.dataset.textoborrar)){
                        var formulario = document.getElementById("frmBorrar");
                        formulario.action = row.dataset.hrefborrar;
                        formulario.submit();
                    }
                }
            }
        });

        hammertime.on('swiperight', function() {
            deslizamiento = true;
            if(row.dataset.hrefrestarcantidad != null){
                var formulario = document.getElementById("frmEditar");
                formulario.action = row.dataset.hrefrestarcantidad;
                if(row.dataset.hrefrestarcantidadmethod != null){
                    formulario.method = row.dataset.hrefrestarcantidadmethod;
                }
                formulario.submit();
            }
        });

        hammertime.on('press', function() {
            deslizamiento = true;
            isPressed = true; // Marca que se ha hecho "press"
            if(row.dataset.hrefsumarcantidad != null){
                var formulario = document.getElementById("frmEditar");
                if(row.dataset.hrefsumarcantidadpreguntar != null){
                    var unidades = prompt('Introduce la cantidad a sumar:');
                    if(unidades != null && unidades != "" && !isNaN(unidades) && parseInt(unidades) > 0){
                        var unidades = parseInt(unidades);
                        if(unidades > 0){
                            if(row.dataset.hrefsumarcantidad != "self"){
                                var partes = row.dataset.hrefsumarcantidad.split('/');
                                var ultimaParte = partes.pop() || partes.pop(); 
                                partes.push(unidades);
                                var nuevaUrl = partes.join('/');  
                                formulario.action = nuevaUrl;      
                                formulario.submit();
                            }else{ 
                                var formulario2 = document.getElementById("sumarcantidadform");
                                document.getElementById("sumarcantidadformcantidad").value = unidades;
                                formulario2.submit();
                            }
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    formulario.action = row.dataset.hrefsumarcantidad;
                    formulario.submit();
                }
            }
        });
    });

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    if(togglePassword && password){
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye-slash');
        });
    }
   
    function getElementByIds(ids) {
        for (let id of ids) {
            let element = document.getElementById(id);
            if (element) {
                return element;
            }
        }
        return null; // Si ninguno de los IDs existe, devuelve null
    }

    // Ocultar el mensaje después de 2 segundos
    setTimeout(function() {
        let flashMessage = getElementByIds(['custom-success-container', 'custom-error-container']);
        if (flashMessage) {
            flashMessage.style.transition = 'opacity 0.5s ease';
            flashMessage.style.opacity = '0';
            setTimeout(function() {
                flashMessage.remove();
            }, 500);
        }
    }, 2000);
    var rows2 = document.querySelectorAll('.readonly');
    rows2.forEach(function (row) {
        row.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
        });
    });

    
});
  