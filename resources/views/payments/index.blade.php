@extends('admin.layouts.administrator')

@section('title','Pay-In Details')

@section('content')

<div class="container-fluid">

<div class="card shadow">

    {{-- HEADER --}}
    <div class="card-header bg-success text-white">
        <h4 class="mb-0">
            <i class="fas fa-money-check-alt"></i> Pay-In Details (User Wise)
        </h4>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User Details</th>
                        <th>Property Booked</th>
                        <th>Property Amount</th>
                        <th>Paid Amount</th>
                        <th>Payment Gateway</th>
                        <th>Transaction ID</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($payments as $key => $p)
                    <tr>
                        <td>{{ $key+1 }}</td>

                        {{-- USER --}}
                        <td class="text-start">
                            <strong>{{ $p->user_name }}</strong><br>
                            <small>
                                📧 {{ $p->email }}<br>
                                📱 {{ $p->mobile }}
                            </small>
                        </td>

                        {{-- PROPERTY --}}
                        <td>
                            <strong>{{ $p->property_name ?? 'N/A' }}</strong><br>
                            <small>
                                Guests: {{ $p->guest_count ?? '-' }}<br>
                                Date: {{ $p->booking_date ? \Carbon\Carbon::parse($p->booking_date)->format('d M Y') : '-' }}
                            </small>
                        </td>

                        {{-- PROPERTY PRICE --}}
                        <td>
                            ₹ {{ number_format($p->property_price ?? 0, 2) }}
                        </td>

                        {{-- PAID --}}
                        <td>
                            <strong class="text-success">
                                ₹ {{ number_format($p->paid_amount, 2) }}
                            </strong>
                        </td>

                        {{-- GATEWAY --}}
                        <td>{{ ucfirst($p->payment_gateway) }}</td>

                        {{-- TXN --}}
                        <td style="max-width:180px;word-break:break-word;">
                            {{ $p->transaction_id }}
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <span class="badge
                                {{ $p->payment_status == 'success' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($p->payment_status) }}
                            </span>
                        </td>

                        {{-- DATE --}}
                        <td>
                            {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-danger text-center">
                            No payment records found
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
