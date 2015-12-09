@extends('app')

@section('content')

    @for($i=0; $i<count($teams);$i++)
        <h1>{{$teams[$i][0]}}</h1>
        @for($j=1;$j<count($teams[$i]);$j++)
            <p>{{$teams[$i][$j]}}</p>
        @endfor
    @endfor

    <button type="button" onclick="window.location='{{ action('TeamController@edit') }}'">Edit teams</button>


@stop