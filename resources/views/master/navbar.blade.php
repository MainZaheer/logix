 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
             <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
         </li>

     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- Navbar Search -->
         <li class="nav-item">
             <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                 <i class="fas fa-search"></i>
             </a>
             <div class="navbar-search-block">
                 <form class="form-inline">
                     <div class="input-group input-group-sm">
                         <input class="form-control form-control-navbar" type="search" placeholder="Search"
                             aria-label="Search">
                         <div class="input-group-append">
                             <button class="btn btn-navbar" type="submit">
                                 <i class="fas fa-search"></i>
                             </button>
                             <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                 <i class="fas fa-times"></i>
                             </button>
                         </div>
                     </div>
                 </form>
             </div>
         </li>


         <!-- Notifications Dropdown Menu -->

         <li class="nav-item">
             <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                 <i class="fas fa-expand-arrows-alt"></i>
             </a>
         </li>

         <li class="dropdown">
             <a href="javascript:void(0)" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true"
                 style="padding: 8px 0px 0px 0px !important; color: #333333 !important; ">
                 <span class="user-name">{{ auth()->user()->name }}</span>
                 <span class="avatar">
                     <img src="{{ asset('admin/dist/img/avatar.png') }}" alt="avatar"
                         style="position: relative;margin: 0; width: 40px; height: 40px; border-radius: 50%;">
                     <span class="status busy"
                     style="    position: absolute;
                                top: -3px;
                                right: -3px;
                                width: 15px;
                                height: 15px;
                                -webkit-border-radius: 10px;
                                -moz-border-radius: 10px;
                                border-radius: 10px;
                                border: 3px solid #ffffff;
                                background :red">
    </span>
                 </span>
             </a>

         </li>

     </ul>
 </nav>
