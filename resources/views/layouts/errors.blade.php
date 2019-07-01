
@if(session()->has('message'))
    <div class="alert alert-success"  role="info">
        {{ session()->get('message') }}
    </div>
@elseif(session()->has('success'))
    <div class="alert alert-success" role="success" id="success">
        {{ session()->get('success') }}
    </div>
@elseif(session()->has('info'))
    <div class="alert alert-info" role="info">
        {{ session()->get('info') }}
    </div>
@elseif($errors->any())
<div class="alert alert-info" role="alert">
    @foreach ($errors->all() as $error)
        <p>{{ $error }} &nbsp; </p>

    @endforeach
</div>
@endif