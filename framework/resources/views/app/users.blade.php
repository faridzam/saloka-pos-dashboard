@extends('layouts.app')

@push('styles')
<style>
.modal-backdrop {
    z-index: 1040 !important;
}
.modal-open {
    margin: 2px auto;
    z-index: 1100 !important;
}
</style>
@endpush

@section('title', 'Admin Dashboard')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>User Management</h1>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-12">
            <div class="card">
                <form id="formData">
                    <div class="card-body">
                    <label for="provi">Jenis User : </label></br>
                      
                        <select class="custom-select" style="width: 49.5%; margin-bottom: 1rem;" id="userType" name="userType" required>
                          <option selected>-- Silahkan Pilih Jenis User --</option>
                          <option value="kasir">Kasir</option>
                          <option value="dashboard">Dashboard</option>
                        </select>
                      
                        <div class="form-group">
                        <table id="tableIndex" class="table table-striped table-bordered display nowrap" style="width: 100%">
                          <thead clas="bg-dark">
                            <tr>
                              <th style="width: 40%;">username</th>
                              <th style="width: 40%;">password</th>
                              <th style="width: 15%;">edit user</th>
                              <th style="width: 15%;">hapus user</th>
                            </tr>
                          </thead>
                          <tbody id="users-table">
                                
                          </tbody>
                          <tfoot >
                            <tr>
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
                        <a class="btn btn-block btn-success" id="iExportSelect" data-toggle="modal" data-target="#createUser"><i class="fas fa-file-export mr-2"></i>Create User</a>
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
  
  <div class="modal-create">
      @include('app.modals.createUser')
  </div>
@endsection

@push('scripts')

<script>
  $(document).ready(function(){

   fetch_customer_data();

   function fetch_customer_data(userType = $('#userType').val())
   {
    $.ajax({
     url:"dashboardUsers-search",
     method:'GET',
     data:{userType:userType},
     dataType:'json',
     success:function(data)
     {
      $('#users-table').html(data.table_data);
     }
    })
   }

   $(document).on('change', 'input', function(){
    var userType = $('#userType').val();
    fetch_customer_data(userType);
   });
   $(document).on('change', 'select', function(){
    var userType = $('#userType').val();
    fetch_customer_data(userType);
   });
  });
</script>

<script>
  $(document).ready(function () {
  $('#tableIndex').DataTable({
  "scrollY": "300px",
  "scrollCollapse": true,
  "paging":   false,
  "searching":   false,
  "info":   false,
  "ordering":   false,
  ajax: "{{ route('dashboardVoidTransaksi.search')}}",
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
    function confirmation() {
  return confirm('Yakin menghapus user?');
}
</script>

<script>
    $("#remove-user").on('click', function (e) {
        e.preventDefault();
        var ele = $(this);
        swal.fire({
            title: "Hapus User",
            text: "Apakah anda yakin akan menghapus user?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "YA",
            cancelButtonText: "TIDAK",
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: '{{ route('dashboardUsers.destroy', '1') }}',
                    method: "GET",
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        window.location.href = '{{ route('dashboardUsers.index') }}'
                    }
                });
            }
        }
    );
    });
</script>

@endpush