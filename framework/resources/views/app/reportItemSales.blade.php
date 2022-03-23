@extends('layouts.app')

@push('styles')
<style>
    tbody {
        display: block;
        width: 100%;
        max-height: 350px;
        overflow-y: scroll;
    }
    table thead, table tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>
@endpush

@section('title', 'Admin Dashboard')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Report Item Sales</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <form id="formData" action="{{ route('dashboardReportItemSales.export') }}" method="GET">
                    <div class="card-body">
                    <label for="provi">Nama Store : </label></br>

                        <select class="custom-select" style="width: 49.5%; margin-bottom: 1rem;" id="id_store" name="id_store" required>
                          <option selected>-- Silahkan Pilih Store --</option>
                          @foreach ($stores as $store)
                              <option value={{ $store->menu_store }}>{{ $store->nama_store }}</option>
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
                        <table id="tableIndex" class="table table-striped table-bordered display nowrap sortable">
                          <thead clas="bg-dark">
                            <tr>
                              <th style="width: 20%;">ID Item</th>
                              <th style="width: 25%;">Nama Item</th>
                              <th style="width: 20%;">Harga</th>
                              <th style="width: 15%;">Quantity</th>
                              <th style="width: 20%;">Total</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-between">
                            <div class="mx-3 d-flex">
                                <h4>Profit:</h4>
                                <h4 class="mx-3" id="totalProfit" name="totalProfit"></h4>
                            </div>
                            <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                                <button type="submit" class="btn btn-block btn-success" id="iExportSelect"><i class="fas fa-file-export mr-2"></i>Export</button>
                            </div>
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
     url:"dashboardReportItemSales-search",
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

<link rel="stylesheet" href="https://drvic10k.github.io/bootstrap-sortable/Contents/bootstrap-sortable.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.1/moment.js"></script>
<script src="https://drvic10k.github.io/bootstrap-sortable/Scripts/bootstrap-sortable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>


<script>
    $('.sortable').sortable();
</script>


@endpush
