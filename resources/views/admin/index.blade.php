@extends('master')

@section('title')
    Admin page
@endsection

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

@section('main-wrapper')
    @include('admin.page_content')
@endsection