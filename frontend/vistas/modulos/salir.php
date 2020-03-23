<?php

session_destroy();

$url = Ruta::ctrRuta();

echo '

<script>
    localStorage.removeItem("usuario");
    localStorage.removeItem("direccionEnvio");
    localStorage.removeItem("paginaEnvio");
    /*window.location.href = "https://www.refaccionariazapata.com/";*/
    window.location = "'.$url.'";
</script>

';