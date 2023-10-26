<?php

namespace App\Helpers;

use DOMDocument;
use DOMXPath;

class Scraping
{
    public function getSnowReportPage($skiCenter){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.snowreport.gr/$skiCenter/",
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
        return $this->ScrapingPage($response);

    }
    public function ScrapingPage($page)
    {
        libxml_use_internal_errors(true);  // Enable error handling

        $lifts = [];
        $doc = new DOMDocument();
        $doc->loadHTML($page);
        $selector = new DOMXPath($doc);
        $result = $selector->query('//div[@class="lift-block"]');

        if ($result->length >= 2) { // Check if there are at least 2 elements
            $lifts['today'] = $this->getOpenLifts($result->item(0));
            $lifts['tomorrow'] = $this->getOpenLifts($result->item(1));
        }

        return $lifts;
    }

    public function getOpenLifts($result )
    {
        $lifts = [];

        // Create a new DOMDocument to work with the selected nodes
        $newDoc = new DOMDocument();
        $newDoc->appendChild($newDoc->importNode($result, true)); // Import the resortInfo node into the new document
        $newSelector = new DOMXPath($newDoc);

        // Query for red lift names
        $redLifts = $newSelector->query('//span[@class="lift-name red"]');
        foreach ($redLifts as $element) {
            $liftname = $element->textContent;
            $liftname = str_replace("\n", "", $liftname);
            $lifts[$liftname] = 0; // Store lift name with status 'red'
        }

        // Query for green lift names
        $greenLifts = $newSelector->query('//span[@class="lift-name green"]');
        foreach ($greenLifts as $element) {
            $liftname = $element->textContent;
            $liftname = str_replace("\n", "", $liftname);
            $lifts[$liftname] = 1; // Store lift name with status 'green'
        }

        return $lifts;
    }

}
