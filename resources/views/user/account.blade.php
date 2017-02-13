@extends('layouts.master')

@section('title')
	Profile
@stop

@section('content')

@include('partials.message-block') 

	<section class="row new-post">
		<div class="col-md-6 col-md-offset-3">
			<header>
				<h3>Your Profile</h3>
			</header>
			<form action="{{ route('account.save') }}" method="POST" value="{{ $user->first_name }}" id="first_name" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="first_name">First Name</label>
					<input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" id="first_name">
				</div>
				<div class="form-group">
					<label for="image"> Image (Only .jpg)</label>
					<input type="file" name="upload" id="image">
				</div>
				<button type="submit" class="btn btn-primary">Save Account</button>
			</form>
		</div>
	</section>
	@if (Storage::disk('local')->has($user->first_name.'-'.$user->id.'.jpg'))
		<section class="row">
			<div class="col-md-6 col-md-offset-3">
				<img src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}" alt="" class="img-responsive">
			</div>
		</section>
	@endif

@stop