<form action="{{ route('company.generate.short.url',$company->id) }}" method="post">
    @csrf
    <div class="form-group mt-2">
        <label for="">Origin Url</label>
        <input type="url" class="form-control"  name="original_url">
    </div>

    <div class="form-group mt-2">
        <label for="">Short Code</label>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">{{ config('app.url').'/' }}</span>
            <input type="text" class="form-control" placeholder="Short Code" aria-label="Username" aria-describedby="basic-addon1" name="short_code">
        </div>
    </div>

    <div class="d-flex justify-content-end mt-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>&nbsp;
        <button type="submit" class="btn btn-primary">Invite</button>
    </div>
</form>

<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Admin\ShortUrlRequest') !!}
