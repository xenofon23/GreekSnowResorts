<?php

namespace App\Console\Commands;

use App\Http\Controllers\SnowReportController;
use App\Models\SnowResorts;
use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunUpdateSnowReportTask extends Command
{
    protected SnowReportController $snowReportController;

    public function __construct()
    {
        parent::__construct();

        $this->snowReportController = new SnowReportController();

    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-update-snow-report-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run update reports info  every hour between 7 AM and 1 PM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $snowResorts = SnowResorts::all()->transform(function ($item) {
            return ['id' => $item->id, 'name_en' => $item->name_en, 'admin' => $item->admin];
        })->toArray();
        foreach ($snowResorts as $snowResort) {
            if($snowResort['admin']) {
                continue;
            }
            $page=$this->getSnowReportPage($snowResort['name_en']);
            $data=$this->getData($page);
            $response=$this->snowReportController->updateOrCreate($data,$snowResort['id']);
            if($response->getStatusCode()==201)
            {
                Log::info('Snow report cron job completed successfully at ' . now() . ' for resort ' . $snowResort['name_en']);

            }else{
                Log::info('Snow report cron job failed  at ' . now() . ' for resort ' . $snowResort['name_en']);

            }

        }
    }
    public function getData($page)
    {
        $html = $page;

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        $lastSnowfall = $xpath->query("//font[text()='Τελ.χιον/ση:']/following-sibling::text()")->item(0)->nodeValue ?? null;
        $baseDepth = $xpath->query("//font[text()='Υψος χιον.βάσης:']/following-sibling::text()")->item(0)->nodeValue?? null;
        $middleDepth = $xpath->query("//font[text()='Υψος χιον.μέσης:']/following-sibling::text()")->item(0)->nodeValue?? null;
        $peakDepth = $xpath->query("//font[text()='Υψος χιον.κορυφ:']/following-sibling::text()")->item(0)->nodeValue?? null;
        $snowQuality = $xpath->query("//font[text()='Ποιότ.χιονιού:']/following-sibling::text()")->item(0)->nodeValue?? null;

        $lastSnowfall = trim($lastSnowfall);
        $lastSnowfall = $lastSnowfall === "" ? null : $lastSnowfall;

        $baseDepth = trim($baseDepth);
        preg_match('/\d+/', $baseDepth, $matches);
        $baseDepth = isset($matches[0]) ? (int)$matches[0] : null;

        $middleDepth = trim($middleDepth);
        preg_match('/\d+/', $middleDepth, $matches);
        $middleDepth = isset($matches[0]) ? (int)$matches[0] : null;

        $peakDepth = trim($peakDepth);
        preg_match('/\d+/', $peakDepth, $matches);
        $peakDepth = isset($matches[0]) ? (int)$matches[0] : null;
        $snowQuality =trim($snowQuality);
        $snowQuality = $snowQuality === "" ? null : $snowQuality;

        return [
            'depth_base' => $baseDepth ,
            'depth_top' => $peakDepth  ,
            'depth_middle' => $middleDepth,
            'snow_quality' =>$snowQuality,
            'last_snowfall' => $lastSnowfall,
        ];

    }
    public function getSnowReportPage($name): string|bool
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.snowreport.gr/$name",
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
        return $response;

    }
}
