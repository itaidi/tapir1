<?php set_time_limit(120); // 2 мин

// запускаются через curl из docker-compose.yml, либо cron

// Default log
//$h = fopen("log.txt", "a+");fwrite($h,'Check: '.date("Y-m-d H:i:s").'\r\n');fclose($h);

// Laravel console schedule run (by user www)
//$output = shell_exec('php /var/www/src/artisan schedule:run >> /dev/stdout 2>&1');


// Проверка установился ли composer и все пакеты, т.к. докеры включаются работают асинхронно
echo '📌 check composer & autoload (is ready) 
'; while(true) { echo 'check ⏱ \r\n';
    $check = shell_exec('php /var/www/src/composer_ready_check.php --dir=/var/www/src/');//echo $check;
    if(stripos($check,"autoload_is_ok",0)!==false){ echo 'composer check done ✅ 
        ';break 1;// go next
    }else{usleep(5000000);echo 'composer check faild ⏱\n';} // pause 5 sec
}

// 1 секунда для предварительной загрузки mongo, при первом старте
usleep(1000000);

// 📌 Миграции при первом запуске
$output = shell_exec('php /var/www/src/artisan migrate >> /dev/stdout 2>&1');
echo "<pre>$output</pre>"; // result


$output = shell_exec('php /var/www/src/artisan cars:get >> /dev/stdout 2>&1');
echo "<pre>$output</pre>"; // result

?>
