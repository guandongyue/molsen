<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class readXmlHjt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read:xml {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'read a xml file from path';

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
     * @return mixed
     */
    public function handle()
    {
        //
        echo $this->argument('path')."\n";

        $row = 1;
        $handle = fopen($this->argument('path'), "r");
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            # code...
            // echo "row {$row} - {$data[0]} - {$data[1]} - {$data[2]} - {$data[3]} - {$data[4]} - {$data[5]} - {$data[6]} - {$data[7]} - {$data[8]} - {$data[9]} - {$data[10]} - {$data[11]} - {$data[12]} - {$data[13]} - {$data[14]} - {$data[15]} - {$data[16]} - {$data[17]}\n";
            
            if ($row>2) {
                DB::table('order_blossom_hill')->insert([
                    'orderid' => $data[0],
                    'childid' => $data[1],
                    'srcDescript' => $data[2],
                    'hotelDescript' => $data[3],
                    'rmTypeDescript' => $data[4],
                    'roomNo' => $data[5],
                    'name' => $data[6],
                    'cardNo' => $data[7],
                    'sex' => intval($data[8]),
                    'mobile' => $data[9],
                    'idStreet' => $data[10],
                    'idType' => $data[11],
                    'idNo' => $data[12],
                    'nation' => $data[13],
                    'arr' => $data[14],
                    'dep' => $data[15],
                    'charge' => $data[16],
                    'payCodeDescript' => $data[17],
                ]);
            }

            // if ($row>3) {
            //     exit;
            // }
            $row++;
        }
        fclose($handle);
    }
}
