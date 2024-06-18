<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\SnowResorts;
use Illuminate\Http\Request;

class SnowResortController extends Controller
{
    public function index()
    {
        $Slopes= new SlopesController();
        $Slopes=$Slopes->index()->getData();
        $activities=new ActivitiesController();
        $activities=$activities->index()->getData();
        $snowResorts = SnowResorts::all();

        foreach ( $snowResorts as $resort) {
            $resortSlopes=[];
            $resortActivitiesEn=[];
            $resortActivitiesEl=[];
            $resortActivities=[];
            foreach ($activities as $activity){
                if ($resort->id ==$activity->snow_resort_id) {
                    if ($activity->language == 'en') {
                        $resortActivitiesEn[] = $activity;
                    } else {
                        $resortActivitiesEl[] = $activity;
                    }
                }
            }
            $resortActivities['en']=$resortActivitiesEn;
            $resortActivities['el']=$resortActivitiesEl;
            $resort['activities']=$resortActivities;
            foreach ($Slopes as $slope) {
                if ($resort->id ==$slope->snow_resort_id){
                    $resortSlopes[]=$slope;
                }
            }
            $resort['slopes']=$resortSlopes;

        }
        $snowResorts=$this->transformationResortsArray($snowResorts);




        return response()->json($snowResorts);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'location' => 'required',
        ]);

        $snowResort = SnowResorts::create($data);
        return response()->json($snowResort, 201);
    }
    public function show($id)
    {
        $snowResort = SnowResorts::find($id);

        if (!$snowResort) {
            return response()->json(['message' => 'snow resort not found'], 404);
        }

        return response()->json($snowResort);
    }
    public function transformationResortsArray($snowResorts){
        foreach ( $snowResorts as $resort){
            $name['el']=$resort->name_el;
            $name['en']=$resort->name_en;
            $resort->name=$name;
            $elevetion['base']=$resort->elevation_base;
            $elevetion['peak']=$resort->elevation_peak;
            $resort['elevetion']=$elevetion;
        }
        return$snowResorts;
    }
}
