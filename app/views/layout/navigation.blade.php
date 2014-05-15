<nav>
	<ul>
		<li><a href="{{ URL::route('home') }}">Home</a></li>
		<!-- Hide Create Account when user Logined -->
		@if(Auth::check())
			<li><a href="{{ URL::route('account-sign-out') }}">Sign Out</a></li>
			<li><a href="{{ URL::route('account-change-password') }}">Change Password</a></li>
		@else
			<li><a href="{{ URL::route('account-sign-in') }}">Sign in</a></li>
			<li><a href="{{ URL::route('account-create') }}">Create Account</a></li>
			<li><a href="{{ URL::route('account-forgot-password') }}">Forgot Password?</a></li>
		@endif
	</ul>
</nav>