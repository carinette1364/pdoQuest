<?php
    function cleanPost($datapost) {
        $datapost = trim($datapost);
        $datapost = stripslashes($datapost);
        return htmlspecialchars($datapost);
    }

?>