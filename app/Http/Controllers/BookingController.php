<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Models\Workshop;
use App\Models\Booking;
use App\Models\User;
use Validator;

/**
 * Class BookingController
 * @package App\Http\Controllers
 */
class BookingController extends Controller
{

    /**
     * Add new booking.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request) : JsonResponse
    {

        $errors = [];
        $errorsCount = 0;
        $input = $request->all();
        $customer = [
            'name'       => $input['name'],
            'phone'      => $input['phone'],
            'workshopId' => $input['workshopId'],
        ];
        $messages = [
            'name.required'       => 'Please fill in the name field!',
            'phone.required'      => 'Please fill in the phone field!',
            'workshopId.required' => 'Please fill in the workshop field!',
            'email.required'      => 'Please fill in the email field!'
        ];
        $customerValidator = Validator::make($customer, [
            'name'       => 'required',
            'phone'      => 'required',
            'workshopId' => 'required',
        ], $messages);

        if ($customerValidator->fails()){
            $errors['customer'] = $customerValidator->errors();
            $errorsCount++;
        }

        if(!empty($input['guests'])){

            foreach ($input['guests'] as $index => $guest){
                $guestValidator = Validator::make($guest, [
                    'name'  => 'required',
                    'email' => 'required'
                ], $messages);

                if($guestValidator->fails()){
                    $errors['guests'][$index] = $guestValidator->errors();
                    $errorsCount++;
                }else{
                    $errors['guests'][$index] = [];
                }
            }

        }

        if($errorsCount > 0){
            return $this->buildResponse(400, [], $errors);
        }

        $workshop = Workshop::find($input['workshopId']);
        $workshop->load('bookings');
        $workshopArr = $workshop->toArray();
        $bookedCount = count($workshopArr['bookings']);
        $freePlaces  = $workshop->max_guests - $bookedCount;

        // +1 it is a customer
        if($freePlaces < count($input['guests']) + 1){
            return $this->buildResponse(400, ['freePlaces' => $freePlaces], ['error' => 'NOT_ENOUGH_PLACES']);
        }

        $customer = User::create($customer);
        $booking = new Booking([
            'workshop_id' => $workshop->id,
            'user_id'     => $customer->id,
        ]);
        $customer->booking()->save($booking);

        if(isset($input['guests'])){

            foreach ($input['guests'] as $guest){
                $guest['customer_id'] = $customer->id;
                $createdGuest = User::create($guest);
                $booking = new Booking([
                    'workshop_id' => $workshop->id,
                    'user_id'     => $createdGuest->id,
                ]);
                $createdGuest->booking()->save($booking);
            }

        }

        return $this->buildResponse(200, ['booked' => 'WORKSHOP_BOOKED_SUCCESS']);

    }

    /**
     * Getting initial data
     *
     * @return JsonResponse
     */
    public function getInitialData() : JsonResponse
    {

        $workshop = Workshop::get();
        return $this->buildResponse(200, ['workshops' => $workshop]);

    }

}
