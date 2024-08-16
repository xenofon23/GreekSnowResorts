<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class isopen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:isopen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->getSnowReportPage();
    }
    public function getSnowReportPage(): void
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.snowreport.gr/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
       $this->ScrapingPage($response);

    }


    public function ScrapingPage($page): void
    {
        libxml_use_internal_errors(true);

        $doc = new \DOMDocument();
        $doc->loadHTML($page);
        $selector = new \DOMXPath($doc);

        // Find all list items in the submenu
        $resortNodes = $selector->query('//ul[@class="submenu"]/li/a');
        $i=0;
        foreach ($resortNodes as $node) {
            $url = $node->getAttribute('href');
            $statusNode = $node->getElementsByTagName('font')->item(0);
            $status = $statusNode->getAttribute('color') === 'red' ? 'Closed' : 'Open';
            $resorts[] = [
                'name' =>  basename(parse_url($url, PHP_URL_PATH)),//get the name
                'status' => $status,
            ];
            if($i==21){
                break;
            }
            $i++;
        }

        $this->StoreStatus($resorts);
    }
    public function StoreStatus($resorts): void
    {
        foreach ($resorts as $resort) {
            $existingResort = DB::table('snow_resorts')
                ->where('name_en', $resort['name'])
                ->first();

            if ($existingResort) {
                DB::table('snow_resorts')->updateOrInsert(
                    ['name_en' => $resort['name']],
                    ['status' => $resort['status']]
                );
            }
        }
    }


}
