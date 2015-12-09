@extends('app')

@section('content')

    <style>
        .comp{
            background: #99ccff;
            margin:0px;
        }
        .soc{
            background: #99ff99;
            margin:0px;
        }
        p{
            margin:0px;
        }
        p:nth-child(odd){
            background: #cccccc;
        }
        .btn {
            background: #3498db;
            background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9);
            -webkit-border-radius: 28;
            -moz-border-radius: 28;
            border-radius: 28px;
            font-family: Arial;
            color: #ffffff;
            font-size: 20px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }
        .btn:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
        }
    </style>


    @for($i=0; $i<count($compTeams); $i++)
<<<<<<< HEAD
        @unless(empty($compTeams[$i]))

        <h1>Competitive Team{{$i}}</h1>
=======
        <h1 class="comp">Competitive Team{{$i}}</h1>
>>>>>>> f0fd10bcf1fa9f953aa28d8d793f9e8317fc384f
        @for($j=0; $j<count($compTeams[$i]); $j++)
            <p>{{$compTeams[$i][$j]}}</p>
        @endfor
        <br>
        @endunless
    @endfor

    @for($i=0; $i<count($socTeams); $i++)
<<<<<<< HEAD
        @unless(empty($socTeams))
        <h1>Social Team{{$i}}</h1>
=======
        <h2 class="soc">Social Team{{$i}}</h2>
>>>>>>> f0fd10bcf1fa9f953aa28d8d793f9e8317fc384f
        @for($j=0; $j<count($socTeams[$i]); $j++)
            <p>{{$socTeams[$i][$j]}}</p>
        @endfor
        <br>
        @endunless
    @endfor
<<<<<<< HEAD
    <button type="button" onclick="window.location='{{ action('TeamController@edit') }}'">Edit teams</button>




=======

    <div class="btn">Button</div>
>>>>>>> f0fd10bcf1fa9f953aa28d8d793f9e8317fc384f
@stop