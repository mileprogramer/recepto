@include('partials.css')
@include('partials.header')
@include('home.hero')
@include('home.search', ["units"=> $units, "categories"=>$categories])