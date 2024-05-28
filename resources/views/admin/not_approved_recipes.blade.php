@vite(['resources/scss/app.scss', 'resources/js/openModal.js'])
@include('partials.header')
@include('admin.table', ["recipes"=>$recipes, "approved_view"=>false])