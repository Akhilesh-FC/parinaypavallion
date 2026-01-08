@extends('admin.layouts.administrator')

@section('title','Rooms')

@section('content')

<style>
    .room-thumb{
        width:55px;
        height:40px;
        object-fit:cover;
        border-radius:5px;
        cursor:pointer;
        margin-right:4px;
    }
</style>

<div class="container-fluid">

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">

    {{-- HEADER --}}
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <i class="fas fa-bed"></i> Room Properties
        </h4>

        <button class="btn btn-light btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#addRoomModal">
            <i class="fas fa-plus"></i> Add Room
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Images</th>
                        <th>Name</th>
                        <th>Guests</th>
                        <th>Facilities</th>
                        <th>Price</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th width="12%">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($properties as $key => $property)
                    <tr>
                        <td>{{ $key+1 }}</td>

                        {{-- Images --}}
                        <td>
                            @foreach(explode(',', $property->images) as $img)
                                <img src="{{ asset($img) }}"
                                     class="room-thumb"
                                     data-bs-toggle="modal"
                                     data-bs-target="#roomImg{{ $loop->index }}{{ $property->id }}">
                            @endforeach
                        </td>

                        {{-- Name --}}
                        <td class="text-start">
                            <strong>{{ $property->name }}</strong><br>
                            <small>{{ Str::limit($property->description,40) }}</small>
                        </td>

                        {{-- Guests --}}
                        <td>{{ $property->min_guests }} - {{ $property->max_guests }}</td>

                        {{-- Facilities --}}
                        <td>
                            @foreach($property->facilities as $facility)
                                <span class="badge bg-info">{{ $facility }}</span>
                            @endforeach
                        </td>

                        {{-- Price --}}
                        <td>₹ {{ number_format($property->base_price) }}</td>

                        {{-- Rating --}}
                        <td>
                            {{ $property->avg_rating ?? 0 }}/5<br>
                            <small>({{ $property->total_ratings ?? 0 }} reviews)</small>
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="badge {{ $property->status ? 'bg-success':'bg-danger' }}">
                                {{ $property->status ? 'Active':'Inactive' }}
                            </span>
                        </td>

                        {{-- Action --}}
                        <td>
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#editRoomModal{{ $property->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- IMAGE PREVIEW --}}
                    @foreach(explode(',', $property->images) as $img)
                    <div class="modal fade" id="roomImg{{ $loop->index }}{{ $property->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>{{ $property->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset($img) }}" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- EDIT ROOM MODAL --}}
                    <div class="modal fade" id="editRoomModal{{ $property->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST"
                                  action="{{ route('properties.rooms.update',$property->id) }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Room</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="text" name="name"
                                               class="form-control mb-2"
                                               value="{{ $property->name }}" required>

                                        <div class="row">
                                            <div class="col">
                                                <input type="number" name="min_guests"
                                                       class="form-control"
                                                       value="{{ $property->min_guests }}">
                                            </div>
                                            <div class="col">
                                                <input type="number" name="max_guests"
                                                       class="form-control"
                                                       value="{{ $property->max_guests }}">
                                            </div>
                                        </div>

                                        <input type="number" name="base_price"
                                               class="form-control mt-2"
                                               value="{{ $property->base_price }}">

                                        <select name="status" class="form-control mt-2">
                                            <option value="1" {{ $property->status?'selected':'' }}>Active</option>
                                            <option value="0" {{ !$property->status?'selected':'' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-success">Update Room</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="9" class="text-danger text-center">
                            No rooms found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

{{-- ADD ROOM MODAL --}}
<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST"
              action="{{ route('properties.rooms.store') }}"
              enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Room name" required>
                    <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

                    <div class="row">
                        <div class="col">
                            <input type="number" name="min_guests" class="form-control" placeholder="Min guests">
                        </div>
                        <div class="col">
                            <input type="number" name="max_guests" class="form-control" placeholder="Max guests">
                        </div>
                    </div>

                    <input type="number" name="base_price" class="form-control mt-2" placeholder="Base price">
                    <input type="file" name="images[]" multiple class="form-control mt-2">

                    <div class="mt-2">
                        @foreach(DB::table('facilities')->get() as $f)
                            <label class="me-2">
                                <input type="checkbox" name="facilities[]" value="{{ $f->id }}"> {{ $f->name }}
                            </label>
                        @endforeach
                    </div>

                    <select name="status" class="form-control mt-2">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success">Add Room</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
