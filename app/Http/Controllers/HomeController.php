<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;


#Models
use App\Models\User;

class HomeController extends Controller
{
    #Define base view
    protected $baseView = 'login.';

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
     * @method to check user existence on email
     * @return boolean
     * @param Request $request
     */
    public function fetchUserOnEmail(Request $request)
    {
        #FEtch email
        $email = $request->input('email');

        #Fetch count of User on requested Email id
        $count = $this->user->where('email', $email)->count();

        #Return based on User count
        if ($count) {
            echo "true";
            exit;
        } else {
            echo "false";
            exit;
        }
    }

    /**
     * @method to attempt the login
     * @return dashboard page or Credentials Issue
     *
     */
    public function attemptLogin(Request $request)
    {   
        #Fetch Credentials
        $credentials = $request->only('email', 'password');
       
        #Validate the credentials and login User
        if (Auth::attempt($credentials)) {
            # Authentication passed...
            return redirect()->intended('dashboard');
        } else {
            return back()->with('error', 'Wrong Login Details');
        }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
