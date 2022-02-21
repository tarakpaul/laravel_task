<style type="text/css">
	.form-field:focus{border-color: red !important;} 
</style>
<!-- UIkit CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.10.1/dist/css/uikit.min.css" />
<!-- UIkit JS -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.10.1/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.10.1/dist/js/uikit-icons.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>     
<div class="uk-width-2X-Large">
	<div class=" uk-card-body uk-background-muted uk-text-center uk-width-2X-Large uk-position-center">
		<h3 class="uk-text-center uk-text-bold uk-text-danger">Login Form</h3>
		<p class="uk-text-bold uk-text-primary">User name:123 &nbsp;&nbsp;Password:123</p>
		<span id="loadingmessage"  class="uk-text uk-text-bold uk-text-center uk-text-success" style="position: relative;z-index:5000;display: none;">Please wait....
		</span>
		<form onsubmit="event.preventDefault(); login_check(this);" id="login_form">
			<div class="uk-margin-small">
				<input  class="uk-input form-field" required name="username" id="username" type="text"   placeholder="Enter Username" style="width: 450px;"><br/>
				<span class="uk-text uk-text-danger form_error" id="username_error"></span>
			</div>
			<div class="uk-margin-small">&nbsp;</div>

			<div class="uk-margin-small">
				<input class="uk-input form-field" required name="password" id="password" type="password"  placeholder="Enter Password"  style="width: 450px;"><br/>
				<span class="uk-text uk-text-danger form_error" id="password_error"></span>
			</div>
			<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
			<div class="uk-margin uk-margin-top-small">
				<button class="uk-button uk-button-primary" type="submit" id="div_busy"   style="width: 450px;">Login</button><br/>
			</div>				
			<div class="uk-margin-small"><span id="error_msg" class="uk-text-danger uk-text-bold"></span></div>
		</form>
	</div>
</div>
<script>
	function login_check(form){ 		
		var formdata = new FormData(form);
		$('#loadingmessage').show();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "{{route('login.check')}}",
			type: "post",
			processData: false,
			contentType: false,
			data: formdata,
			dataType: "json",
			success: function (response) {
				$('#loadingmessage').hide();
				$('.form_error').html('');
				$('#error_msg').html('');
				$('.form-field').css("border-color", '');
				if(response.type=='success'){
					window.location.replace("{{route('dashboard')}}");				
				}
				if(response.type=='login_error'){
					$('#error_msg').html(response.message);			
				}
				if(response.type=='validation_error'){
					$.each(response.errors,(field_name,err_val)=>{
						$('#'+field_name+'_error').html(err_val[0]);
						$('#'+field_name).css("border-color", "red")
					})
				}				
			},
			error: function(data) {
				console.log(data)
			}
		});
	}
</script>