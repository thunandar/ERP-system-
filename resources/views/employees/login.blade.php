<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="{{ asset('css/login-style.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <div class="form">
                <div class="form-toggle"></div>
                <div class="form-panel one">
                    <div class="form-header">
                        <h1>Employee Registration</h1>
                    </div>
                    <!-- Login Form-->
                    <div class="form-content">
                        <form action="/check-validations" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Employee ID</label>
                                <input type="text" name="employee_id" />
                                @error('employee_id')
                                <span class="text-danger" id="login-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group eye">
                                <label for="">Password</label>
                                <input type="password" name="password" id="password-input" />
                                <i class="fas fa-eye" id="toggle-password" style="display: none;"></i>
                                @error('password')
                                <span class="text-danger" id="login-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" id="lg-btn">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form-panel two">
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    let passwordInput = document.getElementById('password-input');
    let icon = document.getElementById('toggle-password');

    // Show the eye icon when the password input field has content
    passwordInput.addEventListener('input', () => {
        if (passwordInput.value.length > 0) {
            icon.style.display = 'inline-block';
        } else {
            icon.style.display = 'none';
        }
    });

    // Toggle password visibility
    icon.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>

</html>