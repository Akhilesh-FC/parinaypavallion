@extends('admin.layouts.administrator')

@section('title','User Bank Details')

@section('content')

<div class="container-fluid">

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="fas fa-university"></i> User Bank Details
        </h4>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Bank Name</th>
                        <th>Account Holder</th>
                        <th>Account Number</th>
                        <th>IFSC</th>
                        <th>Branch</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($banks as $key => $b)
                    <tr>
                        <td>{{ $key+1 }}</td>

                        <td class="text-start">
                            <strong>{{ $b->user_name }}</strong><br>
                            <small>
                                {{ $b->email }}<br>
                                {{ $b->mobile }}
                            </small>
                        </td>

                        <td>{{ $b->bank_name }}</td>
                        <td>{{ $b->account_holder_name }}</td>

                        <td style="word-break:break-word;">
                            {{ $b->account_number }}
                        </td>

                        <td>{{ $b->ifsc_code }}</td>
                        <td>{{ $b->branch_name }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-danger text-center">
                            No bank details found
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
