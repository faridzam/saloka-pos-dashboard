@extends('layouts.app')

@push('styles')
<style>
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
      <h1>Stock Management</h1>
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
                              <th style="width: 15%;">QTY</th>
                              <th style="width: 15%;">min. QTY</th>
                              <th style="width: 5%;">plus</th>
                              <th style="width: 5%;">minus</th>
                            </tr>
                          </thead>
                          <tbody></tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                        <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-block btn-success" id="iExportSelect" data-toggle="modal" data-target="#addProdukStock"><i class="fas fa-file-export mr-2"></i>Tambah Produk</a>
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
      @include('app.modals.addProdukStock')
  </div>
  <div class="modal-add">
      @include('app.modals.minStock')
  </div>
  <div class="modal-add">
      @include('app.modals.plusStock')
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
     url:"dashboardStockManagement-search",
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
    function confirmation() {
  return confirm('Yakin menghapus produk?');
}
</script>

<script>
  $(document).ready(function(){

   fetch_add_stock();

   function fetch_add_stock(id_store = $('#add-store').val(), id_item = $('#add-product').val())
   {
    $.ajax({
     url:"dashboardStockManagement-addStock",
     method:'GET',
     data:{id_store:id_store, id_item:id_item},
     dataType:'json',
     success:function(data)
     {
        $('#opt-group-addStock').html(data.kategori_data);
        $('#id_item_add').val(data.id_item);
     }
    })
   }

   $(document).on('change', 'input', function(){
    var id_store = $('#add-store').val();
    var id_item = $('#add-product').val();
    fetch_add_stock(id_store, id_item);
   });
   $(document).on('change', 'select', function(){
    var id_store = $('#add-store').val();
    var id_item = $('#add-product').val();
    fetch_add_stock(id_store, id_item);
   });
  });
</script>

<script>
    $(function () {
        $('#addProdukStock-close').on('click', function () {
            $('#addProdukStock').hide('hide');
            $('body').removeClass('modal-open');
            $('#addProdukStock').removeClass('show');
            $('body').removeAttr('style');
            $('#addProdukStock').removeAttr('aria-modal');
            $('#addProdukStock').removeAttr('style', 'padding-right');
            $('#addProdukStock').css('display', 'none');
            $('#addProdukStock').attr('aria-hidden', true);
            $('.modal-backdrop').remove();
        })
    })
</script>

<script>
    $(function () {
        $('#plusStock-close').on('click', function () {
            $('#plusStock').hide('hide');
            $('body').removeClass('modal-open');
            $('#plusStock').removeClass('show');
            $('body').removeAttr('style');
            $('#plusStock').removeAttr('aria-modal');
            $('#plusStock').removeAttr('style', 'padding-right');
            $('#plusStock').css('display', 'none');
            $('#plusStock').attr('aria-hidden', true);
            $('.modal-backdrop').remove();
        })
    })
</script>

<script>
    $(function () {
        $('#minStock-close').on('click', function () {
            $('#minStock').hide('hide');
            $('body').removeClass('modal-open');
            $('#minStock').removeClass('show');
            $('body').removeAttr('style');
            $('#minStock').removeAttr('aria-modal');
            $('#minStock').removeAttr('style', 'padding-right');
            $('#minStock').css('display', 'none');
            $('#minStock').attr('aria-hidden', true);
            $('.modal-backdrop').remove();
        })
    })
</script>

<script>
    $(document).on("click", ".open-modal", function () {
     var eventId = $(this).data('id');
     var eventItem = $(this).data('item');
     var eventNama = $(this).data('nama');
     $('#id_plus').val( eventId );
     $('#id_item_plus').val( eventItem );
     $('#nama_item_plus').val( eventNama );
    });
</script>

<script>
    $(document).on("click", ".open-modal-min", function () {
     var eventId = $(this).data('id');
     var eventItem = $(this).data('item');
     var eventNama = $(this).data('nama');
     $('#id_min').val( eventId );
     $('#id_item_min').val( eventItem );
     $('#nama_item_min').val( eventNama );
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
