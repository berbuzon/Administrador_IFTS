<?php
$hash_guardado = '$2y$10$hcXIC2Bm.QplR6MUO/NRoen6nYx/RoV40U2/pHuDKeo4Euy12HRx6';
$password_ingresada = '123';

if (password_verify($password_ingresada, $hash_guardado)) {
    echo "✅ Coincide, el hash es correcto";
} else {
    echo "❌ No coincide, algo está mal";
}
?>
