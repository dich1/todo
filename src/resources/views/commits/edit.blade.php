@extends('layout')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
@endsection
@section('header')
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-edit"></i> Commits / Edit #{{$commit->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('commits.update', $commit->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('user_id')) has-error @endif">
                       <label for="user_id-field">User_id</label>
                    <input type="text" id="user_id-field" name="user_id" class="form-control" value="{{ is_null(old("user_id")) ? $commit->user_id : old("user_id") }}"/>
                       @if($errors->has("user_id"))
                        <span class="help-block">{{ $errors->first("user_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('group_id')) has-error @endif">
                       <label for="group_id-field">Group_id</label>
                    <input type="text" id="group_id-field" name="group_id" class="form-control" value="{{ is_null(old("group_id")) ? $commit->group_id : old("group_id") }}"/>
                       @if($errors->has("group_id"))
                        <span class="help-block">{{ $errors->first("group_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('limit')) has-error @endif">
                       <label for="limit-field">Limit</label>
                    <input type="text" id="limit-field" name="limit" class="form-control date-picker" value="{{ is_null(old("limit")) ? $commit->limit : old("limit") }}"/>
                       @if($errors->has("limit"))
                        <span class="help-block">{{ $errors->first("limit") }}</span>
                       @endif
                    </div>
                    <label for="content-field">Content</label>
                    @foreach($commit->commitGroups as $key => $commitGroup)
                        <div class="form-group @if($errors->has('status')) has-error @endif">
                        <input type="text" id="status-field-{{ $key }}" name="status[{{ $key }}]" class="form-control" value="{{ is_null(old("status")) ? $commitGroup->status : old("status") }}"/>
                           @if($errors->has("status"))
                            <span class="help-block">{{ $errors->first("status") }}</span>
                           @endif
                        </div>
                        <div class="form-group @if($errors->has('priority')) has-error @endif">
                        <input type="text" id="priority-field-{{ $key }}" name="priority[{{ $key }}]" class="form-control" value="{{ is_null(old("priority")) ? $commitGroup->priority : old("priority") }}"/>
                           @if($errors->has("priority"))
                            <span class="help-block">{{ $errors->first("priority") }}</span>
                           @endif
                        </div>
                        <div class="form-group @if($errors->has('content')) has-error @endif">
                        <input type="text" id="content-field-{{ $key }}" name="content[]" class="form-control" value="{{ is_null(old("content")) ? $commitGroup->content : old("content") }}"/>
                           @if($errors->has("content"))
                            <span class="help-block">{{ $errors->first("content") }}</span>
                           @endif
                        </div>
                    @endforeach
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-link pull-right" href="{{ route('commits.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
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
