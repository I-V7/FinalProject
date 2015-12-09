@extends('app')

@section('content')
    <h2>My Info</h2>
    <!--let laravel use the form builder-->
    {!!Form::model(null, ['url' => ['updatestudentinfo'], 'class' => 'form-horizontal', 'id' => 'infoForm'])!!}
        <!--Creating an input field for name using bootstrap-->
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                {!!Form::label('firstName', 'First:')!!}
            </div>
        {!!Form::text('fisrtName', auth()->user()->firstName, ['class' => 'form-control', 'placeholder' => 'Student Miner'])!!}
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                {!!Form::label('lastName', 'Last:')!!}
            </div>
        {!!Form::text('lastName', auth()->user()->lastName, ['class' => 'form-control', 'placeholder' => 'Student Miner'])!!}
        </div>


    </div>
    {{--{{$langs = ['C/C++', 'Java', 'Python']}}
    {{$courses = ['CSCI306', 'CSCI262', 'CSCI261']}}
    {{$style = ['Social', 'Competitive', 'either']}}--}}
   {{--{!! Form::select('members[]', ['C/C++', 'Java', 'Python'], null, array('multiple' => true, 'class' 'custom-scroll')) !!}--}}
    <h1>Favorite Language</h1>
    {!! Form::radio('language1', 'Python')!!}Python
    {!! Form::radio('language1', 'Java')!!}Java
    {!! Form::radio('language1', 'C++')!!}C++<br>
    <h1>Second Favorite Language</h1>
    {!! Form::radio('language2', 'Python')!!}Python
    {!! Form::radio('language2', 'Java')!!}Java
    {!! Form::radio('language2', 'C++')!!}C++<br>
    <h1>Third Favorite Language</h1>
    {!! Form::radio('language3', 'Python')!!}Python
    {!! Form::radio('language3', 'Java')!!}Java
    {!! Form::radio('language3', 'C++')!!}C++<br>
    <h1>Classes Taken</h1>

    @for($j=1; $j<count($courses);$j++)
        {!! $courses[$j] !!}
        {!! Form::radio($courses[$j], $courses[$j])!!}{!! $courses[$j]!!}
    @endfor

    <h1>Classes Taken</h1>
    {!! Form::radio('style', 'Competitive')!!}Competitive
    {!! Form::radio('style', 'Social')!!}Social
    {!! Form::radio('style', 'Either')!!}Either
    <br><br>

        <!--Form submit-->
        {!!Form::submit('update info', ['class' => 'btn btn-primary form-control'])!!}
    {!!Form::close()!!}
    <!--jQuery logic for dynamic elements-->
    <script>
        //add button click handler
        $(document).ready(function()
        {
            //classes selection method
            $('#classDropdown').on('click', 'li', function()
            {
                //get the selected text from dropdown
                var Value = $(this).text();

                //creating a new text field
                $('#classesDropdown').after('<div class="form-group" id="addedClass">' +
                        '<div class="col-xs-6">' +
                        '<input class="form-control" value=' + Value + ' name="class" id="class" type="text" disabled/>' +
                        '</div>' +
                        '<div class="col-xs-1">' +
                        '<button class="btn btn-danger" id="removeClass" type="button" >Remove</button>' +
                        '</div>' +
                        '</div>');
                //remove style from drop box
                $(this).remove();
            });
            //remove class selection method
            $('div').on('click', '#removeClass', function()
            {
                //get value of the text box
                var Value = $('#class').val();
                //remove the text box
                $('#addedClass').remove();
                //return style to drop box
                $('#classDropdown').append('<li><a href="#">' + Value + '</a></li>');
            })

            //team style selection method
            $('#styleDropdown').on('click', 'li', function()
            {
                //get the selected text from dropdown
                var Value = $(this).text();

                //creating a new text field
                $('#teamStyleDropdown').after('<div class="form-group" id="addedStyle">' +
                '<div class="col-xs-6">' +
                        '<input class="form-control" value=' + Value + ' name="teamstyle" id="style" type="text" disabled/>' +
                    '</div>' +
                    '<div class="col-xs-1">' +
                        '<button class="btn btn-danger" id="removeTeamStyle" type="button" >Remove</button>' +
                    '</div>' +
                '</div>');
                //remove style from drop box
               $(this).remove();
            });
            //remove team style method
            $('div').on('click', '#removeTeamStyle', function()
            {
                //get value of the text box
                var Value = $('#style').val();
                //remove the text box
                $('#addedStyle').remove();
                //return style to drop box
                $('#styleDropdown').append('<li><a href="#">' + Value + '</a></li>');
            })

            //language selection method
            $('#languageDropdown').on('click', 'li', function()
            {
                //avoid disabled from being chosen
                if($(this).text() == 'top is most favored')
                    return;
                //get the selected text from dropdown
                var Value = $(this).text();

                //creating a new text field
                $('#languagesDropdown').after('<div class="form-group" id="addedlang">' +
                '<div class="col-xs-6">' +
                        '<input class="form-control" value=' + Value + ' name="language" id="lang" type="text" disabled/>' +
                    '</div>' +
                    '<div class="col-xs-1">' +
                        '<button class="btn btn-danger" id="removeLanguage" type="button" >Remove</button>' +
                    '</div>' +
                '</div>');
                //remove style from drop box
                $(this).remove();
            });
            //remove language method
            $('div').on('click', '#removeLanguage', function()
            {
                //get value of the text box
                var Value = $('#lang').val();
                //remove the text box
                $('#addedlang').remove();
                //return language to drop box
                $('#languageDropdown').append('<li><a href="#">' + Value + '</a></li>');
            })
        });
    </script>
@stop