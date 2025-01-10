<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetFacebookPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-facebook-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $test= $this->getFacebookPage();
       echo 1;
    }
    public function getFacebookPage(): string|bool
    {
        $name='ElatochoriSki';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.facebook.com/$name",
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
