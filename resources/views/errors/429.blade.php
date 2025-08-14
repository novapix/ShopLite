@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message')
    You have sent too many requests in a short period. Please wait a moment and try again.
@endsection

@section('action')
    <a href="{{ url('/') }}" class="btn">🏠 Back to Home</a>
@endsection
