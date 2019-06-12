
@if(session()->has('message'))
    <div class="alert alert-info" role="info">
        {{ session()->get('message') }}
    </div>
@endif

@if(session()->has('info'))
    <div class="alert alert-info" role="info">
        {{ session()->get('info') }}
    </div>
@endif


@if($errors->any())
<div class="alert alert-info" role="alert">
    @foreach ($errors->all() as $error)
        <p>{{ $error }} &nbsp; </p>
    
    @endforeach
</div>
@endif