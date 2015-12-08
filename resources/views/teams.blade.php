@extends('app')

@section('content')



    @for($i=0; $i<count($teams); $i++)
        <h1>Team{{$i}}</h1>
        @for($j=0; $j<count($teams[$i]); $j++)
            <p>{{$teams[$i][$j]}}</p>
        @endfor
        <br>
    @endfor




@stop