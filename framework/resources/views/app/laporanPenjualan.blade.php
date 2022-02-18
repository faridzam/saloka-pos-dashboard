@extends('layouts.app')

@push('styles')
<style>
  table.dataTable thead .sorting:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before {
bottom: .5em;
}
</style>
@endpush

@section('title', 'Admin Dashboard')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Laporan Penjualan</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <form id="formData" action="{{ route('dashboardLaporanPenjualan.export') }}" method="GET">
                    <div class="card-body">
                    <label for="provi">Nama Store : </label></br>
                      
                        <select class="custom-select" style="width: 49.5%; margin-bottom: 1rem;" id="id_store" name="id_store" required>
                          <option selected>-- Silahkan Pilih Store --</option>
                          @foreach ($stores as $store)
                              <option value={{ $store->id_store }}>{{ $store->nama_store }}</option>
                          @endforeach
                        </select>
                      
                           
                        <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="iNama">Tanggal Awal:</label>
                            <input type="text" class="form-control date" id="tanggalAwal" name="tanggalAwal" value="{{ $dateNow }}">
                          </div>  
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="iNama">Tanggal Akhir:</label>
                            <input type="text" class="form-control date" id="tanggalAkhir" name="tanggalAkhir" value="{{ $dateNow }}">
                          </div> 
                        </div>
                        </div>
                        <div class="form-group">

                        </div>
                        <div class="form-group">
                        <table id="tableIndex" class="table table-striped table-bordered display nowrap" style="width: 100%">
                          <thead clas="bg-dark">
                            <tr>
                              <th style="width: 20%;">No Invoice</th>
                              <th style="width: 10%;">ID Kasir</th>
                              <th style="width: 20%;">Metode Pembayaran</th>
                              <th style="width: 20%;">Total Pendapatan</th>
                              <th style="width: 15%;">Tanggal</th>
                              <th style="width: 15%;">Jam</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                          <tfoot >
                            <tr>
                              <th style="width: 10%;"><h4>Profit: </h4></th>
                              <th style="width: 20%%;"><h4 id="totalProfit" name="totalProfit"></h4></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </tfoot>
                        </table>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                        <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                        <button type="submit" class="btn btn-block btn-success" id="iExportSelect"><i class="fas fa-file-export mr-2"></i>Export</button>
                        </div>
                        {{-- <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                        <button type="button" class="btn btn-block btn-danger" id="iExportAll"><i class="fas fa-file-export mr-2"></i>Export All</button>         
                        </div> --}}

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
  </section>
@endsection

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css">

  <script>
    $( ".date" ).datepicker({
      format: "yyyy-mm-dd",
    });
  </script>

<script>
  $(document).ready(function(){

   fetch_customer_data();

   function fetch_customer_data(id_store = $('#id_store').val(), tanggalAwal = $('#tanggalAwal').val(), tanggalAkhir = $('#tanggalAkhir').val())
   {
    $.ajax({
     url:"dashboardLaporanPenjualan-search",
     method:'GET',
     data:{id_store:id_store, tanggalAwal:tanggalAwal, tanggalAkhir:tanggalAkhir},
     dataType:'json',
     success:function(data)
     {
      $('tbody').html(data.table_data);
      $('#total_records').text(data.total_data);
      $('#totalProfit').text(data.profit);
     }
    })
   }

   $(document).on('change', 'input', function(){
    var id_store = $('#id_store').val();
    var tanggalAwal = $('#tanggalAwal').val();
    var tanggalAkhir = $('#tanggalAkhir').val();
    fetch_customer_data(id_store, tanggalAwal, tanggalAkhir);
   });
   $(document).on('change', 'select', function(){
    var id_store = $('#id_store').val();
    var tanggalAwal = $('#tanggalAwal').val();
    var tanggalAkhir = $('#tanggalAkhir').val();
    fetch_customer_data(id_store, tanggalAwal, tanggalAkhir);
   });
  });
</script>

{{-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

<script>
  $(document).ready(function() {
    $('#tableIndex').DataTable({
    });
  });
</script> --}}

<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

<script>
  $(document).ready(function () {
  $('#tableIndex').DataTable({
  "scrollY": "300px",
  "scrollCollapse": true,
  "paging":   false,
  "searching":   false,
  ajax: "{{ route('dashboardLaporanPenjualan.search')}}",
  columns: [
    { data: 'no_invoice' },
    { data: 'id_kasir' },
    { data: 'metode' },
    { data: 'total_pembelian' },
  ]
  });
  $('.dataTables_length').addClass('bs-select');
  });
</script>


@endpush