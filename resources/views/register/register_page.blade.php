@extends('master')

@section('title')
    Register page
@endsection

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

@section('main-wrapper')
    @include('register.page_content')
@endsection