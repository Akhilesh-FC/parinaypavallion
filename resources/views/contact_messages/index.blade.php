@extends('admin.layouts.administrator')

@section('title','Contact Messages')

@section('content')

<div class="container-fluid">

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="fas fa-envelope-open-text"></i> Contact Messages
        </h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Received On</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($messages as $key => $msg)
                    <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                        <td><strong>{{ $msg->name }}</strong></td>
                        <td>{{ $msg->mobile }}</td>
                        <td>{{ $msg->email }}</td>
                        <td>
                            {{ \Illuminate\Support\Str::limit($msg->message, 40) }}
                            <br>
                            <button class="btn btn-link btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#viewMsg{{ $msg->id }}">
                                View
                            </button>
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($msg->created_at)->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('contact.messages.delete', $msg->id) }}"
                               onclick="return confirm('Delete this message?')"
                               class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    {{-- VIEW MESSAGE MODAL --}}
                    <div class="modal fade" id="viewMsg{{ $msg->id }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Message from {{ $msg->name }}</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p><strong>Mobile:</strong> {{ $msg->mobile }}</p>
                                    <p><strong>Email:</strong> {{ $msg->email }}</p>
                                    <hr>
                                    <p>{{ $msg->message }}</p>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="7" class="text-center text-danger">
                            No messages found
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
