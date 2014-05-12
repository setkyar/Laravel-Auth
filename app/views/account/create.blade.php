@extends('layout.main')

@section('content')
	<form action="{{ URL::route('account-create-post') }}" method="post">
		<input type="submit" value="Create account">
		{{ Form::token() }}
	</form>
@stop