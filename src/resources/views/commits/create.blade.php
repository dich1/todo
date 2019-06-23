@extends('layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-plus"></i> Commits / Create </h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('commits.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('user_id')) has-error @endif">
                       <label for="user_id-field">User_id</label>
                    <input type="text" id="user_id-field" name="user_id" class="form-control" value="{{ old("user_id") }}"/>
                       @if($errors->has("user_id"))
                        <span class="help-block">{{ $errors->first("user_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('group_id')) has-error @endif">
                       <label for="group_id-field">Group_id</label>
                    <input type="text" id="group_id-field" name="group_id" class="form-control" value="{{ old("group_id") }}"/>
                       @if($errors->has("group_id"))
                        <span class="help-block">{{ $errors->first("group_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('limit')) has-error @endif">
                       <label for="limit-field">Limit</label>
                    <input type="text" id="limit-field" name="limit" class="form-control date-picker" value="{{ old("limit") }}"/>
                       @if($errors->has("limit"))
                        <span class="help-block">{{ $errors->first("limit") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a class="btn btn-link pull-right" href="{{ route('commits.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                </div>
            </form>

        </div>
    </div>
@endsection
@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
  <script>
    $('.date-picker').datepicker({
        format: 'yyyy/mm/dd'
    });
  </script>
@endsection
