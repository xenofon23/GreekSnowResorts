<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\LiftAvailability;
use App\Models\SnowResorts;
use Illuminate\Http\Request;

class SnowResortController extends Controller
{
    protected $slopesController;
    protected $activitiesController;
    protected $imagesController;
    protected $liftAvailabilityController;

    public function __construct(SlopesController $slopesController, ActivitiesController $activitiesController,ImagesController $imagesController, LiftAvailabilityController $liftAvailabilityController )
    {
        $this->imagesController=$imagesController;
        $this->slopesController = $slopesController;
        $this->activitiesController = $activitiesController;
        $this->liftAvailabilityController = $liftAvailabilityController;
    }
  public function index()
    {

        $snowResorts = SnowResorts::all();

        $snowResorts =$this->transformResortsArray($snowResorts);

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

        $SnowResort = SnowResorts::where('id',$id)->first();
        if (!$SnowResort) {
            return response()->json(['message' => 'Snow resort not found'], 404);
        }
        $snowReports = $SnowResort->snowReports->first();
        $SnowResort->Posts;
        $activityIds=$SnowResort->activities;
        $SnowResort->name = [
            'el' => $SnowResort->name_el,
            'en' => $SnowResort->name_en,
        ];
        $SnowResort->elevation = [
            'base' => $SnowResort->elevation_base,
            'peak' => $SnowResort->elevation_peak,
        ];
        unset($SnowResort->elevation_base);
        unset($SnowResort->elevation_peak);
        unset($SnowResort->name_el);
        unset($SnowResort->name_en);
        unset($SnowResort->activities);
        unset($SnowResort->snowReports);
        $resort['info']=$SnowResort;
        $resort['info']['snow_reports']=$snowReports;
        $slopes = $this->slopesController->show($id)->getData();
        $images = $this->imagesController->show($id);
        $liftAvailability=$this->liftAvailabilityController->index($id)->getData();
        $activities=Activities::whereIn('id', $activityIds['activities'])->get()->toArray();
        foreach ($activities as $activity){

            if ($activity['language'] == 'en') {
                $resortActivitiesEn[] = $activity;
            } else {
                $resortActivitiesEl[] = $activity;
            }
        }
        $resortActivities['en']=$resortActivitiesEn;
        $resortActivities['el']=$resortActivitiesEl;
        $resort['lifts']=$liftAvailability;
        $resort['activities']=$resortActivities;
        $resort['slopes']=$slopes;
        $resort['images']=$images;
        return response()->json($resort);

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
            $images = $this->imagesController->getThumbnail($resort->id);

            if($images) {
                $resort->thumbnail = [
                    'caption' => $images->caption,
                    'image_url' => $images->image_url
                ];
            }
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
            unset($resort->activities);
            return $resort;
        });
    }

    public function test(request $request)
    {
        $file = $request->file('ski_areas');
        $jsonContents = file_get_contents($file->getPathname());
        $lifts = json_decode($jsonContents, true);
        $resorts=[];
        foreach ($lifts as $lift) {
            if (isset($lift['properties']['skiAreas'][0]['properties']['name'])) {
                $targetResortName = $lift['properties']['skiAreas'][0]['properties']['name'];

                if (!isset($resorts[$targetResortName])) {
                    $resorts[$targetResortName] = ['lifts' => []];
                }

                $liftName = $lift['properties']['name'] ?? 'Unknown Lift';
                $coordinates = $lift['geometry']['coordinates'] ?? null;
                if($lift['properties']['liftType']=="platter"){
                    $resorts[$targetResortName]['lifts'][$liftName]['occupancy']=1;

                }else if($lift['properties']['liftType']==="t-bar")
                {
                    $resorts[$targetResortName]['lifts'][$liftName]['occupancy']=1;
                }
                else{
                    $resorts[$targetResortName]['lifts'][$liftName]['occupancy']=$lift['properties']['occupancy'];

                }
                $resorts[$targetResortName]['lifts'][$liftName]['liftType']=$lift['properties']['liftType'];
                $resorts[$targetResortName]['lifts'][$liftName]['duration']=$lift['properties']['duration'];

                $resorts[$targetResortName]['lifts'][$liftName]['capacity']=$lift['properties']['capacity'];
                if ($coordinates !== null) {
                    $resorts[$targetResortName]['lifts'][$liftName]['coordinates'] = $coordinates;
                }
            }
        }
        return response()->json($resorts);

    }
}
