<?php
if(isset($token))
    $con = new mysqli("localhost","root","","milkprichitos_base");
else 
    header("Location: ../404");