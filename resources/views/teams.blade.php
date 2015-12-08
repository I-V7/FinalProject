@extends('app')

@section('content')



    @for($i=0; $i<count($compTeams); $i++)
        <h1>Competitive Team{{$i}}</h1>
        @for($j=0; $j<count($compTeams[$i]); $j++)
            <p>{{$compTeams[$i][$j]}}</p>
        @endfor
        <br>
    @endfor
    @for($i=0; $i<count($socTeams); $i++)
        <h1>Social Team{{$i}}</h1>
        @for($j=0; $j<count($socTeams[$i]); $j++)
            <p>{{$socTeams[$i][$j]}}</p>
        @endfor
        <br>
    @endfor





@stop