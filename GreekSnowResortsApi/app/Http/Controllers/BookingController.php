<?php

namespace App\Http\Controllers;
use App\Mail\BookingConfirmation;
use App\Models\Bookings;
use App\Models\Costs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{

    protected $costsController;
    public function __construct(CostsController $costsController)
    {
        $this->costsController=$costsController;
    }
    /**
     * Display a listing of the bookings for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $bookings=Bookings::where('user_id', $user->id)->get();
        return response()->json($bookings);

    }



    public function store(Request $request)
    {
        $booking=[];
        $request->validate([
            'snow_resort_id' => 'required|integer',
            'cost' => 'required|integer',
        ]);
        $user = Auth::user();
        if (!$this->validateCost($request->input('snow_resort_id'),$request->input('cost'))){
            return response()->json(['message' => 'something went wrong'], 400);

        }

        $booking = new Bookings();
        $booking->snow_resort_id = $request->input('snow_resort_id');
        $booking->user_id = $user->id;
        $booking->order_time = now();
        $booking->save();
        Mail::to($user->email)->send(new BookingConfirmation($booking));

        return response()->json($booking, 201);


    }
    public function validateCost($snow_resort_id, $requestCost): bool
    {
        $costData=$this->costsController->getBySnowResortId($snow_resort_id)->getData();
        foreach ($costData as $cost){
            //na yparxi h dinatotita gia diafores katigories apo kosti
            if($cost->type=='kanoniko'){
                if ($cost->cost== $requestCost){
                    return true;
                }
            }
        }

        return false;

    }


}
