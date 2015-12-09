<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\languages;
use DB;
use Mockery\CountValidator\Exception;
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
        $courses = DB::table('courses')->lists('courseID');
        return view ('updatestudentinfo', compact('courses'));
    }
    public function userProfile()
    {
        $id = \Auth::user()->id;

        return view('profile');
    }
    public function updateInfo2(){
        $input = Request::all();
        $id = auth()->user()->id;
        //get user id

        //get user tuples
        $userData = \App\User::find($id);
        //get updated user data from form
        $userData->firstName = Request::input('firstName');
        $userData->lastName = Request::input('lastName');
        $userData->language1 = Request::input('language1');
        $userData->language2 = Request::input('language2');
        $userData->language3 = Request::input('language3');
        $userData->teamStyle1 = Request::input('teamStyle1');
        $userData->teamStyle2 = Request::input('teamStyle2');
        $userData->teamStyle3 = Request::input('teamStyle3');
//update user data
        $userData->save();
        foreach($input as $in){
            $cid = DB::table('courses')->where('courseID', $in)->value('id');

            if ($cid && $id) {
                DB::table('user_course_xref')->insert(['userID' => $id, 'courseID' => $cid]);
            }
        }

        /*for($j=1; $j<count($input) - 1;$j++) {
            $cid = DB::table('courses')->where('courseID', $input[$j])->value('id');
            DB::table('user_course_xref')->insert([['userID' => $id],['courseID' => $cid]]);
        }*/


        return redirect('profile');

        //return redirect('profile');
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
