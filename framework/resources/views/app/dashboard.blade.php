@extends('layouts.app')
@push('styles')
  <style>
    .card-body{
      height: 55vh !important;
    }
    #storeDevelopment{
      max-height: 40vh !important;
      max-width: 30vw !important;
    }
  </style>
@endpush
@section('title', 'Admin Dashboard')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Kasir (Aktif)</h4>
              </div>
              {{-- kasir aktif code --}}
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="fas fa-store"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Store</h4>
              </div>
              {{-- store aktif code --}}
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="far fa-file"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Void</h4>
              </div>
              {{-- void code --}}
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-book"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Menu (Aktif)</h4>
              </div>
              {{-- menu aktif code --}}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Statistik</h4>
          </div>
          <div class="card-body">
            <h1>Store Revenue</h1>
            <canvas id="storeDevelopment"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    //line
  var ctxL = document.getElementById("storeDevelopment").getContext('2d');
  var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
  labels: ["{{ $monthName[5] }}", "{{ $monthName[4] }}", "{{ $monthName[3] }}", "{{ $monthName[2] }}", "{{ $monthName[1] }}", "{{ $monthName[0] }}"],
  datasets: [{

    label: "Kedai Adu Tangkas",
    data: [{{ $profitAduTangkas[0] }}, {{ $profitAduTangkas[1] }}, {{ $profitAduTangkas[2] }}, {{ $profitAduTangkas[3] }}, {{ $profitAduTangkas[4] }}, {{ $profitAduTangkas[5] }}, {{ $profitAduTangkas[6] }}],
    backgroundColor: [
      'rgba(105, 0, 132, .2)',
    ],
    borderColor: [
      'rgba(200, 99, 132, .7)',
    ],
    borderWidth: 2
    },
    
  ]},
  options: {
  responsive: true
  }
  });
  </script>
@endpush