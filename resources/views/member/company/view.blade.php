@extends('admin.app')
@push('styles')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush
@section('content')
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <h2>{{ $company->name }}</h2>
        </div>
    </div>
    {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link {{ $tab == 'users' ? 'active':'' }}" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Users</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{ $tab == 'urls' ? 'active':'' }}" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Generated URLs</button>
  </li>
</ul> --}}
<div>
        <button class="btn btn-primary float-end" id="generate-url">Generate Short URL</button>
    </div>
    <div class="clearfix"></div>
    <div class="row mt-2">
        <div class="col-12">
            <table class="table table-hover table-striped" id="url-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>Short URL</th>
                        <th>Original URL</th>
                        <th>Hits</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"></h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>

@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $('#invite-client').click(() => {
            $('#staticBackdrop').modal('show')
            $('#staticBackdrop').find('.modal-header .modal-title').text('Invite User');
            $('#staticBackdrop').find('.modal-body').html(`<div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`);
            $.get("{{ route('company.users.invite.form',$company->id) }}").then((resp) =>{
                $('#staticBackdrop').find('.modal-body').html(resp);
            })
        })

        $('#generate-url').click(() => {
            $('#staticBackdrop').modal('show')
            $('#staticBackdrop').find('.modal-header .modal-title').text('Generate Short URL');
            $('#staticBackdrop').find('.modal-body').html(`<div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`);
            $.get("{{ route('company.generate.short.url.form',$company->id) }}").then((resp) =>{
                $('#staticBackdrop').find('.modal-body').html(resp);
            })
        })
    </script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('company.users',$company->id) }}',
            columns: [
                { data: 'name', name: 'name'},
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
            ]
        });

        $('#url-table').DataTable({
            processing: true,
            serverSide: true,
            width:"100%",
            ajax: '{{ route('company.urls',$company->id) }}',
            columns: [
                { data: 'short_code', name: 'short_code'},
                { data: 'original_url', name: 'original_url' },
                { data: 'hits', name: 'hits' },
            ]
        });
      })
    </script>
@endpush