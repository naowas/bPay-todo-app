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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">You are logged in!</p>
                </div>
            </div>
        </div>
    </div>
@stop
