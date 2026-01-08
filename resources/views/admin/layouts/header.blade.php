<nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
           <li>
    <li class="d-flex align-items-center">
    <h2 class="mt-1 mb-0 text-nowrap">
    <strong>Parinay Pavallion Resort</strong>
</h2>

</li>


          </ul>
        </div>
     <ul class="navbar-nav navbar-right d-flex justify-content-end align-items-center w-100">
        <!--  @php-->
        <!--    $data = DB::table('feedback')-->
        <!--        ->join('users', 'feedback.user_id', '=', 'users.id')-->
        <!--        ->select('feedback.*', 'users.name', 'users.image')-->
        <!--        ->orderBy('feedback.id', 'desc')  // id ko descending order mein sort karo-->
        <!--        ->get();-->
        
        <!--    $feedbackCount = DB::table('feedback')->count();-->
        <!--@endphp-->
    <!-- Notification Dropdown -->
    <li class="dropdown dropdown-list-toggle mx-2">
        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle text-center">
            <i data-feather="bell" class="bell"></i>
            <span class="badge headerBadge1">#</span>
        </a>

        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
            <div class="dropdown-header">
                Messages
                <div class="float-right">
                    <a href="#">Show All Feedback</a>
                </div>
            </div>


            <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
    </li>

    <!-- User Dropdown -->
    <li class="dropdown mx-2">
        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user text-center">
            <img alt="image" src="{{ asset('assets/img/parinay.png') }}" class="user-img-radious-style">
        </a>
        <div class="dropdown-menu dropdown-menu-right pullDown text-center">
            <div class="dropdown-divider"></div>
            <a href="{{route('admin.logout')}}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </li>

</ul>

      </nav>
<style>
  @media (max-width: 768px) {
    .navbar-nav.navbar-right {
        justify-content: flex-end !important;
        width: 100%;
    }
    .nav-link-user img {
        margin-left: auto;
    }
  }
</style>
