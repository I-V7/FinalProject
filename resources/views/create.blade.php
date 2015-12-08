@extends('app')

@section('content')

    {!!Form::open(['url' => 'teams', 'method'=> 'GET'])!!}
    {!!Form::label('min', 'Min team size:')!!}
    {!!Form::input('number', 'min', '0')!!}
    {!!Form::label('max', 'Max team size:')!!}
    {!!Form::input('number','max', '0')!!}
    {!!Form::submit('Make teams', ['class' => 'btn btn-primary form-control'])!!}
    {!!Form::close()!!}

@stop