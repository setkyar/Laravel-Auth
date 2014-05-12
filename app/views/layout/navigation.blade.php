<nav>
	<ul>
		<li><a href="{{ URL::route('home') }}">Home</a></li>
		<!-- Hide Create Account when user Logined -->
		@if(Auth::check())

		@else
			<li><a href="{{ URL::route('account-create') }}">Create Account</a></li>
		@endif
	</ul>
</nav>