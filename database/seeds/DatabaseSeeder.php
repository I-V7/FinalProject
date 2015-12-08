<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use League\Csv\Reader;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
class UserTableSeeder extends seeder
{
    public function run()
    {
       // $myfile = fopen("D:/School/Mines/WebProgramming/finalProject/finalProject/database/seeds/students.csv", "r") or die("Unable to open file!");
        $myfile = fopen("database/seeds/students.csv", "r") or die("Unable to open file!");
        DB::table('users')->delete();
        $rawLine = "";
        while(($line = fgets($myfile)) !== false){
            $rawLine = rtrim($line);

            $info = explode(",", $rawLine);

            App\User::create(['firstName' => $info[0],
                              'lastName'=> $info[1],
                              'password' => bcrypt(strval($info[2])),
                              'email' => $info[3],
                              'userType'=>$info[4],
                              'language1'=>$info[5],
                              'language2'=>$info[6],
                              'language3'=>$info[7],
                              'teamStyle1' => $info[8],
                              'teamStyle2' => $info[9],
                              'teamStyle3' => $info[10],

                            ]);
        }
        fclose($myfile);
        $info = explode(",", $rawLine);
        App\User::create(['firstName' => 'Kyle',
                            'lastName'=> 'Dymowski',
                            'password' => bcrypt('12345678'),
                            'email' => 'kdymowsk@mines.edu',
                            'userType'=>'admin',
                            'language1'=>$info[5],
                            'language2'=>$info[6],
                            'language3'=>$info[7],
                            'teamStyle1' => $info[8],
                            'teamStyle2' => $info[9],
                            'teamStyle3' => $info[10]]);

    }
}
