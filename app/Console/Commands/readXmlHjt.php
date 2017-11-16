<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        $xmlString = file_get_contents($this->argument('path'));
        $xml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmljson= json_encode($xml);
        $xml=json_decode($xmljson,true);
        var_dump($xml);
    }
}
