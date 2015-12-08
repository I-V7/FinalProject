@extends('app')
@section('content')
        <style>
            #titleWelcome{
                left:0px
                position:absolute;
                text-align: center;
                margin:auto;
                font-family: "Courier New", Courier, monospace;
                font-size: 40px;
                width: 100%;
                top: 30px;
            }
            #logo{
                position:relative;
                text-align: center;
            }
        </style>

        <div class="content">
            <div id="logo">
               <div id="titleWelcome">ACM Competition</div>
               <img id="csmlogo" src="http://www.arrl.org/images/view/Group/UniversitLogotif.gif">
            </div>
        </div>


@stop