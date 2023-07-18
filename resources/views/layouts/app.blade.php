<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Link to Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!-- Navbar  -->
                <nav class="navbar navbar-expand-lg" id="navbar">
                    <div class="container-fluid">
                        <h4 id="nav_header">
                            {{ trans('messages.nav_header') }}
                        </h4>
                        <ul class="navbar-nav mx-3">
                            <li class="nav-item mx-3">
                                <form action="/languages" method="post">
                                    @csrf
                                    <div class="dropdown">
                                        <select class="form-select form-select-sm" name="locale" onchange="this.form.submit()">
                                            <option value="en" @if(app()->getLocale() == 'en') selected @endif> English</option>
                                            <option value="my" @if(app()->getLocale() == 'my') selected @endif>မြန်မာ</option>
                                        </select>
                                    </div>
                                </form>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-3" href="/show-forms">{{ trans('messages.register') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-3" href="/show-employees">{{ trans('messages.list') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-3" href="/show-employees" style="pointer-events: none; cursor: not-allowed;">ID: {{ session('employee')->employee_id }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="#"><button type="submit" class="btn btn-primary btn-logout" data-bs-toggle="modal" data-bs-target="#logoutModal">{{ trans('messages.logout') }}</button></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        @yield('main')
        <!-- Logout Modal Box  -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('messages.confirmation') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ trans('messages.logout_message') }}
                    </div>
                    <div class="modal-footer">
                        <a href="#"><button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">{{ trans('messages.cancel') }}</button></a>
                        <a href="/logout"><button type="button" class="btn btn-primary px-5">{{ trans('messages.ok') }}</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JS  -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- jQuery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>