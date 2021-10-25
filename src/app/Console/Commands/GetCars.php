<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
//use App\Cars;
use App\Models\Cars;

class GetCars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cars:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load data of cars.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    private function insert_or_update($response){
        $not_updated=[]; foreach ( $response as $item){  
            if(isset($item["@attributes"])) {
                $item['id']=$item["@attributes"]['id'];
                unset($item["@attributes"]);}// xml fix
            $item['_id']=$item['id'];unset($item['id']); // замена id
            // если нет обновления, то в insert
            if(!Cars::where('_id',$item['_id'])->update($item)) $not_updated[]=$item;
        }   if($not_updated&&count($not_updated)) Cars::insert($not_updated);
    }
    public function handle()
    {
        Log::debug('Get Cars: '.date("Y-m-d H:i:s")); // log запуска события в cron
        // 1
        // импорт новых авто
        $response = json_decode(Http::get('http://static.tapir.ws/new_cars.json'),true);
        //var_dump($response[1]["body_type"]); // check
        $this->insert_or_update($response); //Cars::insert($response);
        Log::debug('Import {new_cars.json} done ✅: '.date("Y-m-d H:i:s"));
        // 2
        // импорт подержаных
        $response_xml = json_decode(json_encode(simplexml_load_string(file_get_contents('http://static.tapir.ws/used_cars.xml'))), true); 
        //var_dump($response_xml['Car']);// check
        $this->insert_or_update($response_xml['Car']); //Cars::insert($response_xml);
        Log::debug('Import {used_cars.xml} done ✅: '.date("Y-m-d H:i:s")); 
        return 0;
    }
}
