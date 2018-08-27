@if ($errors->any())
	<div class="alert bg-danger text-white">
		@foreach($errors->all() as $error)
			<p>{{$error}}</p>
		@endforeach
		
	</div>
@endif

@if (session('success'))
	<div class="alert bg-success alert-dismissible fade show text-white">
		<b>{{ session('success')}}</b>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true">&times;</span>
	  </button>
	</div>
@endif

@if (session('error'))
	<div class="alert bg-danger text-white alert-dismissible fade show" role="alert">
		<b>{{ session('error')}}</b>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    	<span aria-hidden="true">&times;</span>
	  </button>
	</div>
@endif

@if(isset($message))
<div class="invalid-feedback bg-info text-white alert-dismissible fade show" role="alert">
    <b>{{ $message }}</b>
</div>
@endif