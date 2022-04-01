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
      <h1>Master Store</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                    <div class="card-body">
                        <div class="form-group">

                        </div>
                        <div class="form-group">
                        <table id="tableIndex" class="table table-striped table-bordered display nowrap sortable">
                          <thead clas="bg-dark">
                            <tr>
                              <th style="width: 10%;">ID Store</th>
                              <th style="width: 10%;">Kode Store</th>
                              <th style="width: 20%;">Nama Store</th>
                              <th style="width: 10%;">Menu Store</th>
                              <th style="width: 5%;" >Edit</th>
                              <th style="width: 5%;" >Hapus</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($stores as $store)
                                <tr>
                                    <td style="width: 10%;" data-value="{{ $store->id_store }}">{{$store->id_store}}</td>
                                    <td style="width: 10%;" data-value="{{ substr($store->kode_store, 4) }}">{{substr($store->kode_store, 4)}}</td>
                                    <td style="width: 20%;" data-value="{{ $store->nama_store }}">{{$store->nama_store}}</td>
                                    <td style="width: 10%;" data-value="{{ $store->menu_store }}">{{$store->menu_store}}</td>
                                    <td style="width: 5%;" > - </td>
                                    <td style="width: 5%;" > - </td>
                                </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <div class="row justify-content-end">
                        <div class="col-sm-12 col-lg-2 mt-2 mt-lg-0">
                        <a type="button" class="btn btn-block btn-success" id="iExportSelect" data-toggle="modal" data-target="#addStore"><i class="fas fa-file-export mr-2"></i>Tambah Store</a>
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
    </div>
  </section>

    <div class="modal-add">
        @include('app.modals.addStore')
    </div>

@endsection

@push('scripts')

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
