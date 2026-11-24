<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в систему - Чудо Обувь</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h4 class="mb-0">Вход в систему</h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="/login">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Логин, телефон или Email</label>
                                <input type="text" name="login" class="form-control" value="{{ old('login') }}" required autofocus placeholder="Например: isivanov">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Пароль</label>
                                <input type="password" name="password" class="form-control" required placeholder="password">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Войти</button>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <a href="{{ route('catalog.index') }}" class="text-decoration-none">Вернуться в каталог</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>