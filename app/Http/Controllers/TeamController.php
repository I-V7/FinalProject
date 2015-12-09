<?php

namespace App\Http\Controllers;



use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Request;
class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $teamMin = 0;
    private $teamMax = 0;
    private $cTeams;
    private $sTeams;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $min = Request::input('min');
        $max = Request::input('max');
        $this->teamMin = $min;
        $this->teamMax = $max;
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
                $noMoreRoom = true;
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
                if($noMoreRoom) {
                    for ($j = 0; $j < $numCompTeams; $j++) {

                        if (count($compTeams[$j]) < $max) {
                            $id = DB::table('team')->where('teamName', 'Competitive Team ' . $j)->pluck('id');
                            DB::table('user_team_xref')->where('userID', $users[$i]->id)->update(array('teamID' => $id));
                            array_push($compTeams[$j], $users[$i]->firstName . ' ' . $users[$i]->lastName);
                            $noMoreRoom = false;
                            break;
                        }
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining, $users[$i]);
                }
                $noMoreRoom = true;
            }
        }


        for($i=0; $i<count($remaining); $i++) {
            if ($remaining[$i]->teamStyle2 == 'comp') {
                for ($j = 0; $j < $numCompTeams; $j++) {
                    if (count($compTeams[ $j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $remaining[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $remaining[$i]->firstName.' '.$remaining[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining, $remaining[$i]);
                }
                $noMoreRoom = true;
            } elseif ($remaining[$i]->teamStyle2 == 'soc') {
                for ($j = 0; $j < $numSocTeams; $j++) {
                    if (count($socTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Social Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $remaining[$i]->id)->update(array('teamID'=>$id));
                        array_push($socTeams[$j], $remaining[$i]->firstName.' '.$remaining[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining2, $remaining[$i]);
                }
                $noMoreRoom = true;
            } elseif ($remaining[$i]->teamStyle2 == 'idc') {
                for ($j = 0; $j < $numCompTeams; $j++) {
                    if (count($compTeams[ $j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $remaining[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $remaining[$i]->firstName.' '.$remaining[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if($noMoreRoom) {
                    for ($j = 0; $j < $numSocTeams; $j++) {
                        if (count($socTeams[$j]) < $max) {
                            $id = DB::table('team')->where('teamName', 'Social Team ' . $j)->pluck('id');
                            DB::table('user_team_xref')->where('userID', $remaining[$i]->id)->update(array('teamID' => $id));
                            array_push($socTeams[$j], $remaining[$i]->firstName . ' ' . $remaining[$i]->lastName);
                            $noMoreRoom = false;
                            break;
                        }
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining2, $remaining[$i]);
                }
                $noMoreRoom = true;
            }
        }
        $remaining3 = array();
        for($i=0; $i<count($remaining2); $i++) {
            if ($remaining2[$i]->teamStyle3 == 'comp') {
                for ($j = 0; $j < $numCompTeams; $j++) {
                    if (count($compTeams[ $j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $remaining2[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $remaining2[$i]->firstName.' '.$remaining2[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining3, $remaining2[$i]);
                }
                $noMoreRoom = true;
            } elseif ($users[$i]->teamStyle3 == 'soc') {
                for ($j = 0; $j < $numSocTeams; $j++) {
                    if (count($socTeams[$j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Social Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $remaining2[$i]->id)->update(array('teamID'=>$id));
                        array_push($socTeams[$j], $remaining2[$i]->firstName.' '.$remaining2[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining3, $users[$i]);
                }
                $noMoreRoom = true;
            } elseif ($remaining2[$i]->teamStyle3 == 'idc') {
                for ($j = 0; $j < $numCompTeams; $j++) {
                    if (count($compTeams[ $j]) < $max) {
                        $id = DB::table('team')->where('teamName', 'Competitive Team '.$j)->pluck('id');
                        DB::table('user_team_xref')->where('userID', $remaining2[$i]->id)->update(array('teamID'=>$id));
                        array_push($compTeams[$j], $remaining2[$i]->firstName.' '.$remaining2[$i]->lastName);
                        $noMoreRoom = false;
                        break;
                    }
                }
                if($noMoreRoom) {
                    for ($j = 0; $j < $numSocTeams; $j++) {
                        if (count($socTeams[$j]) < $max) {
                            $id = DB::table('team')->where('teamName', 'Social Team ' . $j)->pluck('id');
                            DB::table('user_team_xref')->where('userID', $remaining2[$i]->id)->update(array('teamID' => $id));
                            array_push($socTeams[$j], $remaining2[$i]->firstName . ' ' . $remaining2[$i]->lastName);
                            $noMoreRoom = false;
                            break;
                        }
                    }
                }
                if ($noMoreRoom) {
                    array_push($remaining3, $remaining2[$i]);
                }
                $noMoreRoom = true;
            }
        }
        if(!empty($remaining3))
            dd($remaining3);


        $this->cTeams = $compTeams;
        $this->sTeams = $socTeams;
        return view('teams', ['compTeams' => $compTeams, 'socTeams' => $socTeams, 'users'=>$users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       $name = $request::get('name');
        dd($name);
       $tempTeams = DB::table('user_team_xref')->join('team','team.id', '=', 'user_team_xref.teamID')->join('users','users.id', '=', 'user_team_xref.userID')->select('users.firstName', 'users.lastName','team.teamName')->orderBy('team.teamName', 'asc')->get();
       $teams = array();
       $j = 0;
       for($i=0; $i<count($tempTeams); $i++)
       {
           $name = $tempTeams[$i]->teamName;
           $teams[$j] = array();
           array_push($teams[$j],$name);

           while($i<count($tempTeams))
           {

               if($tempTeams[$i]->teamName == $name)
               {
                   array_push($teams[$j], $tempTeams[$i]->firstName.' '.$tempTeams[$i]->lastName);
                   $i++;
               }
               else
               {
                  $i--;
                   break;
               }

           }
           $j++;

       }

      return view('viewteams', ['teams' => $teams]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $tempTeams = DB::table('user_team_xref')->join('team','team.id', '=', 'user_team_xref.teamID')->join('users','users.id', '=', 'user_team_xref.userID')->select('users.id','users.firstName', 'users.lastName','team.teamName')->orderBy('team.teamName', 'asc')->get();
        $tempUsers = DB::table('users')->select('id','firstName', 'lastName')->get();

        $users = array();
        for($i=0; $i<count($tempUsers);$i++)
        {
            $users[$tempUsers[$i]->id]=$tempUsers[$i]->firstName.' '.$tempUsers[$i]->lastName;
        }

        $teams = array();
        $j = 0;
        for($i=0; $i<count($tempTeams); $i++)
        {
            $name = $tempTeams[$i]->teamName;
            $teams[$j] = array();
            array_push($teams[$j],$name);

            while($i<count($tempTeams))
            {
                if($tempTeams[$i]->teamName == $name)
                {
                    array_push($teams[$j], $tempTeams[$i]->id);
                    $i++;
                }
                else
                {
                    $i--;
                    break;
                }
            }
            $j++;

        }

        return view('editteams',['teams'=>$teams, 'users'=>$users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        return 'tho';
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
