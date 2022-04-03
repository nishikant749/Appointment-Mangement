<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;


#Models
use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentSlot;

class AppointmentController extends Controller
{
    #Define base view
    protected $baseView = 'appointment.';

    #Initialaize variables
    protected $user, $appointment, $appointmentSlot;

    /**
     * @method to define Constructor of Controller
     * @return
     * @param
     */
    public function __construct(User $user, Appointment $appointment, AppointmentSlot $appointmentSlot)
    {
        $this->user             = $user;
        $this->appointment      = $appointment;
        $this->appointmentSlot  = $appointmentSlot;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #return to view
        return view($this->baseView.'index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        #EFtch User
        $user = Auth::user();

        #fetch all doctors
        $doctors = $this->user
                        ->doctor()
                        ->get();

        #return to view
        return view($this->baseView.'create')->with(['user' => $user, 'doctors' => $doctors]);
    }

    /**
     * @method to Fetch the Slots of Doctor on Particular Date.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchSlots(Request $request)
    {
        #FEtch Doctor
        $doctor = $this->user
                       ->with(['doctorAppointments'])
                       ->find($request->doctorId);

       
        #Fetch slots which are busy in provided date
        $appointments = $doctor->doctorAppointments->filter(function($appointment) use($request){
            if($appointment->visit_date->format('Y-m-d') == $request->appointmentDate) {
                return ($appointment->slot_id);
            }
        });

        #FEtch busy Slots
        $busySlots = $appointments->pluck('slot_id')->toArray();

        #FEtch Slots
        $slots = $this->appointmentSlot->whereNotIn('id', $busySlots)->get();

        #returj slots
        return response()->json(['status' => 200, 'slots' => $slots]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #Fetch User
        $user = Auth::user();
        
        #set data for appointment
        $data = [
            'patient_id'    => ($user != '') ? $user->id : 0,
            'doctor_id'     => $request->doctor_id,
            'slot_id'       => $request->slot_id,
            'email'         => $request->email ?? '',
            'patient_name'  => $request->name ?? '',
            'disease'       => $request->disease,
            'visit_date'    => $request->date_of_appointment.'00:00:00',
        ];

        #Cerate Appointment
        $this->appointment->create($data);

        #return to 
        return back()->with('message', 'Appointment Created Successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        #Fetch Apoointment
        $appointment = $this->appointment->find($request->id);

        # return to Modal View
        $html = view($this->baseView.'update_status')->with(['appointment' => $appointment])->render();

         # return json
        return response()->json(['status' => 200, 'html' => $html]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        #Update appointment status
        $appointment->update(['status' => $request->status]);

        #return redirect
        return redirect()->back()->with(['message' => 'Status updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
