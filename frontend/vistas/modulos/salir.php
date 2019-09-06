<?php

session_destroy();

$url = Ruta::ctrRuta();

echo '

<script>
    localStorage.removeItem("usuario");
    localStorage.clear();
    window.location = "'.$url.'";
</script>

';