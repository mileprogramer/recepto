<div class="container">
    @if (isset($success))
        <div class="alert alert-success">
            {{ $success }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
            @endforeach    
        </div>
    @endif
    <form action="/register" method="POST">
        @csrf
        <div class="form-group">
            <p>Type your first name</p>
            <input class="form-control" type="text" name="first_name">
            <p>Type your last name</p>
            <input class="form-control" type="text" name="last_name">
            <p>Type your email</p>
            <input class="form-control" type="email" name="email">
            <p>Type your password</p>
            <input class="form-control" type="password" name="password">
        </div>
        <button class="btn btn-primary my-3">Register</button>
    </form>
</div>