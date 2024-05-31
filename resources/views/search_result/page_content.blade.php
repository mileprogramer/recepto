@extends('master')

@section('title')
    Search page
@endsection

@section('css')
    @include('partials.css')
    @vite(['resources/css/app.css'])
@endsection

@section('main-wrapper')
    @include('search_result.recipes', ["recipes"=>$recipes])
@endsection