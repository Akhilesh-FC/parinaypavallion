@extends('admin.layouts.administrator')

@section('title', 'Gallery')

@section('content')

{{-- INLINE CSS (ALAG FILE NAHI) --}}
<style>
    .gallery-thumb{
        width:90px;
        height:60px;
        object-fit:cover;
        border-radius:6px;
        cursor:pointer;
        display:block;
        margin:auto;
    }
</style>

<div class="container-fluid">
    <div class="card shadow">

        {{-- HEADER --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-images"></i> Gallery
            </h4>
            <button class="btn btn-light btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#addGalleryModal">
                <i class="fas fa-plus"></i> Add Gallery
            </button>
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
                            <th style="width:120px;">Preview</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th width="18%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($gallery as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            {{-- PREVIEW --}}
                            <td>
                                @if($item->type == 'image')
                                    <img src="{{ asset($item->image) }}"
                                         class="gallery-thumb"
                                         data-bs-toggle="modal"
                                         data-bs-target="#previewGallery{{ $item->id }}">
                                @else
                                    <video class="gallery-thumb" muted
                                           data-bs-toggle="modal"
                                           data-bs-target="#previewGallery{{ $item->id }}">
                                        <source src="{{ asset($item->video) }}">
                                    </video>
                                @endif
                            </td>

                            {{-- TYPE --}}
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </td>

                            {{-- DATE --}}
                            <td>
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                            </td>

                            {{-- ACTION --}}
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editGallery{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <a href="{{ route('gallery.delete',$item->id) }}"
                                   onclick="return confirm('Delete this gallery item?')"
                                   class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        {{-- EDIT MODAL --}}
                        <div class="modal fade" id="editGallery{{ $item->id }}">
                            <div class="modal-dialog modal-lg">
                                <form method="POST"
                                      action="{{ route('gallery.update', $item->id) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>Edit Gallery</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label>Type</label>
                                                <select name="type" class="form-control">
                                                    <option value="image" {{ $item->type=='image'?'selected':'' }}>Image</option>
                                                    <option value="video" {{ $item->type=='video'?'selected':'' }}>Video</option>
                                                </select>
                                            </div>

                                            <div class="mb-2">
                                                <label>Image</label>
                                                <input type="file" name="image" class="form-control">
                                            </div>

                                            <div class="mb-2">
                                                <label>Video</label>
                                                <input type="file" name="video" class="form-control">
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

                        {{-- PREVIEW MODAL --}}
                        <div class="modal fade" id="previewGallery{{ $item->id }}">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Gallery Preview</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        @if($item->type=='image')
                                            <img src="{{ asset($item->image) }}"
                                                 class="img-fluid rounded shadow">
                                        @else
                                            <video controls class="w-100 rounded shadow">
                                                <source src="{{ asset($item->video) }}">
                                            </video>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-danger text-center">
                                No gallery items found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- ADD GALLERY MODAL --}}
<div class="modal fade" id="addGalleryModal">
    <div class="modal-dialog modal-lg">
        <form method="POST"
              action="{{ route('gallery.store') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Gallery</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label>Type</label>
                        <select name="type" class="form-control" required>
                            <option value="">Select</option>
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Video</label>
                        <input type="file" name="video" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success">Add</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
