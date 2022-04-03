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
