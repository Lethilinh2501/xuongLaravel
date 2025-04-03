@extends('admin.layout.default')


@push('style')
<style>
    body {
        background-color: #f8f9fa;
    }

    .sidebar {
        background-color: #343a40;
        color: white;
        height: 100vh;
    }

    .sidebar a {
        color: white;
    }

    .sidebar a.active {
        background-color: #495057;
        border-radius: 5px;
    }

    .header {
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card {
        border-radius: 10px;
    }

    .table thead {
        background-color: #007bff;
        color: white;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }
</style>
@endpush

@section('content')
<main class="container-fluid flex-grow-1">
    <div class="container mt-4">
        <h2 class="mb-4">Dashboard</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Earnings (Monthly)</h5>
                        <p class="card-text">$40,000</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Earnings (Annual)</h5>
                        <p class="card-text">$215,000</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Task Completion</h5>
                        <p class="card-text">24 Tasks</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pending Requests</h5>
                        <p class="card-text">17 Requests</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Area Chart Example</div>
                    <div class="card-body">
                        <canvas id="areaChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Bar Chart Example</div>
                    <div class="card-body">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Area Chart
    var ctx1 = document.getElementById("areaChart").getContext("2d");
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Jan", "Mar", "May", "Jul", "Sep", "Nov"],
            datasets: [{
                label: "Revenue",
                data: [10000, 20000, 15000, 30000, 25000, 40000],
                borderColor: "#007bff",
                backgroundColor: "rgba(0, 123, 255, 0.1)",
                fill: true
            }]
        }
    });

    // Bar Chart
    var ctx2 = document.getElementById("barChart").getContext("2d");
    new Chart(ctx2, {
        type: "bar",
        data: {
            labels: ["Jan", "Mar", "May", "Jul", "Sep", "Nov"],
            datasets: [{
                label: "Earnings",
                data: [5000, 7000, 8000, 12000, 15000, 20000],
                backgroundColor: "#007bff"
            }]
        }
    });
</script>
@endpush
