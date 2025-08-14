@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message')
    You are not authorized to view this page. Please login to continue.
@endsection

@section('action')
    <a href="{{ route('login') }}" class="btn">🔐 Login</a>
@endsection
