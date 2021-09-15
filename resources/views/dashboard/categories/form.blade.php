{{ csrf_field() }}

@foreach (config('translatable.locales') as $index => $locale)
    <div class="col-md-12">
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
@foreach (config('translatable.locales') as $locale)
    <div class="col-md-12">
        <div class="form-group">
            <label>@lang('site.' . $locale . '.description')</label>
            <textarea  class="form-control ckeditor  @error($locale . ' .description') is-invalid  @enderror " name=" {{ $locale }}[description]" cols="30" rows="10">{{ isset($row) ? $row->translate($locale)->description : old($locale . '.description') }}</textarea>
            @error($locale .'.description')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>
@endforeach

<div class="col-md-6">
    <div class="form-group bmd-form-group">
        <label class="bmd-label-floating">@lang('site.parent')</label>

        <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
            <option value="">@lang('site.no_parent')</option>
            @foreach(App\Models\Category::whereNull('parent_id')->get() as $parent)
                {{-- skip current category --}}
                @if(isset($row) && $row->id == $parent->id)
                    @continue
                @endif
                <option value="{{$parent->id}}" {{isset($row) && $row->parent_id == $parent->id ? 'selected' : ''}}>{{$parent->name}}</option>
            @endforeach
        </select>
        @error('parent_id')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
        @enderror
    </div>
</div>



<div class="col-md-3">
    <div class="">
        <label>@lang('site.image')</label>
        <input type="file" name="image" class="form-control image @error('image') is-invalid @enderror">
        @error('image')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="form-group col-md-3">
    <img src="{{ isset($row) ? $row->image_path : asset('uploads/category_images/default.png') }}" style="width: 115px;height: 80px;position: relative;
                top: 14px;" class="img-thumbnail image-preview">
</div>
