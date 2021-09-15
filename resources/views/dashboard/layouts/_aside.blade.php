<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{auth()->user()->image_path}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{auth()->user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> @lang('site.statue')</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">

            <li><a href="{{ route('dashboard.home') }}"><i
                        class="fa fa-th"></i><span>@lang('site.dashboard')</span></a>
            </li>

            @if (auth()->user()->hasPermission('read-users'))
            <li><a href="{{ route('dashboard.users.index') }}"><i
                        class="fa fa-list"></i><span>@lang('site.users')</span></a></li>
            @endif

            @if (auth()->user()->can('read-roles'))
            <li><a href="{{ route('dashboard.roles.index') }}"><i
                 class="fa fa-list"></i><span>@lang('site.roles')</span></a></li>
             @endif

            @if (auth()->user()->hasPermission('read-categories'))
            <li><a href="{{ route('dashboard.categories.index') }}"><i
                        class="fa fa-list"></i><span>@lang('site.categories')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('read-countries'))
            <li>
                <a href="{{ route('dashboard.countries.index') }}"><i
                        class="fa fa-list"></i><span>@lang('site.countries')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('read-classrooms'))
            <li>
                <a href="{{ route('dashboard.classrooms.index') }}"><i
                        class="fa fa-list"></i><span>@lang('site.classrooms')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('read-subjects'))
            <li>
                <a href="{{ route('dashboard.subjects.index') }}"><i
                        class="fa fa-list"></i><span>@lang('site.subjects')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('read-terms'))
            <li>
                <a href="{{ route('dashboard.terms.index') }}"><i
                        class="fa fa-list"></i><span>@lang('site.terms')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('read-teachers'))
            <li>
                <a href="{{ route('dashboard.teachers.index') }}"><i
                        class="fa fa-list"></i><span>@lang('site.teachers')</span></a></li>
            @endif
            @if (auth()->user()->hasPermission('read-students'))
            <li>
                <a href="{{ route('dashboard.students.index') }}"><i
                        class="fa fa-list"></i><span>@lang('site.students')</span></a></li>
            @endif

            
            {{--<li><a href="{{ route('dashboard.categories.index') }}"><i
                class="fa fa-book"></i><span>@lang('site.categories')</span></a></li>--}}
            {{----}}
            {{----}}
            {{--<li><a href="{{ route('dashboard.users.index') }}"><i
                class="fa fa-users"></i><span>@lang('site.users')</span></a></li>--}}

            {{--<li class="treeview">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-pie-chart"></i>--}}
            {{--<span>الخرائط</span>--}}
            {{--<span class="pull-right-container">--}}
            {{--<i class="fa fa-angle-left pull-right"></i>--}}
            {{--</span>--}}
            {{--</a>--}}
            {{--<ul class="treeview-menu">--}}
            {{--<li>--}}
            {{--<a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a>--}}
            {{--</li>--}}
            {{--<li>--}}
            {{--<a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a>--}}
            {{--</li>--}}
            {{--<li>--}}
            {{--<a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a>--}}
            {{--</li>--}}
            {{--<li>--}}
            {{--<a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</li>--}}
        </ul>

    </section>

</aside>
