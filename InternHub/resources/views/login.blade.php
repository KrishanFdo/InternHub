<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InturnHub-DCS | Login</title>
    <link rel="stylesheet" href="{{ asset('css/log.css') }}">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="reg ">
        <img src="">
        <div class="container">


            <form action="<?=url('/authenticate')?>" method="POST">
            <div class="form-reg shadow p-3 mb-5 bg-white rounded">
                <h5 class="welcome-text text-center">WELCOME TO InturnHub-DCS</h5>
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
                <div class="welcome-form text-center">
                    @csrf

                    <input type="text" placeholder="Email" class="form-control" name="email"><br />
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <input type="password" placeholder="Password" class="form-control" name="password"><br>
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <select class="form-select" name="role">
                     <option value="user" selected>User</option>
                      <option value="admin">Admin</option>
                     </select>
                    <input type="submit" name="submit" class="btn btn-success mt-3" value="Login">
                    <p class="text-center text-muted mt-3 mb-0">Not Registered ?
                        <a href="<?=url('register')?>"><u>Register</u></a>
                    </p>
                </div>
            </div>
            </form>
        </div>
    </div>

</body>

</html>
