@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <div class="row">
        <div class="col-md-4">
            <h5>Todo</h5>
        </div>
        <div class="col-md-8 text-right">
            <div class="pull-right">
                <a href="{{url('/todo/'.$todo->id.'/edit')}}" class="btn btn-warning">Edit <i
                        class="fa fa-edit"></i></a>
                <a href="{{url('/todo/create')}}" class="btn btn-success">New Todo <i class="fa fa-fw fa-plus"></i></a>

            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-text-width"></i>
                        Description
                    </h3>
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-2">Title:</dt>
                        <dd class="col-sm-10">{{$todo->title}}</dd>
                        <dt class="col-sm-2">Date:</dt>
                        <dd class="col-sm-10">{{$todo->date}}</dd>
                        <dt class="col-sm-2">Time:</dt>
                        <dd class="col-sm-10">{{$todo->time}}</dd>
                        <dt class="col-sm-2">Description:</dt>
                        <dd class="col-sm-10">{!! $todo->description !!}</dd>
                        <dt class="col-sm-2">Notification status:</dt>
                        <dd class="col-sm-10">{!! $todo->sending_status !!}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@stop
