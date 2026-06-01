<?php
echo "Хэш для admin123: " . password_hash('admin123', PASSWORD_DEFAULT) . "<br>";
echo "Хэш для force123: " . password_hash('force123', PASSWORD_DEFAULT) . "<br>";
echo "Хэш для password: " . password_hash('password', PASSWORD_DEFAULT) . "<br>";
?>