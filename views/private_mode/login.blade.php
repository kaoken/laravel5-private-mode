@extends('private_mode.layouts.app')

@section('title')
  Private mode
@endsection

@section('content')
  <div class="col-sm-offset-2 col-md-offset-3 col-xs-12 col-sm-8 col-md-6" style="margin-top:96px">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h5 class="modal-title">Please enter your password.</h5>
      </div>
      <div class="panel-body">
        <form class="form-signin" action="{{url('')}}" method="POST">
          {{csrf_field()}}
          <div class="col-xs-12 form-group">
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
            @if (count($errors)>0)
              <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                @foreach($errors as $val)
                  {{$val}}<br />
                @endforeach
              </div>
            @endif
          </div>
          <div class="col-xs-12">
            <button class="btn btn-primary pull-right" type="submit">Sign in</button>
          </div>
        </form><!-- /form -->
      </div>
    </div>
  </div>
@endsection
