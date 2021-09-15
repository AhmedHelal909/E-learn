{{ csrf_field() }}

@foreach (config('translatable.locales') as $index => $locale)
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('site.' . $locale . '.name')</label>
            <input type="text" class="form-control @error($locale . ' .name') is-invalid
        @enderror " name=" {{ $locale }}[name]"
                value="{{ isset($row) ? $row->translate($locale)->name : old($locale . '.name') }}">

            @error($locale . '.name')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>
@endforeach
<div class="col-md-12">
<div class="form-group">
    <label for="exampleFormControlSelect1">Country</label>
    <select class="form-control" id="exampleFormControlSelect1" name="country_id">
        @foreach ( App\Models\Country::get() as $country)
          
        <option value="{{$country->id}}" >
            {{$country->name}}
        </option>
        @endforeach
     
    </select>
  </div>

</div>


