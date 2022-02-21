@include('partials.header')
<style type="text/css">
	.form-field:focus{border-color: red !important;} 
</style>
<div class="uk-padding uk-padding-small">
	<h3 class="uk-margin-small uk-text-bold uk-text-warning">Manage State</h3> 
	<div>
		<div class="uk-inline uk-margin-small-bottom">
			<input type="text" id="state_id" name="state_id"  class="uk-input form-field uk-hidden" />
			<input type="text" id="state_name" name="state_name" style="width: 350px;"   class="uk-input form-field" placeholder="Enter state name"  />&nbsp;&nbsp;
		</div>
		<div class="uk-inline uk-margin-small-bottom">			
			<input type="button" value="Save" onclick="state_edit_and_save();" style="cursor:pointer;background-color: #0da50b" class="uk-button uk-button-secondary"  />
		</div>
	</div>		
</div>
<div class="uk-padding uk-padding-small">
	<div id="state_list_div" class="state_list_div_class">&nbsp; </div>
	<h4 class="uk-text uk-text-bold">Total : <span id="total_state"></span></h4>
	<table class="uk-table uk-table-small uk-table-striped uk-table-responsive uk-table-hover" >
		<thead>
			<tr>						
				<td >#</td>
				<td><b>Action</b></td>			
				<td ><b>State Name</b></td>													
			</tr>
		</thead>
		<tbody>

		</tbody>
		
	</table>
</div>	

<script type="text/javascript">
	state_listing();
	function state_listing(){
		$('tbody').html('<strong class="uk-text-danger">Loading...</strong>');
		$.ajax({    
			type: "GET",
			url: "state_listing",            
			dataType: "json",                   
			success: function(response){
				var i=1;
				let data="";
				$('#total_state').html(response.total_state);
				$.each(response.state_a,(key,value)=>{
				data+=
					'<tr>\
					<td >'+i+'</td>\
					<td>\
					<span uk-tooltip="title:Delete; delay: 100">\
					<a class="uk-text-danger"  uk-icon="icon: trash" onclick="delete_state('+value.id+')"></a>\
					</span>\
					</td>\
					<td ><b>'+value.state_name+'</b></td>\
					</tr>';
					i++;
				})
				$('tbody').html(data);

			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	}	
	function state_edit_and_save(form){ 

		var formdata = new FormData(form);			
		let state_name_val=$('#state_name').val();
		// if(!state_name_val.trim()){
		// 	alert('Please enter state name.');
		// 	$('#state_name').focus();
		// 	return false;
		// }
		let state_id_val=$('#state_id').val();
		formdata.append('state_name',state_name_val);
		formdata.append('state_id',state_id_val);
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: "state_save",
			type: "post",
			processData: false,
			contentType: false,
			data: formdata,
			dataType: "json",
			success: function (response) {
				if(response.status==400){
					$.each(response.errors,(key,value)=>{
						alert(value);
					})
				}
				else{
					alert(response.message);
					state_listing();
					$('.form-field').val('');
				}
				
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR)
			}
		});
	}

	function delete_state(state_id){
		var formdata = new FormData();
		var p =confirm('Are you Sure? You want to delete this record forever.')
		if(p){		
			formdata.append('state_id',state_id );
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "delete_state",
				type: "post",
				processData: false,
				contentType: false,
				data: formdata,
				dataType: "json",
				success: function (response) {
					alert(response.message);
					state_listing();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(jqXHR,textStatus, errorThrown);
				}
			});

		}
	}
</script>
