<div class="container">
    <form action="/login" method="POST">
        @csrf
        <div class="form-group">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <p>{{ $error }}</p>
                    </div>  
                @endforeach
            @endif
            <p>Type your email</p>
            <input class="form-control" type="email" name="email">
            <p>Type your password</p>
            <input class="form-control" type="password" name="password">
        </div>
        <button class="btn btn-primary my-3">Login</button>
    </form>
</div>