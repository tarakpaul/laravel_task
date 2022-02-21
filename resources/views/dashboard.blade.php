@include('partials.header')
<div class="uk-padding uk-padding-small">
	<p class="uk-text-bold">Total State: {{$dashboard_data['total_state']}}</p>
	<p class="uk-text-bold">Total User: {{$dashboard_data['total_user']}}</p>
	<h1 class="uk-text uk-text-success uk-text-bold uk-text-center uk-padding  uk-margin-large-top ">Welcome To The Laravel Project</h1>
	<h3 class="uk-text uk-text-center uk-text-bold">Technology Used: <span class="uk-text-danger">HTML, CSS, jQuery, JavaScript, UIkit, Ajax, Laravel & MySQL.</span></h3>
	<p class="uk-text uk-text-center uk-text-bold" style="color:red">Have a nice day !</p>
</div>
@include('partials.footer')



