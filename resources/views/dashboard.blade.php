@extends('layouts.admin')

@section('content')
    <h1 class="mt-4 display-4">Selamat Datang, {{ auth()->user()->name }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <!-- Chart -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body">
                    <canvas id="chartContent"></canvas>
                </div>
            </div>
        </div>

        <!-- Kotak 3 -->
        <div class="col-xl-6 col-lg-12 mb-4">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Konten yang ditulis bulan ini</h5>
                    <p class="card-text">Informasi mengenai konten yang dibuat pada bulan {{ \Carbon\Carbon::now()->format('F Y') }}.</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <!-- Large number styling for content count -->
                    <div class="text-5xl font-bold text-white">{{ $contentThisMonth }} konten</div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("chartContent");
        if (ctx) {
            const myBarChart = new Chart(ctx.getContext("2d"), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: "Content",
                        backgroundColor: "rgba(78, 115, 223, 1)",
                        data: {!! json_encode($contentData) !!},
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { beginAtZero: true },
                        y: { beginAtZero: true },
                    },
                },
            });
        } else {
            console.error("Canvas element not found.");
        }
    });
    </script>
    @endpush
@endsection
