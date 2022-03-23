@extends('layouts.app')

@push('styles')
<style>

#addProduk {
    padding-right: 0px !important;
}
.modal {
    padding-right: 0px !important;
}
.body.open-modal .show {
    padding-right: 0px !important;
}
.modal-dialog {
    max-width: 100%;
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

.modal-content {
    padding: 0;
    height: auto;
    width: 100vw !important;
    min-height: 100%;
    min-width: 100%;
    border-radius: 0;
}

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
                              <option value={{ $store->menu_store }}>{{ $store->nama_store }}</option>
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
                        <table id="tableIndex" class="table table-striped table-bordered display nowrap sortable">
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
                        </table>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                        <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                        <a type="button" class="btn btn-block btn-success" id="iExportSelect" data-toggle="modal" data-target="#addProduk"><i class="fas fa-file-export mr-2"></i>Tambah Produk</a>
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

   function fetch_customer_data(id_store = $('#store').val(), id_kategori = $('#ifYes').val())
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

<script>
  $(document).ready(function(){

   fetch_add_data();

   function fetch_add_data(id_store = $('#add-store').val(), id_kategori = $('#add-kategori').val())
   {
    $.ajax({
     url:"dashboardMasterMenu-addProductAction",
     method:'GET',
     data:{id_store:id_store, id_kategori:id_kategori},
     dataType:'json',
     success:function(data)
     {
        $('#add-group-category').html(data.kategori_data);
     }
    })
   }

   $(document).on('change', 'input', function(){
    var id_store = $('#add-store').val();
    var id_kategori = $('#add-kategori').val();
    fetch_add_data(id_store, id_kategori);
   });
   $(document).on('change', 'select', function(){
    var id_store = $('#add-store').val();
    var id_kategori = $('#add-kategori').val();
    fetch_add_data(id_store, id_kategori);
   });
  });
</script>

<script>
    $(function () {
        $('#addProduk-close').on('click', function () {
            $('#addProduk').hide('hide');
            $('body').removeClass('modal-open');
            $('#addProduk').removeClass('show');
            $('body').removeAttr('style');
            $('#addProduk').removeAttr('aria-modal');
            $('#addProduk').removeAttr('style', 'padding-right');
            $('#addProduk').css('display', 'none');
            $('#addProduk').attr('aria-hidden', true);
            $('.modal-backdrop').remove();
        })
    })
</script>

<script>
    $(function () {
        $('#editProduk-close').on('click', function () {
            $('#editProduk').hide('hide');
            $('body').removeClass('modal-open');
            $('#editProduk').removeClass('show');
            $('body').removeAttr('style');
            $('#editProduk').removeAttr('aria-modal');
            $('#editProduk').removeAttr('style', 'padding-right');
            $('#editProduk').css('display', 'none');
            $('#editProduk').attr('aria-hidden', true);
            $('.modal-backdrop').remove();
        })
    })
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
