<form action="{{ route('company.users.invite',$company->id) }}" method="post">
    @csrf
<div class="form-group mt-2">
    <label for="">Name</label>
    <input type="text" class="form-control"  name="name">
</div>

<div class="form-group mt-2">
    <label for="">Email</label>
    <input type="text" class="form-control"  name="email">
</div>

<div class="form-group mt-2">
    <label for="">Role</label>
    <select class="form-control" name="role">
        @foreach ($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select>
</div>

<div class="d-flex justify-content-end mt-2">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>&nbsp;
    <button type="submit" class="btn btn-primary">Invite</button>
</div>
</form>

<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\InviteUsersRequest') !!}
