<?php

namespace App\Http\Controllers;

use AllowDynamicProperties;
use App\Helpers\Scraping;
use App\Models\LiftAvailability;
use App\Models\SnowResorts;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

#[AllowDynamicProperties] class LiftAvailabilityController extends Controller
{
    public function __construct(SnowResortController $snowResortController)
    {
        $this->snowResortController = $snowResortController;
    }
    public function index($snowResortId)
    {
        $resort=$this->snowResortController->show($snowResortId);
        if($resort->status() == 404){
            return response()->json(['message' => 'snow resort not found'], 404);

        }
        $resortData=$resort->getData();
        $liftAvailability = LiftAvailability::where('snow_resort_id', $snowResortId)->get();
        if($liftAvailability->isEmpty()){
            $scraping=new Scraping();
            $lifts=$scraping->getSnowReportPage($resortData->name_en);

            $this->store($lifts['today'],$snowResortId);
        }

        $liftAvailability = LiftAvailability::where('snow_resort_id', $snowResortId)->get();
        return response()->json($liftAvailability);
    }

    public function store( $lifts,$snowResortId)
    {
        $data=[];
        foreach ($lifts as $key => $value){
            $data = [
                'snow_resort_id' => $snowResortId,
                'is_open' => $value,
                'name' => $key,
                'date'=> date('Y-m-d H:i:s'),
            ];
            $availability = LiftAvailability::create($data);
            $data=[];
        }
        return response()->json($availability, 201);
    }



}
