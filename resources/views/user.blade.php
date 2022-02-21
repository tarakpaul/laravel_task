@include('partials.header')
<style type="text/css">
	.form-field:focus{border-color: red !important;} 
</style>
<!-- Form modal -->
<div id="form_modal" class="uk-modal-container" uk-modal>
	<div class="uk-modal-dialog uk-width-small">
		<button class="uk-modal-close-default uk-text-danger" type="button" uk-close></button>
		<div class="uk-card uk-card-default uk-card-small">			
			<div class="uk-card-header">
				<h4 id="booking_title" class="uk-text-large uk-text-bold" >Add User</h4> 
			</div>
			<form   onsubmit="event.preventDefault(); user_edit_and_save(this);" id="user_form">
				<div class="uk-card-body">
					<div class="uk-child-width-1-2@m" uk-grid>
						<div>
							
							<div class="uk-margin-small ">
								Name:<input value="" type="text" name="name" id="name" class="uk-input form-field"   placeholder="Enter Name" />
								<span class="uk-text uk-text-danger form_error" id="name_error"></span>
							</div>
							<div class="uk-margin-small ">
								Email:<input value="" type="text" name="email" id="email" class="uk-input form-field"  placeholder="Enter Email"/>
								<span class="uk-text uk-text-danger form_error" id="email_error"></span>

							</div>
							<div class="uk-margin-small ">
								Password:<input value="" type="text" name="password" id="password" class="uk-input form-field"  placeholder="Enter Password" />
								<span class="uk-text uk-text-danger form_error" id="password_error"></span>

							</div>	
							<div class="uk-margin-small ">
								Gender:
								<input type="radio" name="gender" id="male" class="form-field" value="Male" >  Male
								<input type="radio" name="gender" id="female"  class="form-field" value="Female"> Female 
								<span class="uk-text uk-text-danger form_error" id="gender_error"></span>


							</div>							
							<div class="uk-text-center uk-margin">
								<input type="submit" value="Save" class="uk-button uk-button-primary" />
							</div>
						</div>
						<div>						

							<div class="uk-margin-small ">
								Phone No:<input value="" type="text" name="phone_no" id="phone_no" class="uk-input form-field"  placeholder="Enter Phone No"  maxlength="10" minlength="10" pattern="[0-9]{10}" title="Please enter exactly 10 digits." />
								<span class="uk-text uk-text-danger form_error" id="phone_no_error"></span>

							</div>
							<div class="uk-margin-small ">
								Alternate Phone No:<input value="" type="text" name="alternate_phone_no" id="alternate_phone_no" class="uk-input form-field" placeholder="Enter Alternate Phone No" maxlength="10" minlength="10" pattern="[0-9]{10}" title="Please enter exactly 10 digits."/>
							</div>
							<div class="uk-margin-small ">
								State: <select name="state_id" id="state_id" class="uk-select form-field" >
									<option value="">Select State</option>
									@foreach($state_a as $state_val)
									<option value="{{$state_val->id}}">{{$state_val->state_name}}</option>
									@endforeach	
								</select>
								<span class="uk-text uk-text-danger form_error" id="state_id_error"></span>
							</div>
							<div class="uk-margin-small">
								Photo: <input class="form-field" type="file" name="image" value=""  id="image"/><br/>
								<span class="uk-text uk-text-danger form_error" id="image_error"></span>
							</div>
						</div>
					</div>
				</div>   
			</form>     
		</div>
	</div>
</div>
<!--End Form modal -->

