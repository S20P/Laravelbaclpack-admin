
@extends('layouts.master',['title' => 'Supplier Login'])
@section('content')
<div class="supplier-login">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>Suppliers Login</h2>
        <form method="POST" class="supplierprofilelogin" name="supplierprofilelogin" aria-label="{{ __('Login') }}">
          @csrf
          <input type="hidden" name="profile_type" value="supplier">
          <div class='form-row row'>
            <div class='col-sm-12 form-group card-new required'>
              <label class='control-label'>Your Email Address</label>
              <input type="text" id="supplier_email" class="supplier_email" name="email">
            </div>
          </div>
          <div class='form-row row'>
            <div class='col-sm-12 form-group card-new required'>
              <label class='control-label'>Your Password</label> 
              <input type="password" id="supplier_password" class="supplier_password" name="password">
            </div>
          </div>
          <div class="error_login_supplier"></div>
          <div class="form-row">
            <div class="col-sm-12 form-group text-center">
              <button class="btn btn-sign-up submit-button" type="submit"><span>Login</span></button>
            </div>
          </div>
        </form>
        <div class="forgot_password text-center"> <a class="forgot_pwd" href="{{ route('password.reset','supplier') }}">Forgot Your Password?</a></div>
      </div>
    </div>
  </div>
  </div>

@endsection

