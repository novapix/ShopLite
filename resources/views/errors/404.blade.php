@extends('errors::minimal')

@section('title', __('Page Not Found'))
@section('code', '404')
@section('message', __('The page you’re looking for doesn’t exist.'))

@section('action')
    <a href="{{ url('/') }}" class="btn">← Back to Home</a>
@endsection
