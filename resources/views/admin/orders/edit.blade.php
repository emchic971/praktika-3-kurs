<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать заказ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-warning text-dark">Редактирование заказа №{{ $order->id }}</div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Дата заказа</label>
                        <input type="date" name="order_date" value="{{ $order->order_date->format('Y-m-d') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Фамилия клиента</label>
                        <input type="text" name="customer_last_name" value="{{ $order->customer_last_name }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Имя клиента</label>
                        <input type="text" name="customer_first_name" value="{{ $order->customer_first_name }}" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Сохранить изменения</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>