@extends('layouts.admin')

@section('content')
    @include('components.loading')
    <div class="container">
        <form id="content-form" class="p-4 card shadow-sm" action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-header bg-primary text-white">
                <h4>Tambah Content</h4>
            </div>
            <div class="card-body">
                <!-- Nama Produk & Pemilik -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_produk">Judul</label>
                        <input type="text" name="title" class="form-control" placeholder="Judul">
                        @if ($errors->has('title'))
                            <span class="text-danger small">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="content">Isi</label>
                        <textarea name="content" class="form-control"></textarea>
                        @if ($errors->has('content'))
                            <span class="text-danger small">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                </div>

                <!-- Gambar -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" id="imageInput" name="image" class="form-control shadow-sm" multiple accept="image/*">
                        @error('image')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Preview Gambar:</label>
                        <div id="imagePreview" class="d-flex flex-wrap gap-3"></div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="card-footer text-center">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <button type="submit" class="btn btn-warning w-100"><i class="fas fa-paper-plane"></i> Kirim</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('content') }}" class="btn btn-secondary w-100"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("content-form");
            const loadingOverlay = document.getElementById("loading");
            const submitButton = form.querySelector("button[type='submit']");

            if (form && loadingOverlay && submitButton) {
                form.addEventListener("submit", function (e) {
                    loadingOverlay.style.display = "flex";
                    submitButton.disabled = true;
                    submitButton.textContent = "Loading...";
                });
            } else {
                console.error("Form, loading overlay, atau tombol submit tidak ditemukan!");
            }
        });

        // Script untuk preview gambar baru
        document.getElementById('imageInput').addEventListener('change', function (event) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Clear previous images

            const files = event.target.files; // Ambil file yang dipilih
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.startsWith('image/')) continue;

                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail', 'me-2', 'mb-2');
                    img.style.maxWidth = '150px';
                    img.style.maxHeight = '150px';

                    imagePreview.appendChild(img); // Add image to preview
                };
                reader.readAsDataURL(file); // Read file as URL
            }
        });
    </script>
    @endpush
@endsection
