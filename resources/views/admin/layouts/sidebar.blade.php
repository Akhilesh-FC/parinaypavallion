<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand d-flex align-items-center px-3">
    <a href="{{ route('admin.dashboard') }}"
       class="d-flex align-items-center text-decoration-none w-100">

        {{-- LOGO --}}
        <img
            src="{{ asset('assets/img/parinay.png') }}"
            alt="Parinay"
            class="me-2"
            style="width:32px; height:32px; object-fit:contain;"
        />

        {{-- BRAND NAME --}}
        <span
            class="fw-bold text-dark"
            style="
                font-size:14px;
                line-height:1.2;
                white-space:nowrap;
                overflow:hidden;
                text-overflow:ellipsis;
                max-width:140px;
            "
        >
            Parinay Pavallion
        </span>
    </a>
</div>

    
    @php
    $user = session('admin_user');
    
    @endphp
   
    <ul class="sidebar-menu">
     
      <li class="menu-header text-danger">Users Details</li>
      <li class="dropdown ">
        <a href="{{route('admin.dashboard')}}" class="nav-link"><i class="fas fa-tachometer-alt text-info"></i><span>Dashboard</span></a>
      </li>
      
      <li class="menu-header text-danger">Users Details</li>
      <li><a class="nav-link" href="{{route('users.list')}}"><i class="fas fa-users text-success"></i><span>All Users</span></a></li>
      <li><a class="nav-link" href="#"><i class="fas fa-user-slash text-danger"></i><span>Inactive Users</span></a></li>
      <!--<li><a href="#" class="nav-link"><i class="fas fa-plus"></i><span>Add Vendor</span></a></li>-->
      <!--<li><a href="#" class="nav-link"><i class="fas fa-file"></i><span>To Vendor Payment</span></a></li>-->
      
      
      <li class="menu-header text-danger">Booking Details</li>
      <li><a class="nav-link" href="{{ route('bookings') }}"><i class="fas fa-calendar-check"></i><span>All Bookings</span></a></li>
      <li><a class="nav-link" href="#"><i class="fas fa-dice text-primary"style="color: #4e73df !important;"></i><span>Pending Approval</span></a></li>
      
      
      
      
      
      <li class="menu-header text-danger">Properties Details</li>
     <li><a class="nav-link" href="{{ route('properties.halls') }}"><i class="fas fa-building me-2" style="color:#4e73df;"></i><span>Halls</span></a></li>
     <li><a class="nav-link" href="{{ route('properties.lawns') }}"><i class="fas fa-tree me-2 text-success"></i><span>Lawns</span></a></li>
     <li><a class="nav-link" href="{{ route('properties.rooms') }}"><i class="fas fa-door-open me-2 text-warning"></i><span>Rooms</span></a></li>
     <li><a class="nav-link" href="{{ route('gallery') }}"><i class="fas fa-images me-2 text-info"></i><span>Gallery</span></a></li>
     <li><a class="nav-link" href="{{ route('property.ratings') }}"><i class="fas fa-star me-2 text-warning"></i><span>Property Ratings</span></a></li>




    <li class="menu-header text-danger">Contact Messages</li>
    <li><a class="nav-link" href="{{ route('contact.messages') }}"><i class="fas fa-envelope me-2" style="color:#4e73df;font-size:16px;"></i><span>Contact Messages</span></a></li>


      
      
      <li class="menu-header text-danger">Payment Details</li>
          <li><a class="nav-link" href="{{ route('payments.index') }}"><i class="fas fa-wallet text-success"></i><span>Payin</span></a></li>
          <!--<li><a class="nav-link" href="#"><i class="fas fa-money-bill-wave text-danger"></i><span>Withdrawal</span></a></li>-->
          <!--<li><a class="nav-link" href="#"> <i class="fas fa-gamepad" style="color: #4e73df !important;"></i><span>Transaction Limit</span></a></li>-->
	  <li>
       <a class="nav-link" href="{{ route('user.bank.details') }}"><i class="fa-solid fa-user"></i>   ✅<span>User Bank Details</span></a>
    </li>
	
		
    <li class="menu-header text-danger">Other Details</li>		
        <li><a class="nav-link" href="{{route('sliders')}}"><i class="fas fa-images text-info"></i><span>Sliders</span></a></li>
        <li><a class="nav-link" href="{{ route('contact_details') }}"><i class="fas fa-life-ring text-danger"></i><span>Contact Details </span></a></li>
        <li><a class="nav-link" href="#"><i class="fas fa-pen text-danger"></i><span>Notification</span></a></li>
        <li><a class="nav-link" href="{{ route('social.links') }}"><i class="fas fa-link me-2" style="color:#4e73df;"></i><span>Social Links</span></a></li>
        
        <li><a class="nav-link" href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt me-2 text-danger"></i><span>Logout</span></a></li>

  
    </ul>
    </aside>
  
<style>
    #sidebar-wrapper {
        max-height: 100vh;
        overflow-y: auto;
        scroll-behavior: smooth;
    }

    .active-sidebar-link {
        background-color: #e0f3ff !important;
        color: red !important;
        font-weight: bold;
        border-left: 3px solid #fc554c;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar-wrapper');
        if (!sidebar) return;

        const scrollPos = sessionStorage.getItem('sidebar-scroll');
        if (scrollPos !== null) {
            sidebar.scrollTop = parseInt(scrollPos, 10);
        }

        sidebar.addEventListener('scroll', function () {
            sessionStorage.setItem('sidebar-scroll', sidebar.scrollTop);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const currentUrl = window.location.origin + window.location.pathname;

        document.querySelectorAll('.sidebar-menu a.nav-link').forEach(link => {
            if (link.href === currentUrl) {
                link.classList.add('active-sidebar-link');

                const icon = link.querySelector('i');
                if (icon) {
                    icon.style.color = '#007bff';
                }
            }
        });
    });
</script>



</div>
