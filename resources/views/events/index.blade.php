@extends('events.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h1 class="h3 mb-2 text-gray-800" style="font-weight: 700;">Dashboard</h1>
    <p class="text-secondary mb-0">Selamat datang kembali! Berikut ringkasan data terbaru.</p>
</div>

<div class="row">
    <!-- Total Produk Card -->
    <div class="col-xl-5 col-md-6 mb-4">
        <div class="card shadow-sm h-100 py-2 border-0" style="border-radius: 12px;">
            <div class="card-body">
                <div class="row no-gutters align-items-center mb-3">
                    <div class="col-auto mr-3">
                        <div class="icon-circle bg-indigo text-primary" style="width: 48px; height: 48px; background: #e0e7ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #4f46e5 !important;">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <div class="col">
                        <div class="h3 mb-0 font-weight-bold text-gray-800">2</div>
                        <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Produk</div>
                    </div>
                </div>
                <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-1" style="font-size: 0.8rem; border-color: #e2e8f0; color: #64748b;">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Pesanan Masuk Card -->
    <div class="col-xl-5 col-md-6 mb-4">
        <div class="card shadow-sm h-100 py-2 border-0" style="border-radius: 12px;">
            <div class="card-body">
                <div class="row no-gutters align-items-center mb-3">
                    <div class="col-auto mr-3">
                        <div class="icon-circle text-warning" style="width: 48px; height: 48px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #f59e0b !important;">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <div class="col">
                        <div class="h3 mb-0 font-weight-bold text-gray-800">0</div>
                        <div class="text-xs font-weight-bold text-muted text-uppercase mb-1" style="font-size: 0.75rem; letter-spacing: 0.05em;">Pesanan Masuk</div>
                    </div>
                </div>
                <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-1" style="font-size: 0.8rem; border-color: #e2e8f0; color: #64748b;">Cek Pesanan <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-10 col-lg-12">
        <div class="card shadow-sm mb-4 border-0" style="border-radius: 12px;">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white" style="border-radius: 12px 12px 0 0; border-bottom: 1px solid #f1f5f9;">
                <div>
                    <h6 class="m-0 font-weight-bold text-gray-800" style="font-size: 1.1rem;">Data Statistik Tahun Ini</h6>
                    <small class="text-muted">Perbandingan jumlah Produk, Pesanan, dan Persentase per bulan.</small>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 350px;">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    if(typeof Chart !== 'undefined') {
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = "'Outfit', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif";
        Chart.defaults.global.defaultFontColor = '#858796';

        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Persentase",
                    type: 'line',
                    lineTension: 0.3,
                    backgroundColor: "rgba(245, 158, 11, 0.05)",
                    borderColor: "rgba(245, 158, 11, 1)",
                    pointRadius: 4,
                    pointBackgroundColor: "rgba(245, 158, 11, 1)",
                    pointBorderColor: "rgba(245, 158, 11, 1)",
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: "rgba(245, 158, 11, 1)",
                    pointHoverBorderColor: "rgba(245, 158, 11, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: [0, 0, 0, 0, 0, 100, 0, 0, 0, 0, 0, 0],
                    yAxisID: 'y-axis-2',
                },
                {
                    label: "Produk",
                    type: 'bar',
                    backgroundColor: "#10b981",
                    hoverBackgroundColor: "#059669",
                    borderColor: "#10b981",
                    data: [0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0],
                    yAxisID: 'y-axis-1',
                    barPercentage: 0.5,
                    categoryPercentage: 0.5
                },
                {
                    label: "Pesanan",
                    type: 'bar',
                    backgroundColor: "#3b82f6",
                    hoverBackgroundColor: "#2563eb",
                    borderColor: "#3b82f6",
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    yAxisID: 'y-axis-1',
                    barPercentage: 0.5,
                    categoryPercentage: 0.5
                }]
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: { left: 10, right: 25, top: 25, bottom: 0 }
                },
                scales: {
                    xAxes: [{
                        time: { unit: 'date' },
                        gridLines: { display: false, drawBorder: false },
                        ticks: { maxTicksLimit: 12 }
                    }],
                    yAxes: [{
                        id: 'y-axis-1',
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            min: 0,
                            max: 2,
                            stepSize: 0.5
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }, {
                        id: 'y-axis-2',
                        type: 'linear',
                        position: 'right',
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            min: 0,
                            max: 200,
                            callback: function(value, index, values) {
                                return value + '%';
                            }
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        }
                    }]
                },
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: { usePointStyle: true, boxWidth: 10 }
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                }
            }
        });
    }
</script>
@endsection
