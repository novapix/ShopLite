@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    Oops! Something went wrong on our end. Please try again later.
@endsection

@section('action')
    <a href="{{ url('/') }}" class="btn">🏠 Back to Home</a>
@endsection
