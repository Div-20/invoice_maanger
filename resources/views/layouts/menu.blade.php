@php
    $url_segment = App\Helpers\SiteConstants::URL_PREFIX_ADMIN_WEB;
    $aUser = Auth::user();
    $aUser::$get_media_url = true;
@endphp


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    {{-- <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/mgumst-logo.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">MGUMST </a>
            </div>
            <div class="info text-white">
                <div class="pull-right">
                </div>
            </div>
        </div>

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            @if ($aUser->image)
            <img src="{{$aUser->image}}" class="img-circle elevation-2" alt="User Image">
            @else
            {{-- <img src="{{asset(env('PROFILE_IMG_URL'))}}" class="img-circle elevation-2" alt="User Image"> --}}
            <img src="{{ asset('images/mgumst-logo.png') }}" class="img-circle elevation-2" alt="User Image">
            @endif
          </div>
          <div class="info clearfix w-100">
            <a href="" class="d-block float-left">{{$aUser->name}}</a>
            {!! Form::open(['route' => 'logout']) !!}
                <button type='submit' class="btn btn-primary float-right">
                  <span class="badge badge-danger "><i class="fas fa-arrow-right fa-fw"></i></span>
                </button>
            {!! Form::close() !!}
          </div>
        </div>


        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                @if(Auth::user()->role==2)

                    <li class="nav-item">
                        <a href="{{ route('user.assets.index')}}" class="nav-link {{(Request::is(['assets'])||Request::is(['asset/*'])? 'active' : '' )}}">
                            <i class="nav-icon fa fa-wrench"></i><p>Manage Assets</p>
                        </a>
                    </li>


                 @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
