@extends('layouts.master')

@section('content')
@include('partials.message-block')
<section class="row new-post">
	<div class="col-md-6 col-md-offset-3">
		<header>
			<h3>What do you have to say?</h3>
		</header>
		<form action="/post" method="POST">
		{!! csrf_field() !!}
			<div class="form-group">
				<textarea autofocus name="body" class="form-control" id="new-post" placeholder="Your Post" rows="5"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Create Post</button>
		</form>
	</div>
</section>
<section class="row posts">
	<div class="col-md-6 col-md-offset-3">
		<header><h3>What other people say...</h3></header>

		@foreach($posts as $post)
			<article class="post" data-postid="{{ $post->id }}">
				<p>{{ $post->body }}</p>
				<div class="info">
					Posted By {{ $post->user->first_name }} on {{ $post->created_at }} 
				</div>
				<div class="interaction">
					<a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like_type == 1 ? 'You liked this' : 'Like' : 'Like'}}</a> | 
					<a href="#" class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like_type == 0 ? 'You disliked this' : 'Dislike' : 'Dislike'}}</a> 

					@if(Auth::user() == $post->user)
					| <a href="" class="edit-post">Edit</a> |
					<a href="{{ route('post.delete', ['$id' => $post->id ]) }}">Delete</a>
					@endif
				</div>
			</article>
		@endforeach

	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Post</h4>
      </div>
      <div class="modal-body">
        <form>
        	<div class="form-group">
        		<label for="post-body">Edit Your Post</label>
        		<textarea class="form-control" name="post-body" id="post-body" cols="30" rows="10"></textarea>	
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="post-save" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
	var urlEdit ='{{ route('edit') }}';
	var urlLike = '{{ route('like') }}';
</script>
@stop