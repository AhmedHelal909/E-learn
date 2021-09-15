@extends('dashboard.layouts.app')

@section('title', __('site.'.$module_name_plural))


@section('content')

<div class="content-wrapper">

    <section class="content-header">

        <h1>@lang('site.'.$module_name_plural)</h1>

        <ol class="breadcrumb">
            <li> <a href="{{ route('dashboard.home') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
            </li>
            <li class="active"><i class="fa fa-category"></i> @lang('site.'.$module_name_plural)</li>
        </ol>
    </section>

    <section class="content">
        <div class="col-md-4">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>
                @lang('site.search')</button>
            <a href="{{route('dashboard.'.$module_name_plural.'.create')}}" class="btn btn-primary"><i
                    class="fa fa-plus"></i> @lang('site.add')</a>

        </div>
        <div class="box-body">
           
            @if ($rows->count() > 0)

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('site.name')</th>
                            <th>@lang('site.image')</th>
                            <th>@lang('site.action')</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($rows as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{$row->name}}</td>
                                <td><img src="{{asset('uploads/countries_images/'.$row->flag)}}" style="width:100px" class="img-thumbnail imagepreview" alt=""></td>
                                {{-- <td>{{ $row->roles[0]->name }}</td> --}}
                                <td>
                                    @if (auth()->user()->hasPermission('update-'.$module_name_plural))
                                        @include('dashboard.buttons.edit')
                                    @else
                                        <input type="submit" value="edit" disabled>
                                    @endif

                                    @if (auth()->user()->hasPermission('delete-'.$module_name_plural))
                                    @include('dashboard.buttons.delete')
                                @else
                                    <input type="submit" value="delete" disabled>
                                @endif

                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table> {{-- end of table --}}

                {{ $rows->appends(request()->query())->links() }}

            @else
                <tr>
                    <h4>@lang('site.no_records')</h4>
                </tr>
            @endif

        </div> {{-- end of box body --}}
      

    </section><!-- end of content -->

</div><!-- end of content wrapper -->

@endsection
