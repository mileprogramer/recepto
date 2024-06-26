@extends('master')

@section('title')
    Add recipe
@endsection

@section('css')
    @vite(['resources/scss/app.scss', 'resources/js/addMoreIngredients.js'])
@endsection

@section('main-wrapper')
    @include('partials.header')
    <div class="container">
        @include('recipe.form_add_recipe', ["units"=>$units, "categories"=>$categories])
    </div>
@endsection