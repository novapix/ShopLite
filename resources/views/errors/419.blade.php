@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message')
    Sorry, your session has expired. Please refresh the page and try again.
@endsection

@section('action')
    <a href="{{ url()->current() }}" class="btn">🔄 Refresh Page</a>
@endsection
