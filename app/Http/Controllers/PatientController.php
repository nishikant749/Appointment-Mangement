<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;


#Models
use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentSlot;

class PatientController extends Controller
{
    #Define base view
    protected $baseView = 'patient.';

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
        #FEtch all patients
        $patients = $this->user->patient()->get();

        #return to view
        return view($this->baseView.'index')->with(['user' => Auth::user(), 'patients' => $patients]);
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
    public function updatePatient(Request $request)
    {
        #Fetch Apoointment
        $patient = $this->user->patient()->find($request->id);

        # return to Modal View
        $html = view($this->baseView.'update')->with(['patient' => $patient])->render();

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
    public function update(Request $request, User $patient)
    {
        #Set Data
        $data = [
            'name'          => $request->name,
            'email'         => $request->email,
            'mobile'        => $request->mobile,
        ];

        #Update
        $patient->update($data);

        #return to 
        return back()->with('message', 'Patient updated Successfully.');
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
