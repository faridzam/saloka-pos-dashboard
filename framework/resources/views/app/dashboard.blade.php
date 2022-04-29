@extends('layouts.app')
@push('styles')
  <style>
    #storeDevelopment{
      max-height: 40vh !important;
      max-width: 32.3vw !important;
    }
    #statistik-card{
        display: flex;
    }
    #statistik-right{

    }
    #totalPendapatan{
        position: relative;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;

        background-color: rgba(191, 255, 240, 0.3);
        border-radius: 20px;
        height: 360px !important;
    }
    .flex-break{
        flex-basis: 100%;
        height: 0 !important;
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
                <h4>Kasir Aktif</h4>
              </div>
              <div><h4>{{ $kasirAktif }}</h4></div>
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
              <div><h4>{{ $storeAktif }}</h4></div>
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
                <h4>Void Hari Ini</h4>
              </div>
              <div><h4>{{ $voidToday }}</h4></div>
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
                <h4>Total Produk</h4>
              </div>
              <div><h4>{{ $produkAktif }}</h4></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>Statistik</h4>
          </div>
          <div class="card-body">
              {{-- <div class="col-8" id="chartjs-penjualan">
                  @include('../partials/dashboardChartPenjualan')
              </div>
            <div class="col-4" id="statistik-right">
                <div class="col-lg-12" id="totalPendapatan">
                    <h3 id="profit-all" style="color:rgba(44, 46, 67, 0.8); margin-top:1rem;">{{ "Rp. ".number_format($profitAll,0,",",".") }}</h3>
                    <div class="flex-break"></div>
                    <p style="color:#398AB9;">view all</p>
                    <div class="flex-break"></div>
                    <p id="profit-bulan-ini" style="color:rgba(44, 46, 67, 0.8); height:100%; font-size: 12px;">pendapatan bulan ini : Rp. {{ number_format($profitBulanIni,0,",",".") }}</p>
                    <div class="flex-break"></div>
                </div>
            </div> --}}

            <livewire:penjualan-chart/>
            <livewire:omset-harian/>

            <livewire:scripts />
            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>

            @livewireChartsScripts

          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>history</h4>
          </div>
          <div class="card-body" id="statistik-card">
            <ul class="list-unstyled list-unstyled-border" style="width:100%;">
                  @foreach($historyAktif as $data)
                  <!-- loop -->
                  <li class="media">
                      <img class="mr-3 rounded-circle" width="50" src="{{ asset('/assets/img/avatar-3.png') }}" alt="avatar">
                      <div class="media-body">
                        <div class="float-right text-primary" style="float-right">{{$data->created_at}}</div>
                        <div class="media-title">{{$data->pic}}</div>
                        <span class="text-small text-muted">{{Str::limit($data->keterangan,100)}}</span>
                      </div>
                    </li>
                   <!-- end loop -->
                   @endforeach
                  </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4>judul</h4>
          </div>
          <div class="card-body">
            <ul class="list-unstyled list-unstyled-border">
                {{-- code revenue --}}
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
@endpush
