<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\SnowResorts;
use Illuminate\Http\Request;

class SnowResortController extends Controller
{
    protected $slopesController;
    protected $activitiesController;
    protected $imagesController;

    public function __construct(SlopesController $slopesController, ActivitiesController $activitiesController,ImagesController $imagesController)
    {
        $this->imagesController=$imagesController;
        $this->slopesController = $slopesController;
        $this->activitiesController = $activitiesController;
    }
  public function index()
    {
        $slopes = $this->slopesController->index()->getData();
        $activities = $this->activitiesController->index()->getData();
        $images = $this->imagesController->index()->getData();
        $snowResorts = SnowResorts::all();

        foreach ( $snowResorts as $resort) {
            $resortImages=[];
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
            foreach ($slopes as $slope) {
                if ($resort->id ==$slope->snow_resort_id){
                    $resortSlopes[]=$slope;
                }
            }
            $resort['slopes']=$resortSlopes;
            foreach ($images as $image) {
                if ($resort->id ==$image->snow_resort_id){
                    $resortImages[]=$image;
                }
            }
            $resort['images']=$resortImages;

        }
        $snowResorts=$this->transformResortsArray($snowResorts);




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
            return response()->json(['message' => 'Snow resort not found'], 404);
        }

        return response()->json($snowResort);
    }

    public function destroy($id)
    {
        $snowResort = SnowResorts::find($id);

        if (!$snowResort) {
            return response()->json(['message' => 'Snow resort not found'], 404);
        }

        try {
            $snowResort->delete();

            return response()->json(['message' => 'Snow resort deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting record'], 500);
        }
    }

    protected function transformResortsArray($snowResorts)
    {
        return $snowResorts->map(function ($resort) {
            $resort->name = [
                'el' => $resort->name_el,
                'en' => $resort->name_en,
            ];
            $resort->elevation = [
                'base' => $resort->elevation_base,
                'peak' => $resort->elevation_peak,
            ];
            unset($resort->elevation_base);
            unset($resort->elevation_peak);
            unset($resort->name_el);
            unset($resort->name_en);
            return $resort;
        });
    }
}
