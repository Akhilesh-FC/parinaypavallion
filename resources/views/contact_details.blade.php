@extends('admin.layouts.administrator')

@section('title', 'Contact Details')

@section('content')

<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-address-book"></i> Contact Details
            </h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($contacts as $index => $contact)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $contact->address }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->email }}</td>

                            <td>
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editContact{{ $contact->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- 🔹 EDIT MODAL --}}
                        <div class="modal fade" id="editContact{{ $contact->id }}">
                            <div class="modal-dialog modal-lg">
                                <form method="POST"
                                      action="{{ route('contact_details.update', $contact->id) }}">
                                    @csrf

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Edit Contact Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-2">
                                                <label>Address</label>
                                                <textarea name="address"
                                                          class="form-control"
                                                          rows="3"
                                                          required>{{ $contact->address }}</textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <label>Phone</label>
                                                    <input type="text"
                                                           name="phone"
                                                           class="form-control"
                                                           value="{{ $contact->phone }}"
                                                           required>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label>Email</label>
                                                    <input type="email"
                                                           name="email"
                                                           class="form-control"
                                                           value="{{ $contact->email }}"
                                                           required>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Close
                                            </button>

                                            <button type="submit"
                                                    class="btn btn-success">
                                                Update
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-danger">
                                No contact details found
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
