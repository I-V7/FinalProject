@extends('app')

@section('content')


    {!!Form::open(['url' => 'updateteams', 'method'=> 'POST'])!!}
    @for($i=0; $i<count($teams);$i++)
        {!!Form::label('name'.strval($i), 'Team Name:')!!}
        {!!Form::text('name'.strval($i),$teams[$i][0] )!!}
        <br>
        @for($j=1; $j<count($teams[$i]);$j++)
            {!! Form::label('members'.strval($j)) !!}

            {!! Form::select('members'.strval($j), $users, $teams[$i][$j]) !!}
            <br>
        @endfor
        <br>
        <br>
    @endfor
    {!!Form::submit('Make teams', ['class' => 'btn btn-primary form-control'])!!}
    {!!Form::close()!!}



@stop