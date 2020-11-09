<ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <li>
          <a href="{{url('/home')}}" style="font-weight: 500;">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          </a>
        </li>
        
        @if(in_array(Auth::user()['role_id'],role_admin()))
        
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Master</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/pengumuman')}}">&nbsp;&nbsp; <i class="fa fa-minus"></i> Pengumuman</a></li>
                <li><a href="{{url('/tagihan')}}">&nbsp;&nbsp; <i class="fa fa-minus"></i> Tagihan</a></li>
                <li><a href="{{url('/user/akses')}}">&nbsp;&nbsp; <i class="fa fa-minus"></i> Role Akses</a></li>
              </ul>
          </li>
          
          <li class="treeview">
            <a href="#" style="background:#f9fafc;font-weight: 500;">
              <i class="fa fa-folder"></i>
              <span>User BTTD</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="background:#f3f6fb">
              <li><a href="{{url('/user?role=3')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Supervisor</a></li>
              <li><a href="{{url('/user?role=2')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Officer</a></li>
              <li><a href="{{url('/user?role=4')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Manager</a></li>
              <li><a href="{{url('/user?role=1')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Loket</a></li>
              <li><a href="{{url('/user?role=5')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Vendor</a></li>
              
            </ul>
          </li>
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Vendor</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/vendor')}}">&nbsp;&nbsp; <i class="fa fa-minus"></i>Daftar Vendor</a></li>
              </ul>
          </li>
        @endif


        
        @if(in_array(Auth::user()['role_id'],role_vendor()))
        <li class="treeview">
            <a href="#" style="background:#f9fafc;font-weight: 500;">
              <i class="fa fa-folder"></i>
              <span>Buat BTTD</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="background:#f3f6fb">
              <li><a href="{{url('/bttd')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Faktur</a></li>
              <li><a href="{{url('/bttd/non_faktur')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Non Faktur</a></li>
              
            </ul>
        </li>
        @endif

        @if(in_array(Auth::user()['role_id'],role_loket()) || in_array(Auth::user()['role_id'],role_officer()) || in_array(Auth::user()['role_id'],role_spv()))
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Daftar BTTD</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/bttd')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Proses</a></li>
                <li><a href="{{url('/bttd/terima')}}">&nbsp;&nbsp; <i class="fa fa-user"></i> Diterima</a></li>
                
              </ul>
          </li>
          <li class="treeview">
              <a href="#" style="background:#f9fafc;font-weight: 500;">
                <i class="fa fa-folder"></i>
                <span>Bukti Potong</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu" style="background:#f3f6fb">
                <li><a href="{{url('/bukti')}}">&nbsp;&nbsp; <i class="fa fa-minus"></i> PPH</a></li>
                <li><a href="{{url('/bukti/ppn')}}">&nbsp;&nbsp; <i class="fa fa-minus"></i> PPN</a></li>
                
              </ul>
          </li>
          
        @endif 

        

       
        <!-- <li>
          <a href="{{url('/admin/news/')}}">
            <i class="fa fa-th"></i> <span>Rekapitulasi</span>
          </a>
        </li> -->
        <?php
          $kodebar=Auth::user()['nik'].'-'.Auth::user()['name'];
        ?>
        <li class="header" style="background: #ffffff;padding: 10%;"><center>{!!barcoderider($kodebar,3,3)!!} <br>{{Auth::user()['nik']}}<br>{{substr(Auth::user()['name'],0,22)}}<br>{{substr(Auth::user()['name'],23,50)}}</center></li>
      </ul>