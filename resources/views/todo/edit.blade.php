@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="row">
        <div class="col-md-4">
            <h5>Edit todo</h5>
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
            <div class="card card-primary">
                <form action="{{url('/todo/'.$id)}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="taskTitle">Task title</label>
                            <input type="text" name="title" class="form-control" id="taskTitle" value="{{$title}}">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    @php
                                        $config = [
                                            'format' => 'YYYY-MM-DD',
                                             "class"=>"form-control",
                                            ];
                                    @endphp
                                    <x-adminlte-input-date name="date" label="Date" igroup-size="md" :config="$config"
                                                           value="{{$date}}">
                                        <x-slot name="appendSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    @php
                                        $config = [
                                            'format' => 'LT',
                                             "class"=>"form-control",
                                            ];
                                    @endphp
                                    <x-adminlte-input-date name="time" label="Time" igroup-size="md" :config="$config"
                                                           value="{{$time}}">
                                        <x-slot name="appendSlot">
                                            <div class="input-group-text bg-gradient-info">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                        </x-slot>
                                    </x-adminlte-input-date>
                                </div>
                            </div>

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
                            <x-adminlte-text-editor name="description" label="Task details" igroup-size="md"
                                                    :config="$config">
                                {{$description}}
                            </x-adminlte-text-editor>

                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="text-center card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- general form elements -->

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

