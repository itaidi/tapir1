<?php 

// Парсер переменных переданных из консоли
//function arguments($argv) { $_ARG=array();foreach ($argv as $arg) {
//      if(stripos($arg,"=",0)!==false){$arg=explode("=",$arg);
//        $_ARG[implode("",explode("-",array_shift($arg)))] = implode("=",$arg);
//      } else { $_ARG['input'][]=$arg;}} return $_ARG; } //print_r(arguments($argv));$args=arguments($argv); 
define("WORK_DIR",__DIR__."/");

$json_file='composer.json';
echo WORK_DIR.$json_file;
if(!file_exists(WORK_DIR.$json_file)) return 0;
if(!file_exists(WORK_DIR.'vendor')) return 0;

$content=file_get_contents(WORK_DIR.$json_file);
$json=json_decode($content,true);
if (!$json) return 0;//var_dump($json);

if(!isset($json['require'])) return 0;$autoload='vendor/autoload.php';
if(!file_exists(WORK_DIR.$autoload)) return 0; // check autoload
$require = $json['require'];

foreach($require as $k=>$v){ $checklist[]=explode("/",$k)[0]; }
for($i=(count($checklist)-3);$i<count($checklist);$i++){
    if(!file_exists(WORK_DIR."vendor/".$checklist[$i]) && $checklist[$i]!="php") return 0; 
} // проверка наличия последних 3 библ

require WORK_DIR.'vendor/autoload.php'; // проверка загрузки

// если все ок
echo 'autoload_is_ok'; // autoload is ok
exit;//return true;

?>