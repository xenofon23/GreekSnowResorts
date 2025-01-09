<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    public function proxyStream(Request $request, $file)
    {
        $baseUrl = 'https://pluto13.cybex.gr/hls/';
        $url = $baseUrl . $file;
        $response = Http::get($url);
        if ($response->successful()) {
            $contentType = $this->getContentType($file);
            return response($response->body())
                ->header('Content-Type', $contentType)
                ->header('Access-Control-Allow-Origin', '*');
        } else {
            return response('Not Found', 404);
        }
    }
    private function getContentType($file)
    {
        // Check if the file is a .m3u8 (manifest) or .ts (segment)
        if (strpos($file, '.m3u8') !== false) {
            return 'application/vnd.apple.mpegurl'; // HLS Manifest
        } elseif (strpos($file, '.ts') !== false) {
            return 'video/MP2T'; // MPEG-TS Segment
        }
        return 'application/octet-stream'; // Default binary content type
    }
}
