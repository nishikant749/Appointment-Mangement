<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;


#Models
use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentSlot;

class DoctorController extends Controller
{
    #Define base view
    protected $baseView = 'doctor.';

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
        #FEtch all doctors
        $doctors = $this->user->doctor()->get();

        #return to view
        return view($this->baseView.'index')->with(['user' => Auth::user(), 'doctors' => $doctors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
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
    public function updateDoctor(Request $request)
    {
        #Fetch Apoointment
        $doctor = $this->user->doctor()->find($request->id);

        # return to Modal View
        $html = view($this->baseView.'update')->with(['doctor' => $doctor])->render();

         # return json
        return response()->json(['status' => 200, 'html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $doctor)
    {
        #Set Data
        $data = [
            'name'          => $request->name,
            'email'         => $request->email,
            'mobile'        => $request->mobile,
            'qualification' => $request->qualification,
            'specialization'=> $request->specialization,
        ];

        #Update
        $doctor->update($data);

        #return to 
        return back()->with('message', 'Doctor updated Successfully.');
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
