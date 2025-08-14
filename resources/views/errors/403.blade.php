@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')
    You don’t have permission to access this resource.
@endsection

@section('action')
    <a href="{{ url()->previous() }}" class="btn">← Go Back</a>
@endsection
