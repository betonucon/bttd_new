<ul class="nav navbar-nav">
   
    
    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{url('/icon/akun.png')}}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{Auth::user()['name']}}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="user-header">
            <img src="{{url('/icon/akun.png')}}" class="img-circle" alt="User Image">

            <p>
                {{Auth::user()['name']}}
                <small>{{Auth::user()['nik']}}</small>
            </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
           
            <!-- /.row -->
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
            <div class="pull-left">
                
            </div>
            <div class="pull-left">
                
                  <input type="submit" onclick="pengaturan()" class="btn btn-default btn-flat" value="Pengaturan">
                
            </div>
            <div class="pull-right">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" class="btn btn-default btn-flat" value="Sign out">
                    </form>
            </div>
            </li>
        </ul>
    </li>
    <!-- Control Sidebar Toggle Button -->
    <li>
    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
    </li>
</ul>