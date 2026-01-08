@extends('admin.layouts.administrator')

@section('title','Social Links')

@section('content')

<div class="container-fluid">
    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-share-alt"></i> Social Links
            </h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($social)
            <form method="POST" action="{{ route('social.links.update', $social->id) }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Facebook URL</label>
                        <input type="url"
                               name="facebook"
                               class="form-control"
                               value="{{ $social->facebook }}"
                               placeholder="https://facebook.com/yourpage">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Instagram URL</label>
                        <input type="url"
                               name="instagram"
                               class="form-control"
                               value="{{ $social->instagram }}"
                               placeholder="https://instagram.com/yourpage">
                    </div>
                </div>

                <button class="btn btn-success">
                    <i class="fas fa-save"></i> Update
                </button>
            </form>
            @else
                <p class="text-danger">No social links record found.</p>
            @endif

        </div>
    </div>
</div>

@endsection
