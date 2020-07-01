<div class="row">
    <div class="col-md-12">
        <div class="">
             <div class="">
                <div class="">
                    <form method="POST" action="{{ route('supplier.profile') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="account-input">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ old('name',$user_details->name ) }}"
                                        class="@error('name') is-invalid @enderror">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Service name</label>
                                    <input type="text" name="service_name"
                                        value="{{ old('service_name',$user_details->service_name) }}"
                                        class=" @error('service_name') is-invalid @enderror">

                                    @error('service_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Business name</label>
                                    <input type="text" name="business_name"
                                        value="{{ old('business_name',$user_details->business_name) }}"
                                        class="  @error('business_name') is-invalid @enderror">
                                    @error('business_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Category</label>

                                    <select name="category" class="@error('category') is-invalid @enderror">
                                        <option>Select Category</option>
                                        @foreach($Category as $item)
                                        <option value="{{$item}}"
                                            {{(isset($user_details) && $user_details->category == $item) ? 'Selected':'' }}>
                                            {{$item}}</option>
                                        @endforeach
                                    </select>

                                </div>


                                <div class="form-group col-sm-6">
                                    <label>Service description</label>
                                    <textarea name="service_description"
                                        class=" @error('service_description') is-invalid @enderror">{{ old('service_description',$user_details->service_description) }}</textarea>

                                    @error('service_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>Event type</label>
                                    <input type="text" name="event_type"
                                        value="{{ old('event_type',$user_details->event_type) }}"
                                        class="  @error('event_type') is-invalid @enderror">
                                    @error('event_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <!-- load the view from type and view_namespace attribute if set -->
                                <!-- text input -->
                                <div class="form-group col-sm-6">
                                    <label>Location</label>
                                    <input type="text" name="location"
                                        value="{{ old('location',$user_details->location) }}"
                                        class="  @error('location') is-invalid @enderror">
                                    @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12">
                                    <button class="btn common-btn" type="submit">
                                        <span><img src="{{ asset('images/search-icon.svg') }}"></span> EDIT
                                    </button>
                                </div>
                            </div>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>