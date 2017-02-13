@extends('layouts.master')

@section('title')
    Welcome to Social!
@stop

@section('content')

@include('partials.message-block')

    <h1>{{ $errors->first('email') }}</h1>
   <div class="row"> 
        <div class="col-md-6">
        <h3>Sign Up</h3>
            <form action="/signup" method="POST">
                {!! csrf_field() !!}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your E-Mail</label>
                    <input class="form-control " type="email" name="email" id="email" value="{{ old('email') }}">
                </div>

                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                    <label for="first-name">Your First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first-name" value="{{ old('first_name') }}">
                </div>

               <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Your Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{ old('password') }}">
               </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col-md-6">
          <h3>Sign In</h3>
            <form action="/signin" method="post">
                {!! csrf_field() !!}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Your E-Mail</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}">
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Your Password</label>
                    <input class="form-control" type="password" name="password" id="password" value="{{ old('password') }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@stop