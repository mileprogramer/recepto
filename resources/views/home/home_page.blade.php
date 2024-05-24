@extends('master')

@section('title')
    Home page
@endsection

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

@section('main-wrapper')
    @include('home.page_content')
@endsection