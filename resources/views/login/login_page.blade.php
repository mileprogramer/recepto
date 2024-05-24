@extends('master')

@section('title')
    Login page
@endsection

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

@section('main-wrapper')
    @include('login.page_content')
@endsection