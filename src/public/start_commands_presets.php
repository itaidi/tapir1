<?php 

// список предустановленных команд, которые запускаются через curl из docker-compose.yml

// создает файл лога от нужного пользователя, чтобы не было конфликтов, при запуске composer install из другого контейнера
$output = shell_exec('touch /var/www/src/storage/logs/laravel.log');
echo "<pre>$output</pre>"; // result

echo 'laravel.log by www creted (fix) ✅
';

?>
