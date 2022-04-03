<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;

#Models
use App\Models\User;

class RegisterController extends Controller
{
    #Define base view
    protected $baseView = 'register.';

    #Initialaize variables
    protected $user;

    /**
     * @method to define Constructor of Controller
     * @return
     * @param
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        //
    }

    /**
     * @method to check user existence on email
     * @return boolean
     * @param Request $request
     */
    public function userCheckOnEmail(Request $request)
    {
        #FEtch email
        $email = $request->input('email');

        #Fetch count of User on requested Email id
        $count = $this->user->where('email', $email)->count();

        #Return based on User count
        if ($count == 0) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #FEtch UserData
        $userData = [
            'name'           => $request->name ?? '',
            'email'          => $request->email ?? '',
            'mobile'         => $request->mobile ?? '',
            'user_type'      => $request->user_type?? '',
            'qualification'  => $request->qualification ?? '',
            'specialization' => $request->specialization ?? '',
            'password'       => Hash::make($request->password),
        ];
        
        #Validate user on email
        $userModel = $this->user
                        ->where('email', $request->email)
                        ->get();

        #Validate userModel and return to view if exist
        if($userModel->isNotEmpty()) {
            return view($this->baseView.'index');
        }

        #Create the user
        $user = $this->user->create($userData);

        #AssignRole to user
        ($request->user_type == 'doctor') ? $user->assignRole('doctor') : $user->assignRole('patient');

        #return to view
        return view('login.index');
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
    public function update(Request $request, $id)
    {
        //
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
