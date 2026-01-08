@extends('admin.layouts.administrator')

@section('title', 'Sliders')

@section('content')

<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-images"></i> Sliders List
            </h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sliders as $index => $slider)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $slider->title }}</td>

                            {{-- IMAGE SHOW --}}
                            <td>
                                <img src="{{ asset($slider->image) }}"
                                     width="80"
                                     class="rounded shadow"
                                     style="cursor:pointer"
                                     data-bs-toggle="modal"
                                     data-bs-target="#imageModal{{ $slider->id }}">
                            </td>


                            {{-- STATUS --}}
                            <td>
                                <span class="badge {{ $slider->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $slider->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- ACTION --}}
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editSlider{{ $slider->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- 🔹 EDIT MODAL --}}
                        <div class="modal fade" id="editSlider{{ $slider->id }}">
                            <div class="modal-dialog">
                                <form method="POST"
                                      action="{{ route('sliders.update', $slider->id) }}"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Edit Slider</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-2">
                                                <label>Title</label>
                                                <input type="text"
                                                       name="title"
                                                       class="form-control"
                                                       value="{{ $slider->title }}"
                                                       required>
                                            </div>

                                            <div class="mb-2">
                                                <label>Image</label>
                                                <input type="file" name="image" class="form-control">
                                                <img src="{{ asset($slider->image) }}" width="100" class="mt-2">
                                            </div>

                                            <div class="mb-2">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="1" {{ $slider->status ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ !$slider->status ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button class="btn btn-success">Update</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        
                        
                        {{-- IMAGE PREVIEW MODAL --}}
                        <div class="modal fade" id="imageModal{{ $slider->id }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Slider Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img src="{{ asset($slider->image) }}"
                     class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>


                        @empty
                        <tr>
                            <td colspan="5" class="text-danger">No sliders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
