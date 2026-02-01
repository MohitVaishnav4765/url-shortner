@extends('admin.app')
@push('styles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush
@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <h2>Companies</h2>
        </div>
        @role('SuperAdmin')
        <div class="col-lg-6 col-md-6 col-sm-12 text-right">
            <button class="btn btn-primary float-end" id="invite-client">Invite</button>
        </div>
        @endrole
    </div>
    <div class="row mt-2">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <table class="table table-hover table-striped" id="datatable">
          <thead>
            <tr>
              <th>Name</th>
              <th>Users</th>
              <th>Total Generated URLs</th>
              <th>Total URL Hits</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Invite Client</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script>
  </script>
    <script>
      $(function() {
        $('#invite-client').click(() => {
          $('#staticBackdrop').modal('show')
          $('#staticBackdrop').find('.modal-body').html(`<div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>`);
          $.get("{{ route('company.invite.admin') }}").then((resp) =>{
            $('#staticBackdrop').find('.modal-body').html(resp);
          })
        })
        $('#datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route('dashboard') }}',
          columns: [
            { data: 'name', name: 'name'},
            { data: 'users_count', name: 'users_count' },
            { data: 'urls_count', name: 'urls_count' },
            { data: 'urls_sum_hits', name: 'urls_sum_hits' },
            { data: 'action', name: 'action' },
          ]
        });
      })
    </script>
@endpush