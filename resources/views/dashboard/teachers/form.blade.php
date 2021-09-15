{{ csrf_field() }}


<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">Name</label>
        <input type="text" class="form-control" id="name" placeholder="name" name="name" @error('name') is-invalid @enderror"  value="{{ isset($row) ? $row->name : old('name') }}">
        @error('name')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
    @enderror
        
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="email">email</label>
        <input type="email" class="form-control" id="email" placeholder="email" name="email"@error('email') is-invalid @enderror" value="{{ isset($row) ? $row->email : old('email') }}">
        @error('email')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
        
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="password">password</label>
        <input type="password" class="form-control" id="password" placeholder="password" name="password"@error('password') is-invalid @enderror">
        @error('password')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="password">password_confirmation</label>
        <input type="password" class="form-control" id="password_confirmation" placeholder="password_confirmation" name="password_confirmation" @error('email') is-invalid @enderror">
        @error('password_confirmation')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">Country</label>
        <select class="form-control" id="exampleFormControlSelect1" name="country_id">
           
            @foreach ( App\Models\Country::get() as $country)
             <option {{ (isset($row) && $row->country_id == $country->id) ? 'selected style=color:red ': '' }} value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
         
        </select>
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">Subject</label>
        <select class="form-control" id="exampleFormControlSelect1" name="subject_id">
            @foreach ( App\Models\Subject::get() as $subject)
              
            <option {{ (isset($row) && $row->subject_id == $subject->id) ? 'selected style=color:red ': '' }} value="{{$subject->id}}">{{$subject->name}}</option>

            @endforeach
         
        </select>
      </div>
    
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="exampleFormControlSelect1">Device_serial</label>
        <input type="text" class="form-control" id="device_serial" placeholder="device_serial" name="device_serial" value="{{ isset($row) ? $row->device_serial : old('device_serial') }}" >

        
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">start_trial_date</label>
        <input class="form-control" name="start_trial_date" placeholder="YYYY-MM-DD"
            type="date" value="{{ isset($row) ? $row->start_trial_date : old('start_trial_date') }}" required @error('start_trial_date') is-invalid @enderror">
            @error('start_trial_date')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
        
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">end_trial_date</label>
        <input class="form-control" name="end_trial_date" placeholder="YYYY-MM-DD"
            type="date" value="{{ isset($row) ? $row->end_trial_date : old('end_trial_date') }}" required @error('end_trial_date') is-invalid @enderror">
            @error('end_trial_date')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
            @enderror
        
      </div>
    
</div>
<div class="col-md-12">
    <div class="form-group">
        <label for="exampleFormControlSelect1">Note</label>
        <input type="text" class="form-control" id="note" placeholder="note" name="note" value="{{ isset($row) ? $row->note : old('note') }}">

        
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">start_paid_date</label>
        <input class="form-control" name="start_paid_date" placeholder="YYYY-MM-DD"
            type="date" value="{{ isset($row) ? $row->start_paid_date : old('start_paid_date') }}" required  @error('start_paid_date') is-invalid @enderror">
            @error('start_paid_date')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
            @enderror
        
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">end_paid_date</label>
        <input class="form-control" name="end_paid_date" placeholder="YYYY-MM-DD"
            type="date" value="{{ isset($row) ? $row->end_paid_date : old('end_paid_date') }}" required @error('end_paid_date') is-invalid @enderror">
            @error('start_paid_date')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
            @enderror
        
        
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">Block</label>
        <select class="form-control" id="exampleFormControlSelect1" name="block">
              
            <option {{ (isset($row) && $row->block == "yes") ? 'selected style=color:red ': '' }} value="yes" >
                yes
            </option>
            <option {{ (isset($row) && $row->block == "no") ? 'selected style=color:red ': '' }} value="no" >
                no
            </option>
            
           
         
        </select>
      </div>
    
</div>
<div class="col-md-6">
    <div class="form-group">
        <label for="exampleFormControlSelect1">Pay</label>
        <select class="form-control" id="exampleFormControlSelect1" name="paid">
              
            <option {{ (isset($row) && $row->paid == "yes") ? 'selected style=color:red ': '' }} value="yes" >
                yes
            </option>
            <option {{ (isset($row) && $row->paid == "no") ? 'selected style=color:red ': '' }} value="no" >
                no
            </option>
           
         
        </select>
      </div>
    
</div>