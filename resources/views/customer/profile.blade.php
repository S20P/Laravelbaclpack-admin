
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" name="customer_profile_form" id="customer_profile_form"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
<!--                         <div class="profile-tab form-group col-sm-12">
                            <img src="{{isset($user_details->image)?url($user_details->image) : ''}}" alt=""  width="100" height="100">
                            <label>Profile Picture</label>
                            <input type="file" name="image"   class="file-upload @error('image') is-invalid @enderror file-upload">
                            @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div> -->
                        <div class="form-group col-sm-6">
                         <label>Name</label>
                                <input type="text" name="name" value="{{ old('name',$user_details->name ) }}"  class=" @error('name') is-invalid @enderror change_name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                           <!-- text input -->
                        <div class="form-group col-sm-6">
                        <label>Email</label>
                                <input id="email" type="email" class="@error('email') is-invalid @enderror change_email" name="email" value="{{ old('email',$user_details->email) }}" autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>    <!-- load the view from type and view_namespace attribute if set -->
                        <div class="form-group col-sm-6">
                            <label>Phone</label>
                                <input type="number" min="0" name="phone" value="{{ old('phone',$user_details->phone) }}" class=" @error('phone') is-invalid @enderror change_phone">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                       </div>
                            <!-- load the view from type and view_namespace attribute if set -->
                        <div class="form-group col-md-12">
                            <div class="text-center">
                                <button type="submit" class="common-btn">
                                   Save
                                </button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




    