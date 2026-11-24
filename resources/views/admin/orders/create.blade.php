<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать заказ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white">Создание заказа вручную</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Клиент</label>
                        <select name="user_id" class="form-select" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->last_name }} {{ $user->first_name }} ({{ $user->login }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Товар (Размер - Остаток - Цена)</label>
                        <select name="items[0][variant_id]" class="form-select" required>
                            @foreach($variants as $v)
                                <option value="{{ $v->id }}">{{ $v->product->name }} - Размер: {{ $v->size->value }} (Осталось: {{ $v->stock_quantity }} шт.) - {{ $v->price }} ₽</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Количество</label>
                        <input type="number" name="items[0][quantity]" value="1" min="1" class="form-control" required>
                    </div>
                    <button class="btn btn-success">Создать заказ</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Назад</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>