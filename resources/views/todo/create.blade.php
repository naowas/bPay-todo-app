@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="row">
        <div class="col-md-4">
            <h5>Create new todo</h5>
        </div>
        <div class="col-md-8 text-right">
            <div class="pull-right">
                <a href="{{url('/todo')}}" class="btn btn-success"> Todo list<i class="fa fa-fw fa-list"></i></a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <form action="{{url('/todo')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="taskTitle">Task title</label>
                            <input type="text" name="taskTitle" class="form-control" id="taskTitle" placeholder="">
                        </div>
                        <div class="form-group">
                            {{-- SM size with single date/time config --}}
                            @php
                                $config = [
                                    "singleDatePicker" => true,
                                    "class"=>"form-control",
                                    "showDropdowns" => true,
                                    "startDate" => "js:moment()",
                                    "minYear" => 2000,
                                    "maxYear" => "js:parseInt(moment().format('YYYY'),10)",
                                    "timePicker" => true,
                                    "timePicker24Hour" => true,
                                    "timePickerSeconds" => true,
                                    "cancelButtonClasses" => "btn-danger",
                                    "locale" => ["format" => "YYYY-MM-DD HH:mm:ss"],
                                ];
                            @endphp
                            <x-adminlte-date-range name="dateTime" label="Date/Time" igroup-size="md" :config="$config">
                                <x-slot name="appendSlot">
                                    <div class="input-group-text bg-dark">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                </x-slot>
                            </x-adminlte-date-range>
                        </div>

                        <div class="form-group">
                            @php
                                $config = [
                                    "height" => "350",
                                    "toolbar" => [
                                        // [groupName, [list of button]]
                                        ['style', ['bold', 'italic', 'underline', 'clear']],
                                        ['font', ['strikethrough', 'superscript', 'subscript']],
                                        ['fontsize', ['fontsize']],
                                        ['color', ['color']],
                                        ['para', ['ul', 'ol', 'paragraph']],
                                        ['height', ['height']],
                                        ['table', ['table']],
                                        ['insert', ['link', 'picture', 'video']],
                                        ['view', ['fullscreen', 'codeview', 'help']],
                                    ],
                                ]
                            @endphp
                            <x-adminlte-text-editor name="taskDetails" label="Task details"
                                                    igroup-size="md" placeholder="Write some text..." :config="$config"/>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {

        });
    </script>
@stop

