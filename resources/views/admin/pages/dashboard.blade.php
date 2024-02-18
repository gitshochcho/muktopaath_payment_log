@extends('admin.template')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-hands-helping fa-3x" style="color: #C813F5;"></i>
                <div class="ms-3">
                    <p class="mb-2">Partner</p>
                    <h6 class="mb-0">{{$partnerLists}}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-th fa-3x" style="color: #C813F5;"></i>
                <div class="ms-3">
                    <p class="mb-2">Course</p>
                    <h6 class="mb-0">{{$courseBatches}}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x" style="color: #C813F5;"></i>
                <div class="ms-3">
                    <p class="mb-2">Enroll</p>
                    <h6 class="mb-0">{{$totals->sum('order_count')}}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-hand-holding-usd fa-3x" style="color: #C813F5;"></i>
                <div class="ms-3">
                    <p class="mb-2">Amount</p>
                    <h6 class="mb-0">{{$totals->sum('total_amount')}}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->


<!-- Sales Chart Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Year wise total amount </h6>
                    {{-- <a href="">Show All</a> --}}
                </div>
                <canvas id="total-enroll"></canvas>
            </div>
        </div>
        {{-- <div class="col-sm-12 col-xl-6">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Salse & Revenue</h6>
                    <a href="">Show All</a>
                </div>
                <canvas id="salse-revenue"></canvas>
            </div>
        </div> --}}
    </div>
</div>
@endsection

@push('customejs')

<script>
    var ctx1 = $("#total-enroll").get(0).getContext("2d");
    var myChart1 = new Chart(ctx1, {
        type: "line",
        data: {
            labels: {!! json_encode($totals->pluck('year')->toArray()) !!},
            datasets: [{
                    label: "Amount",
                    data: {!! json_encode($totals->pluck('total_amount')->toArray()) !!},
                    backgroundColor: "rgba(200, 19, 245, .7)",
                    fill: true,
                    tension: 0.1,
                    pointRadius:5,
                    pointHoverRadius:6,
                },

            ]
            },
        options: {
            responsive: true
        }
    });
</script>

@endpush
