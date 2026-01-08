@extends('admin.layouts.administrator')

@section('title', 'Bookings')

@section('content')

<div class="container-fluid">
    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-calendar-check"></i> Bookings List
            </h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Property ID</th>
                            <th>Booking Date</th>
                            <th>Time Slot</th>
                            <th>Guests</th>
                            <th>Total (₹)</th>
                            <th>Paid (₹)</th>
                            <th>Booking Status</th>
                            <th>Payment Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $booking->user_id }}</td>
                            <td>{{ $booking->property_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                            <td>{{ $booking->time_slot }}</td>
                            <td>{{ $booking->guest_count }}</td>
                            <td>₹ {{ number_format($booking->total_amount) }}</td>
                            <td>₹ {{ number_format($booking->paid_amount) }}</td>

                            <td>
                                <span class="badge 
                                    {{ $booking->booking_status == 'confirmed' ? 'bg-success' : 
                                       ($booking->booking_status == 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge 
                                    {{ $booking->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </td>

                            <td>
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBooking{{ $booking->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- 🔹 EDIT BOOKING MODAL --}}
                        <div class="modal fade" id="editBooking{{ $booking->id }}">
                            <div class="modal-dialog">
                                <form method="POST"
                                      action="{{ route('bookings.update', $booking->id) }}">
                                    @csrf

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Edit Booking</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-2">
                                                <label>Booking Status</label>
                                                <select name="booking_status" class="form-control">
                                                    <option value="pending"
                                                        {{ $booking->booking_status == 'pending' ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option value="confirmed"
                                                        {{ $booking->booking_status == 'confirmed' ? 'selected' : '' }}>
                                                        Confirmed
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $booking->booking_status == 'cancelled' ? 'selected' : '' }}>
                                                        Cancelled
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-2">
                                                <label>Payment Status</label>
                                                <select name="payment_status" class="form-control">
                                                    <option value="paid"
                                                        {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>
                                                        Paid
                                                    </option>
                                                    <option value="unpaid"
                                                        {{ $booking->payment_status == 'unpaid' ? 'selected' : '' }}>
                                                        Unpaid
                                                    </option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button class="btn btn-success">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="11" class="text-danger">
                                No bookings found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
