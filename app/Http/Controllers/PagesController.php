<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Request;

class PagesController extends Controller
{


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
        return view('info');
    }
    public function auth(){
        return view('auth.login');
    }
    public function updateInfo($id, Request $request)
    {
        //get data for table
        $info = \App\User::findorfail($id);

        $info->name = $request->name;
        $info->language = $request->language;
        $info->class = $request->class;
        $info->teamstyle = $request->teamstyle;

        //redirect to info
        return redirect ('auth.info');
    }
    public function userProfile()
    {
        $id = \Auth::user()->id;
        return view('profile');
    }
    public function createteams()
    {
        $id = \Auth::user()->id;
        $admin = DB::table('users')->where('id', $id)->where('userType', 'admin')->count();
        echo $admin;
        if($admin ==  1)
        {
            return view('create');
        }
        return redirect('/');

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

        $min = Request::input('min');
        $max = Request::input('max');
        if ($min > $max || $min < 0 || $max < 0) {
            return redirect('create');
        }
        $numCompUsers = DB::table('users')->where('teamStyle1', 'comp')->count();
        $numSocUsers = DB::table('users')->where('teamStyle1', 'soc')->count();
        $numIdcUsers = DB::table('users')->where('teamStyle1', 'idc')->count();
        $halfNumIdcUsers = $numIdcUsers/2;
        $numCompTeams = ($numCompUsers+ $halfNumIdcUsers)/ $max;
        $numSocTeams = ($numSocUsers + $halfNumIdcUsers)/ $max;

        $users = DB::table('users')->get();

        $numUsers = DB::table('users')->count();
        for($i=0; $i<$numCompTeams;$i++)
        {
            DB::table('team')->insert(array('teamName'=>'Competitive Team '.$i, 'teamType'=>'comp'));
        }
        for($i=0; $i<$numSocTeams;$i++)
        {
            DB::table('team')->insert(array('teamName'=>'Social Team '.$i, 'teamType'=>'soc'));
        }
        $compTeams = array();
        $socTeams = array();

        for ($i = 0; $i < $numCompTeams ; $i++) {
            $compTeams[$i] = array();
        }
        for ($i = 0; $i < $numSocTeams; $i++) {
            $socTeams[$i] = array();
        }


        $remaining = array();
        $remaining2 = array();
        $noMoreRoom = true;
        for($i=0; $i<count($users); $i++) {

            if ($users[$i]->teamStyle1 == 'comp') {

                for ($j = 0; $j < $numCompTeams; $j++) {

                    if (count($compTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining, $users[$i]);
                }
            } elseif ($users[$i]->teamStyle1 == 'soc') {

                for ($j = 0; $j < $numSocTeams; $j++) {

                    if (count($socTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Social Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($socTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining, $users[$i]);
                }
            } elseif ($users[$i]->teamStyle1 == 'idc') {

                for ($j = 0; $j < $numSocTeams; $j++) {

                    if (count($socTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Social Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($socTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                for ($j = 0; $j < $numCompTeams; $j++) {

                    if (count($compTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining, $users[$i]);
                }
            }
        }


        for($i=0; $i<count($remaining); $i++) {
            if ($users[$i]->teamStyle2 == 'comp') {
                for ($j = 0; $j < $numCompTeams; $j++) {
                    if (count($compTeams[ $j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining2, $users[$i]);
                }
            } elseif ($users[$i]->teamStyle2 == 'soc') {
                for ($j = 0; $j < $numSocTeams; $j++) {
                    if (count($socTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Social Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($socTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining2, $users[$i]);
                }
            } elseif ($users[$i]->teamStyle2 == 'idc') {
                for ($j = 0; $j < $numCompTeams; $j++) {
                    if (count($compTeams[ $j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                for ($j = 0; $j < $numSocTeams; $j++) {
                    if (count($socTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Social Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($socTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining2, $users[$i]);
                }
            }
        }
        $remaining3 = array();
        for($i=0; $i<count($remaining2); $i++) {
            if ($users[$i]->teamStyle3 == 'comp') {
                for ($j = 0; $j < $numCompTeams; $j++) {
                    if (count($compTeams[ $j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining3, $users[$i]);
                }
            } elseif ($users[$i]->teamStyle3 == 'soc') {
                for ($j = 0; $j < $numSocTeams; $j++) {
                    if (count($socTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Social Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($socTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining3, $users[$i]);
                }
            } elseif ($users[$i]->teamStyle3 == 'idc') {
                for ($j = 0; $j < $numCompTeams; $j++) {
                    if (count($compTeams[ $j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                for ($j = 0; $j < $numSocTeams; $j++) {
                    if (count($socTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Social Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID'=>$id));
                        array_push($socTeams[$j], $users[$i]->firstName.' '.$users[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining3, $users[$i]);
                }

            }
        }
        if(!empty($remaining3))
            dd($remaining3);


        return view('teams', ['compTeams' => $compTeams, 'socTeams' => $socTeams, 'users'=>$users]);
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
