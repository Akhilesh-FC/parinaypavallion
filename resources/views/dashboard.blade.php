@extends('admin.layouts.administrator')

@section('title', 'Dashboard')

@section('content')

<style>
 .card-statistic-4 {
    position: relative;
    color: #000;
    padding: 10px;
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 80px;
}

.icon-container {
    font-size: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

/* Different Colors for Each Icon */
.icon-active-users {
    color: #28a745;
    background: rgba(40, 167, 69, 0.1);
}

.icon-inactive-users {
    color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

.icon-total-deposit {
    color: #ffc107;
    background: rgba(255, 193, 7, 0.1);
}

.icon-today-deposit {
    color: #17a2b8;
    background: rgba(23, 162, 184, 0.1);
}

.icon-total-withdrawal {
    color: #6610f2;
    background: rgba(102, 16, 242, 0.1);
}

.icon-today-withdrawal {
    color: #fd7e14;
    background: rgba(253, 126, 20, 0.1);
}

.icon-total-games {
    color: #6c757d;
    background: rgba(108, 117, 125, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .card-statistic-4 {
        min-height: 70px;
        padding: 8px;
    }
    .icon-container {
        font-size: 20px;
        width: 40px;
        height: 40px;
    }
     .card-content{
        text-align: center;
    }
    
}

</style>


<!-- Include FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="row d-flex flex-wrap align-items-stretch">

    {{-- Active Users --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-active-users">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div class="card-content">
                    <h6>Active Users</h6>
                    <h4>{{ $activeUsers }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Inactive Users --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-inactive-users">
                    <i class="fa-solid fa-user-slash"></i>
                </div>
                <div class="card-content">
                    <h6>Inactive Users</h6>
                    <h4>{{ $inactiveUsers ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Bookings --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-bookings">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="card-content">
                    <h6>Total Bookings</h6>
                    <h4>{{ $booking }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Lawns --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-lawns">
                    <i class="fa-solid fa-tree"></i>
                </div>
                <div class="card-content">
                    <h6>Total Lawns</h6>
                    <h4>{{ $lawns }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Halls --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-halls">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <div class="card-content">
                    <h6>Total Halls</h6>
                    <h4>{{ $halls }}</h4>
                </div>
            </div>
        </div>
    </div>
    
     {{-- Total Halls --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-halls">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <div class="card-content">
                    <h6>Total Rooms</h6>
                    <h4>{{ $rooms }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Gallery --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-gallery">
                    <i class="fa-solid fa-image"></i>
                </div>
                <div class="card-content">
                    <h6>Gallery</h6>
                    <h4>{{ $gallery }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Sliders --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-sliders">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <div class="card-content">
                    <h6>Sliders</h6>
                    <h4>{{ $sliders }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Deposit --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-total-deposit">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div class="card-content">
                    <h6>Total Deposit</h6>
                    <h4>₹ {{ number_format($totalDeposit) }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Today Deposit --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <div class="card-statistic-4 d-flex align-items-center">
                <div class="icon-container icon-today-deposit">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div class="card-content">
                    <h6>Today Deposit</h6>
                    <h4>₹ {{ number_format($todayDeposit) }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
