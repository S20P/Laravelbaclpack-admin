  <div class="container">
        <div class="login-from">
            <div class="login-form-content">
                <div class="close-icon menu-close">
                        <i class="fal fa-times"></i>                
                </div>
            <div class="custom-filed-login">
            <div class="success_login_alert"></div>
            <form method="POST"  class="profilelogin" name="profilelogin" aria-label="{{ __('Login') }}">
            @csrf
            <h2>login</h2>
            <div class="form-group">
            <input type="text" id="email" name="email" class="email"  placeholder="Your Email Address">
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" class="password"  placeholder="Your Password">
            </div>
            <input type="hidden" name="profile_type" value="customer">
            <div class="error_login_main"></div>
                           <!--  <div class="form-group supplier-btm">
                                <select class="location" name="profile_type">
                                
                                    <option value="supplier" selected>Supplier</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div> -->
            <button type="submit" class="btn custom-button">login</button>
            </form>
            <br>
                <div class="forgott">
                <!--  <p> <a href="{{ route('password.reset','supplier') }}">Forgot Your supplier Profile Password?</a></p>
                   <p> or</p> -->
                     <p> <a href="{{ route('password.reset','customer') }}">Forgot Your customer Profile Password?</a></p>
                </div>
                <div class="error_login_facebook"></div>
                <div class="google_login">
                    <div id="gSignInWrapper">
                        <div id="customBtn" class="customGPlusSignIn">
                          <!--   <img src="{{asset('images/gmail2.png')}}"  /> -->
                          <div class="login-button">
                              <span class="google-img"></span>
                              Sign in with Google
                          </div>
                          
                        </div>
                    </div>
                    <div id="name"></div>
                    <!-- <div class="g-signin2 google_sign-in" data-onsuccess="onSignIn"  data-theme="dark"></div> -->
                 </div>

                 <div class="facebook_login">
                    <a href="javascript:void(0);" onclick="fbLogin()" id="fbLink"><i class="fab fa-facebook-square"></i> Continue with facebook</a>
                </div>

            </div>
        </div>
        <div class="offcanvas-overly"></div>
        </div>
        <div class="sign-up-from">
            <div class="signup-form-content">
                <div class="close-icon menu-close">
                        <i class="fal fa-times"></i>              
                </div>
                <div class="custom-filed-login">
                <div class="success_signup_main"></div>
                <form method="POST"  aria-label="register" name="registration">
                    @csrf
                    <h2>Sign up</h2>
                    <div class="form-group">
                            <input type="hidden" value="customer" name="profile_type"  id="profile_type_check" disabled>
{{--                         <select class="location" name="profile_type" id="profile_type_check">--}}
{{--                                <!-- <option>Select Profile Type</option> -->--}}
{{--                            <option value="supplier" selected>Supplier</option>--}}
{{--                            <option value="customer">Customer</option>--}}
{{--                         </select>--}}
                         </div>
                         <div class="form-group">
                                <input id="name" type="text" class="@error('name') is-invalid @enderror cus_name" name="name" placeholder="Your Name"  required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                                <input id="profileemail" type="email" class="@error('email') is-invalid @enderror cus_email" name="email" placeholder="Your Email Address" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           </div>
                        <div class="form-group">
                                <input id="profilepassword" type="password" class="@error('password') is-invalid @enderror cus_pass" name="password" placeholder="Your Password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                                    <input id="password-confirm" type="password" class="cus_con_pass" name="password_confirmation" placeholder="Your Confirm Password" required autocomplete="new-password">
                        </div>
                    <input id="remember_customer" class="custom-checkbox cus_agree" type="checkbox">
                    <label for="remember_customer" class="custom-checkbox-label">I agree to Terms & Conditions</label>
                    <button type="submit" id="customer_signup_submit" disabled="disabled" class="btn custom-button disabled">SIGN UP</button>
                 </form>
                </div>
            </div>
            <div class="offcanvas-overly"></div>
        </div>
    </div>
