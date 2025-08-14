@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message')
    Sorry, the service is temporarily unavailable. Please check back soon.
@endsection

@section('action')
    <a href="{{ url('/') }}" class="btn">🏠 Back to Home</a>
@endsection
