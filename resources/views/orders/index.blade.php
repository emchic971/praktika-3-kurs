<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои заказы - Чудо Обувь</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('catalog.index') }}">Чудо Обувь</a>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-light">Назад в каталог</a>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">История моих заказов</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>№</th>
                            <th>Дата</th>
                            <th>Сумма</th>
                            <th>Состав заказа</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_date->format('d.m.Y') }}</td>
                                <td class="fw-bold">{{ number_format($order->total_amount, 2, '.', ' ') }} ₽</td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($order->items as $item)
                                            <li>
                                                {{ $item->variant->product->name }} 
                                                <span class="text-muted">(р. {{ $item->variant->size->value }})</span> 
                                                × {{ $item->quantity }} шт.
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">У вас пока нет заказов</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>