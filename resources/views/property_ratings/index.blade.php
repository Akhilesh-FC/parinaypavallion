@extends('admin.layouts.administrator')

@section('title','Property Ratings')

@section('content')

<div class="container-fluid">

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="fas fa-star"></i> Property Ratings & Reviews
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Property</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($ratings as $key => $row)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>

                        {{-- USER --}}
                        <td>
                            <strong>{{ $row->user_name }}</strong><br>
                            <small>{{ $row->email }}</small><br>
                            <small>{{ $row->mobile }}</small>
                        </td>

                        {{-- PROPERTY --}}
                        <td>
                            <strong>{{ $row->property_name }}</strong><br>
                            <span class="badge bg-info">
                                {{ ucfirst($row->property_type) }}
                            </span>
                        </td>

                        {{-- RATING --}}
                        <td class="text-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $row->rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-secondary"></i>
                                @endif
                            @endfor
                            <br>
                            <small>{{ $row->rating }}/5</small>
                        </td>

                        {{-- REVIEW --}}
                        <td>
                            {{ \Illuminate\Support\Str::limit($row->review, 70) }}
                        </td>

                        {{-- DATE --}}
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-danger">
                            No ratings found
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
