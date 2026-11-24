<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a href="/catalog" class="navbar-brand">Чудо Обувь</a>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-light">Выйти</button></form>
        </div>
    </nav>
    <div class="container">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">Редактировать профиль</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf @method('PUT')
                            <div class="mb-2"><label>Фамилия</label><input type="text" name="last_name" class="form-control" value="{{ auth()->user()->last_name }}" required></div>
                            <div class="mb-2"><label>Имя</label><input type="text" name="first_name" class="form-control" value="{{ auth()->user()->first_name }}" required></div>
                            <div class="mb-2"><label>Отчество</label><input type="text" name="middle_name" class="form-control" value="{{ auth()->user()->middle_name }}"></div>
                            <div class="mb-2"><label>Телефон</label><input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}"></div>
                            <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}"></div>
                            
                            <hr>
                            <p class="text-muted small">Смена пароля (если не нужно - оставьте пустым)</p>
                            <div class="mb-2"><input type="password" name="password" class="form-control" placeholder="Новый пароль"></div>
                            <div class="mb-3"><input type="password" name="password_confirmation" class="form-control" placeholder="Повтор пароля"></div>

                            <button class="btn btn-primary w-100">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <h3>История моих заказов</h3>
                @forelse($orders as $order)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Заказ №{{ $order->id }} от {{ $order->order_date->format('d.m.Y') }}</span>
                            <span class="fw-bold">{{ number_format($order->total_amount, 2) }} ₽</span>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($order->items as $item)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $item->variant->product->name }} (Размер: {{ $item->variant->size->value }})</span>
                                    <span>{{ $item->quantity }} шт. × {{ number_format($item->unit_price, 2) }} ₽</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <div class="alert alert-info">Вы еще не сделали ни одного заказа.</div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>