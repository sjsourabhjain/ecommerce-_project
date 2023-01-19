@if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>
        @foreach($errors->all() as $error)
            <strong><div>{{ $error }}</div></strong>
        @endforeach
</div>
@endif