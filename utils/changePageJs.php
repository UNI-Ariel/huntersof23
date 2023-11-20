<script type="text/javascript">
    // Obtiene la URL de la aplicación desde PHP y la almacena en la variable pageUrl
    let pageUrl = '<?php echo $app_url; ?>';

    // Selecciona todos los elementos con la clase "buttonContainer" (botones de navegación)
    const changePageBtns = document.querySelectorAll(".buttonContainer");

    // Función para mostrar el contenido de la página seleccionada
    function showContent(page) {
        // Muestra o oculta contenedores de búsqueda según la página
        const searchContainers = document.querySelectorAll(".searchContainer");
        searchContainers.forEach(container => {
            if (page === "search") {
                container.classList.remove("hide");
            } else {
                container.classList.add("hide");
            }
        });

        // Oculta el contenido no utilizado y muestra el contenido de la página seleccionada
        document.querySelectorAll(".musicContainer").forEach(ui => {
            if (ui.id !== page) {
                ui.classList.add("hide");
            } else {
                ui.classList.remove("hide");
            }
        });
    }

    // Asigna un evento de clic a los botones de cambio de página
    changePageBtns.forEach(button => {
        button.addEventListener('click', event => {
            const page = button.getAttribute("page-data"); // Obtiene la página asociada al botón

            // Verifica si se requiere autenticación para acceder a la página de favoritos
            if (!authenticated && (page == "favourites" ||  page == "playlists")) {
                loginPopup(); // Muestra un formulario de inicio de sesión
                return; // Detiene el cambio de página si no se ha autenticado
            }

            // Modifica la URL en el historial del navegador para reflejar la página actual
            if (page === "home") {
                window.history.pushState("", "", pageUrl + "/");
            } else {
                window.history.pushState("", "", pageUrl + "/" + page + ".php");
            }

            // Muestra el contenido de la página seleccionada
            showContent(page);
        });
    });
</script>
