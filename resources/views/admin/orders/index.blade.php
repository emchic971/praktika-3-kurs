<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление заказами</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/catalog">Панель сотрудника</a>
            <div>
                <a href="/catalog" class="btn btn-outline-light me-2">В каталог</a>
                <a href="{{ route('admin.orders.create') }}" class="btn btn-primary me-2">Создать заказ</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 class="mb-4">Все заказы</h1>
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        
        <table class="table table-bordered bg-white">
            <thead class="table-dark">
                <tr><th>ID</th><th>Дата</th><th>Клиент</th><th>Сумма</th><th>Действия</th></tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->order_date->format('d.m.Y') }}</td>
                    <td>{{ $order->customer_last_name }} {{ $order->customer_first_name }} ({{ $order->user ? $order->user->login : 'Удален' }})</td>
                    <td>{{ number_format($order->total_amount, 2) }} ₽</td>
                    <td>
                        @if(auth()->user()->hasPermissionTo('edit orders'))
                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        @endif
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Удалить заказ?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</body>
</html>