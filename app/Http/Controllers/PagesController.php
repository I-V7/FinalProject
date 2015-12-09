<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Request;

class PagesController extends Controller
{
    private $teamMin = 0;
    private $teamMax = 0;

    public function welcome(){
        return view('welcome');
    }
    public function home(){
        return view('home');
    }
    public function info(){
        if (\Auth::guest()){
            return view('/');
        }
        $id = \Auth::user()->id;
        return view('profile');
    }
    public function auth(){
        return view('auth.login');
    }
    public function updateInfo( Request $request)
    {
        //get data for table
        $id=\Auth::user()->id;
        $info = \App\User::findorfail($id);



        //redirect to info
        return view ('updatestudentinfo');
    }
    public function userProfile()
    {
        $id = \Auth::user()->id;
        return view('profile');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function edit()
    {
        echo $this->teamMin;
        echo $this->teamMax;
        $id = \Auth::user()->id;
        $admin = DB::table('users')->where('id', $id)->where('userType', 'admin')->count();
        $compTeams = DB::table('user_team_xref')->leftJoin('team', 'team.id', '=', 'user_team_xref.teamID')->leftJoin('users', 'users.id','=','user_team_xref.userID')->select('users.firstName','team.teamName')->where('team.teamType','=','comp')->get();
        dd($compTeams);
        $socTeams = DB::table('user_team_xref');
        if($admin ==  1)
        {
            return view('editteams');
        }
        return redirect('teams');
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
