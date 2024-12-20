@extends('layouts.admin')

@section('content')
    <hr />

    <!-- Content Detail Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Content Details</h5>
        </div>
        <div class="card-body">
            <!-- Title and Content Row -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control shadow-sm" placeholder="Title" value="{{ $content->title }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Content</label>
                    <textarea class="form-control shadow-sm" name="content" placeholder="Content" readonly>{{ $content->content }}</textarea>
                </div>
            </div>

            <!-- Image Row -->
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Image</label>
                    <div class="row">
                        @if($content->image_url)
                            <div class="col-md-4 mb-3">
                                <img src="{{ $content->image_url }}" alt="Content Image" class="img-fluid rounded shadow-sm" style="max-width: 100%; max-height: 150px;">
                            </div>
                        @else
                            <div class="col">
                                <p class="text-muted">No image available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('content') }}" class="btn btn-secondary btn-sm shadow-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
@endsection
