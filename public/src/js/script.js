var postId;
var postElement;

$('.edit-post').on('click', function(e){
	e.preventDefault();
	$('#myModal').modal();
	postElement = this.parentNode.parentNode.firstElementChild;
	postId = this.parentNode.parentNode.dataset.postid;
	var postBody = postElement.innerText;

	$('#post-body').val(postBody);
});		


$('#post-save').on('click', function(){
	$.ajax({
		'method': 'POST',
		'url': urlEdit,
		'data': { 
			'body': $('#post-body').val(),
			'postId': postId,

		},
	})
	.done(function(data){
		$(postElement).text(data.newPost);
		$("#post-body").modal('hide');
	});

});

$('.like').on('click', function(event){
	event.preventDefault(); 
	event.stopPropagation(); 

	postId = this.parentNode.parentNode.dataset.postid;

	var isLike = event.currentTarget.previousElementSibling == null ? true : false; 
	console.log(isLike);

	$.ajax({
		'method': 'POST',
		'url': urlLike,
		'data':{ 
			'is_like' : isLike, 
			'post_id' : postId,
		}
	}).done(function(data){
		console.log('response is: ' + data.like_type);

		event.target.innerText = isLike ? event.target.innerText === 'Like' ? 'You liked this' : 'Like' : event.target.innerText === 'Dislike' ? 'You disliked this' : 'Dislike';
		switch(isLike){
			case true: 
				event.target.nextElementSibling.innerText = 'Dislike';
				break;
			case false:
				event.target.previousElementSibling.innerText = 'Like';
		}
	});
});


/* ------- Header Setup ------- */
$(function(){
	$.ajaxSetup({
	    'headers': {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		 }
	});
});

