@extends('app')

@section('content')
    <div class="row">
        <h1>{{auth()->user()->firstName}} {{auth()->user()->lastName}}</h1>
    </div>
    <div style="background-color:#5CB75C">
        <h3>Bio:</h3>
        <div class="col-md-10">
            <p>{{auth()->user()->bio}}</p>
        </div>
        <div class="row">
            <div class="col-xs-5" style="background-color:#337AB6">
                <h3>Favorite Languages:</h3>
                <h4>{{auth()->user()->language1}}</h4>
                <h4>{{auth()->user()->language2}}</h4>
                <h4>{{auth()->user()->language3}}</h4>
            </div>
            <div class="col-xs-5">
                <h3>Team Style:</h3>
                <h4>{{auth()->user()->teamStyle1}}</h4>
                <h4>{{auth()->user()->teamStyle2}}</h4>
                <h4>{{auth()->user()->teamStyle3}}</h4>
            </div>
        </div>
        <h3>Classes Taken:</h3>
        <div class="col-md-10">
            {{$list = DB::table('user_course_xref')->where('userID', auth()->user()->id)->pluck('courseID') }}
            {{$list}}
        </div>
        <h3>Team:</h3>

    </div>
    <button type="button" onclick="window.location='{{ action('PagesController@updateInfo') }}'">Edit info</button>
    @if(auth()->user()->userType == 'admin')
        <button type="button" onclick="window.location='{{ action('TeamController@edit') }}'">Edit teams</button>
    @endif
    <button type="button" onclick="window.location='{{ action('TeamController@show') }}'">View teams</button>
    <button type="button" onclick="window.location='{{ url('create') }}'">Create teams</button>

@stop