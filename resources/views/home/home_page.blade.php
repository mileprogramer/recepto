@extends('master')

@section('title')
    Home page
@endsection

@section('css')
    @vite(['resources/css/app.css', 'resources/js/addIngredient.js'])
@endsection

@section('main-wrapper')
    @include('home.page_content', ["units"=> $units, "categories"=>$categories])
@endsection