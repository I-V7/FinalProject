@extends('app')

@section('content')


    {!!Form::open(['url' => 'updateteams', 'method'=> 'GET'])!!}
    @for($i=0; $i<count($teams);$i++)

        {!!Form::label($teams[$i][0], 'Team Name:')!!}
        {!!Form::text($teams[$i][0],$teams[$i][1] )!!}
        <br>
        @for($j=1; $j<count($teams[$i])-1;$j++)
            {!! Form::label('members'.strval($i).strval($j), 'member'.strval($i).strval($j)) !!}

            {!! Form::select('members'.strval($i).strval($j), $users, $teams[$i][$j+1]) !!}
            <br>
        @endfor
        <br>
        <br>
    @endfor
    {!!Form::submit('Make teams', ['class' => 'btn btn-primary form-control'])!!}
    {!!Form::close()!!}



@stop