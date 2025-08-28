@extends('backend.layout.main')
@push('title')
    Admin Dashboard
@endpush

@section('content')
Hello , {{ Auth::guard('admin')->user()->name }}
@endsection
