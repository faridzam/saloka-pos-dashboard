@extends('layouts.app')

@push('styles')
<style>
</style>
@endpush

@section('title', 'Admin Dashboard')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>Master Produk</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                    <div class="card-body">
                    <label for="provi">Nama Store : </label></br>
                      
                        <select class="custom-select" onchange="yesnoCheck(this);" style="width: 49.5%; margin-bottom: 1rem;" id="store" name="store" required>
                          <option selected>-- Silahkan Pilih Store --</option>
                          @foreach ($stores as $store)
                              <option value={{ $store->id_store }}>{{ $store->nama_store }}</option>
                          @endforeach
                        </select>
                        
                        </br>
                        
                        <select class="custom-select kategori-select" style="display:none;" style="width: 49.5%; margin-bottom: 1rem;" id="ifYes" name="id_kategori" required>
                          <option selected>-- Silahkan Pilih Kategori --</option>
                          <optgroup id="opt-group-category"></optgroup>
                            {{--@foreach ($kategori as $value)
                              <option value={{ $value->id_kategori }}>{{ $value->nama_kategori }}</option>
                            @endforeach--}}
                        </select>
                      
                        <div class="form-group">

                        </div>
                        <div class="form-group">
                        <table id="tableIndex" class="table table-striped table-bordered display nowrap" style="width: 100%">
                          <thead clas="bg-dark">
                            <tr>
                              <th style="width: 10%;">ID Item</th>
                              <th style="width: 20%;">Nama Item</th>
                              <th style="width: 15%;">HPP</th>
                              <th style="width: 10%;">Pajak</th>
                              <th style="width: 15%;">Harga Jual</th>
                              <th style="width: 5%;">Edit</th>
                              <th style="width: 5%;">Hapus</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                          <tfoot >
                            <tr>
                              <th></th>
                              <th></th>
                              <th></th>
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
                        <a class="btn btn-block btn-success" id="iExportSelect" data-toggle="modal" data-target="#addProduk"><i class="fas fa-file-export mr-2"></i>Tambah Produk</a>
                        </div>
                        {{-- <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                        <button type="button" class="btn btn-block btn-danger" id="iExportAll"><i class="fas fa-file-export mr-2"></i>Export All</button>         
                        </div> --}}

                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
  </section>
  
  <div class="modal-edit">
      @include('app.modals.editProduk')
  </div>
  
  <div class="modal-add">
      @include('app.modals.addProduk')
  </div>
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

   function fetch_customer_data(id_store = $('#id_store').val(), id_kategori = $('#ifYes').val())
   {
    $.ajax({
     url:"dashboardMasterMenu-search",
     method:'GET',
     data:{id_store:id_store, id_kategori:id_kategori},
     dataType:'json',
     success:function(data)
     {
        $('#opt-group-category').html(data.kategori_data);
        $('tbody').html(data.table_data);
        $('#total_records').text(data.total_data);
     }
    })
   }

   $(document).on('change', 'input', function(){
    var id_store = $('#store').val();
    var id_kategori = $('#ifYes').val();
    fetch_customer_data(id_store, id_kategori);
   });
   $(document).on('change', 'select', function(){
    var id_store = $('#store').val();
    var id_kategori = $('#ifYes').val();
    fetch_customer_data(id_store, id_kategori);
   });
  });
</script>

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

<script>
    function yesnoCheck(that) {
        if (that.value !== "-- Silahkan Pilih Store --") {
            document.getElementById("ifYes").style.display = "inline-block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }
</script>

<script>
    $(document).on("click", ".open-modal", function () {
     var eventId = $(this).data('id');
     var eventItem = $(this).data('item');
     var eventNama = $(this).data('nama');
     var eventKategori = $(this).data('kategori');
     var eventStore = $(this).data('store');
     var eventHarga = $(this).data('harga');
     var eventPajak = $(this).data('pajak');
     var eventHargaJual = $(this).data('harga_jual');
     $('#id').val( eventId );
     $('#id_item').val( eventItem );
     $('#nama_item').val( eventNama );
     $('#id_kategori').val( eventKategori );
     $('#id_store').val( eventStore );
     $('#harga').val( eventHarga );
     $('#pajak').val( eventPajak );
     $('#harga_jual').val( eventHargaJual );
    });
</script>

<script>
    function confirmation() {
  return confirm('Yakin menghapus produk?');
}
</script>

@endpush