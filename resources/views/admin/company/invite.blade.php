@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
<form action="{{ route('company.invite.admin.send') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Company Name</label>
        <input type="text" class="form-control"  name="company_name">
    </div>

    <div class="form-group mt-2">
        <label>Admin Details</label>
        <div>
            <input type="radio" class="btn-check" name="admin_type" id="success-outlined" autocomplete="off" checked value="EXISTING">
            <label class="btn btn-outline-primary" for="success-outlined">Select From Existing Admins</label>
            <input type="radio" class="btn-check" name="admin_type" id="danger-outlined" autocomplete="off" value="NEW">
            <label class="btn btn-outline-primary" for="danger-outlined">Create New Admin</label>
        </div>
    </div>

    <div id="existing-admins" class="form-group mt-2">
        <label for="admin_id">Select Admin</label>
        <select name="admin_id" class="form-control select2" id="admin_id">
            @foreach ($admins as $admin)
                <option value="{{ $admin->id }}">{{ $admin->name }} ({{ $admin->email }})</option>
            @endforeach
        </select>
    </div>

    <div id="new-admin">
        <div class="form-group mt-2">
            <label for="">Name</label>
            <input type="text" class="form-control"  name="user_name">
        </div>
        <div class="form-group mt-2">
            <label for="">Email</label>
            <input type="text" class="form-control"  name="user_email">
        </div>
    </div>


    <div class="d-flex justify-content-end mt-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>&nbsp;
        <button type="submit" class="btn btn-primary">Invite</button>
    </div>
</form>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Admin\InviteCompanyAdminRequest') !!}
<script>
    $(()=>{
        toggleAdmins('EXISTING');

        $('input[name="admin_type"]').change((e)=>{
            toggleAdmins(e.target.value);
        })
    })

    function toggleAdmins(value){
        if(value == 'EXISTING'){
            $('#existing-admins').show();
            $('#new-admin').hide();
        }else if(value == 'NEW'){
            $('#new-admin').show();
            $('#existing-admins').hide();
        }
    }
</script>


