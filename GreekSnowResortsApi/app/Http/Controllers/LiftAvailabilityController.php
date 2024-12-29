<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\Scraping;
use App\Models\LiftAvailability;
use App\Models\SnowResorts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

 class LiftAvailabilityController extends Controller
{
    use Helpers;
     private SnowResortController $snowResortController;

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
        $admin= $this->admin($snowResortId);


        $liftAvailability = LiftAvailability::where('snow_resort_id', $snowResortId)->get();
        if($liftAvailability->isEmpty()){
            $scraping=new Scraping();
            $lifts=$scraping->getSnowReportPage($resortData->name_en);

            $this->store($lifts['today'],$snowResortId);
        }else if($liftAvailability[0]->is_open===null && $admin===false && $admin!==null ){
            $scraping=new Scraping();
            $lifts=$scraping->getSnowReportPage($resortData->name_en);

            $this->store($lifts['today'],$snowResortId);
        }
        $liftAvailability = LiftAvailability::where('snow_resort_id', $snowResortId)->get();
        return response()->json($liftAvailability);
    }

    public function update(Request $request )
    {
        $validator = Validator::make($request->all(), [
            '*.id' => 'required|exists:lift_availability,id',
            '*.snow_resort_id' => 'required|exists:snow_resorts,id',
            '*.is_open' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $lifts = $request->all();
        $snowResortId=$lifts[0]['snow_resort_id'];
        if(!$this->admin($snowResortId))
        {
            return response()->json(['message' => 'snow resort do not have admin panel'], 400);
        }
        foreach ($lifts as $lift) {
            LiftAvailability::where('id', $lift['id'])
                ->where('snow_resort_id', $lift['snow_resort_id'])
                ->update(['is_open' => $lift['is_open']]);
        }
        return response()->json(['message' => 'Lift availability statuses updated successfully'], 200);

    }

    public function show($snowResortId)
    {
        $lifts=LiftAvailability::where('snow_resort_id', $snowResortId)->get();
        return response()->json($lifts);

    }
    public function store($lifts, $snowResortId)
    {
        $availability = [];
        foreach ($lifts as $key => $value) {
            $data = [
                'snow_resort_id' => $snowResortId,
                'name' => $key,
            ];
            $updateData = [
                'is_open' => $value,
                'date' => date('Y-m-d H:i:s'),
            ];
            $availability[] = LiftAvailability::updateOrCreate($data, $updateData);
        }
        return response()->json($availability, 201);
    }



}
