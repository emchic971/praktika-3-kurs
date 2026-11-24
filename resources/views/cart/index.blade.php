<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4"><div class="container"><a href="/catalog" class="navbar-brand">Чудо Обувь</a></div></nav>
    <div class="container">
        <h1 class="mb-4">Ваша корзина</h1>
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        @if(empty($cart))
            <div class="alert alert-info">Корзина пуста. <a href="/catalog">Перейти в каталог</a></div>
        @else
            <table class="table table-bordered bg-white">
                <thead class="table-dark">
                    <tr><th>Товар</th><th>Размер</th><th>Кол-во</th><th>Цена</th><th>Сумма</th><th>Действие</th></tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                    <tr>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['size'] }}</td>
                        <td>
                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                @csrf @method('PATCH')
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control me-2" style="width: 80px;">
                                <button class="btn btn-sm btn-outline-secondary">Обновить</button>
                            </form>
                        </td>
                        <td>{{ number_format($item['price'], 2) }} ₽</td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 2) }} ₽</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Итого:</td>
                        <td colspan="2" class="fw-bold text-success">{{ number_format($total, 2) }} ₽</td>
                    </tr>
                </tfoot>
            </table>
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <button class="btn btn-success btn-lg w-100">Оформить заказ</button>
            </form>
        @endif
    </div>
</body>
</html>