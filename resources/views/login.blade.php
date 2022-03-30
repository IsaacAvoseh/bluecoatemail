<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://bluecoat.ng/images/logo.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                BlueCoat
            </a>
            @if(Auth::user())
            <form action="/logout" method="POST">
                @csrf
                <button class="btn btn-outline-success" type="submit">LogOut</button>
            </form>
            @else
            <form action="/" method="POST">
                @csrf
                <button class="btn btn-outline-success" type="submit">Login</button>
            </form>

            @endif
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Login</h1>

                @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
                @endif


                <form method="POST">
                    @csrf
                    <div class="form-group m-3">
                        <label for="email">Email</label>
                        <input value="{{ old('email') }}" type="text" class="form-control" id="email" name="email" placeholder="Email">
                        <span class="text-danger">@error ('email') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group m-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <span class="text-danger">@error ('password') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group m-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>