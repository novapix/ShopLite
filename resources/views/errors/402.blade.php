@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
@section('message')
    You need to complete payment to access this resource.
@endsection

@section('action')
    <a href="{{ url('/billing') }}" class="btn">💳 Go to Billing</a>
@endsection