<div id="loadingmessage"  class="uk-text uk-text-bold uk-text-center  uk-text-danger uk-padding" style="position: relative;z-index:5000;display: none;">Please wait....
</div>
<div class="uk-padding uk-padding-small">
	<h3 class="uk-margin-small uk-text-bold uk-text-warning">Manage User</h3> 
	<div>
		<div class="uk-inline uk-margin-small-bottom">
			<input type="text" id="search_by_name" name="search_by_name" style="width: 350px;" class="uk-input" placeholder="Search By Name" />
		</div>
		<div class="uk-inline uk-margin-small-bottom">
			<input type="button" onclick="user_listing();" value="Search" style="cursor:pointer;" class="uk-button uk-button-primary"/>&nbsp;
			<input type="button" value="Reset" onclick="$('#search_by_name').val('');user_listing();" style="cursor:pointer;" class="uk-button uk-button-danger"/>&nbsp;
			<input type="button" value="Add User" onclick="formReset();" style="cursor:pointer;background-color: #0da50b" class="uk-button uk-button-secondary"  />
		</div>
	</div>		
</div>
<div class="uk-padding uk-padding-small">
	<div id="state_list_div" class="state_list_div_class">&nbsp; </div>
	<h4 class="uk-text uk-text-bold">Total : <sapn id="total_val"></sapn></h4>
	<table class="uk-table uk-table-small uk-table-striped uk-table-responsive uk-table-hover" >
		<thead>
			<tr>						
				<td >#</td>
				<td ><b>Name</b></td>
				<td ><b>Image</b></td>
				<td ><b>Email</b></td>
				<td ><b>Password</b></td>
				<td ><b>Gender</b></td>  
				<td ><b>Phone No</b></td>  
				<td ><b>Alternate No</b></td>
				<td ><b>State</b></td>												
			</tr>
		</thead>
		<tbody>

		</tbody>

	</table>
</div>	

<script type="text/javascript">	
	user_listing();
	function user_listing(){
		let search_by_name=$("#search_by_name").val();	
		$('#total_val').html('<strong class="uk-text-danger">Loading...</strong>');		
		$.ajax({    
			type: "GET",
			url: "user_listing/"+search_by_name.trim(),            
			dataType: "json",                   
			success: function(response){
				var i=1;				
				$('#total_val').html(response.count);
				let data="";
				$.each(response.data,(key,value)=>{
					var img_val=value.image?'<img alt="user_image" width="50px;" height="50px;" src="uploads/user_image/'+value.image+'" />':'';
					data+=`<tr>
					<td >${i}</td>
					<td ><b>${value.name}</b></td>
					<td>${img_val}</td>
					<td ><b>${value.email}</b></td>
					<td ><b>${value.password}</b></td>
					<td ><b>${value.gender?value.gender:''}</b></td>
					<td ><b>${value.phone_no?value.phone_no:''}</b></td>
					<td ><b>${value.alternate_phone_no?value.alternate_phone_no:''}</b></td>
					<td ><b>${value.state_name?value.state_name:''}</b></td>					
					</tr>`;
					i++;
				})
				var no_data_val=`<tr>\
				<td colspan="8">\
				<span class="uk-text-bold uk-text-danger">Sorry no data found.</span>\
				</td>\
				</tr>`;
				response.data.length>0?$('tbody').html(data):$('tbody').html(no_data_val);
				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	}	
	function user_edit_and_save(form){ 
		var formdata = new FormData(form);	
		let gender_val='';
		if($("#male").prop("checked")){
			gender_val='Male';
		}
		if($("#female").prop("checked")){
			gender_val='Female';
		}		
		formdata.append('gender',gender_val);
		$('#loadingmessage').show();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "user_save",
			type: "post",
			processData: false,
			contentType: false,
			data: formdata,
			dataType: "json",
			success: function (response) {
				$('#loadingmessage').hide();
				$('.form_error').html('');
				$('.form-field').css("border-color","");
				if(response.status==400){					
					$.each(response.errors,(field_name,err_val)=>{
						$('#'+field_name+'_error').html(err_val[0]);
						$('#'+field_name).css("border-color", "red")
					})
				}
				else{
					alert(response.message);
					user_listing();
					$('.form-field').val('');
					$('input[name="gender"]').prop('checked', false);				
				}				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR)
			}
		});
	}
	function formReset(){ 
		$('.form-field').val('');
		$('.form_error').html('');
		$('.form-field').css("border-color","");
		$('input[name="gender"]').prop('checked', false);
		UIkit.modal('#form_modal').show();
	}	

</script>
