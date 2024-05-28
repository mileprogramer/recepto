@extends('master')

@section('title')
    Edit recipe
@endsection

@section('css')
    @vite(['resources/scss/app.scss', 'resources/js/addMoreIngredients.js'])
@endsection

@section('main-wrapper')
    @include('partials.header')
    <div class="container">
        @include('recipe.form_edit_recipe', ["units"=>$units, "categories"=>$categories, "recipe"=>$recipe])
    </div>
@endsection