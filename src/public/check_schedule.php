<?php set_time_limit(120); // 2 мин

// запускаются через curl из docker-compose.yml, либо cron

// Default log
//$h = fopen("log.txt", "a+");fwrite($h,'Check: '.date("Y-m-d H:i:s").'\r\n');fclose($h);

// Laravel console schedule run (by user www)
$output = shell_exec('php /var/www/src/artisan schedule:run >> /dev/stdout 2>&1');
echo "<pre>$output</pre>"; // result

?>