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
        $min =Request::input('min');
        $max = Request::input('max');
        if($min > $max ||  $min < 0 || $max < 0)
        {
            return redirect('create');
        }
        $users = DB::table('users')->get();

        $numUsers = DB::table('users')->count();
        $numTeams = $numUsers/$min;

        $teams = array();
        for($i=0; $i<$numTeams; $i++)
        {
            $teams[$i] = array();
        }
        $remaining = 0;
        for($i=0; $i<count($users); $i++)
        {
            if(count($users) -$i < $min)
            {
                $remaining = $i;
                break;
            }
            for($j=0; $j<$numTeams; $j++)
            {

                if(count($teams[$j]) < $min )
                {
                    array_push($teams[$j], $users[$i]->firstName.$users[$i]->lastName);

                    break;

                }
            }


        }
        for($i = $remaining; $i<count($users); $i++)
        {
            for($j=0; $j<$numTeams; $j++)
            {

                if(count($teams[$j]) < $max )
                {
                    array_push($teams[$j], $users[$i]->firstName.$users[$i]->lastName);

                    break;

                }
            }
        }

        return view('teams', ['teams' => $teams]);
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
