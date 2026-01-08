@extends('admin.layouts.administrator')

@section('title', 'User List')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">
                        <i class="fa-solid fa-users me-2"></i>User List
                    </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th width="15%">Joined On</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><strong>{{ $user->name ?? '-' }}</strong></td>
                                        <td>{{ $user->email ?? '-' }}</td>
                                        <td>{{ $user->mobile ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">
                                            No users found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
