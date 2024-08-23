<?php

namespace App\Http\Controllers;
use App\Mail\BookingConfirmation;
use App\Models\Bookings;
use App\Models\Costs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        // Validate the incoming request data
        $request->validate([
            'snow_resort_id' => 'required|integer',
            'cost' => 'required|integer',
            'number_pass' => 'required|integer|min:1'
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Validate the cost for the snow resort
        if (!$this->validateCost($request->input('snow_resort_id'), $request->input('cost'))) {
            return response()->json(['message' => 'Something went wrong'], 400);
        }

        // Get the number of passes from the request
        $number_pass = $request->input('number_pass');

        // Array to hold the created bookings
        $createdBookings = [];

        // Create bookings and send confirmation emails
        for ($i = 1; $i <= $number_pass; $i++) {
            $booking = new Bookings();
            $booking->snow_resort_id = $request->input('snow_resort_id');
            $booking->user_id = $user->id;
            $booking->order_time = now();
            $booking->save();

            // Add the created booking to the array
            $createdBookings[] = $booking;

            // Send the booking confirmation email
            try {
                Mail::to($user->email)->send(new BookingConfirmation($booking));
            } catch (\Exception $e) {
                // Log the error or handle it accordingly
                Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
            }
        }

        // Return a response with the created bookings
        return response()->json([
            'message' => 'Bookings created successfully',
            'bookings' => $createdBookings
        ], 201);
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
