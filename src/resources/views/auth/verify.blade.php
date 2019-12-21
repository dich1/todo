@extends('layouts.app')

@section('content')
<main class="sec mainpage-form-main" id="signup_complete">
  <div class="wrap600">
    <div class="mainpage-form form">
      <h2>{{ __('message.verify.title') }}</h2>
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('message.verify.new_url') }}
            </div>
        @endif
      <div class="form-wrap">
        <form class="" action="index.html" method="post">
          <p class="signup_complete-txt">{{ __('message.verify.send_action_url') }}
                  @lang('message.verify.not_email', ['url' => route('verification.resend')])
          </p>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection
