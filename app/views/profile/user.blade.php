@extends('layout.main')

@section('content')
  <h4>User Profile</h4>
  <p>{{ e($user->username) }}</P>
  <p>{{ e($user->email) }})</P>
@stop