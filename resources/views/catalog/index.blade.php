<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог - Чудо Обувь</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Чудо Обувь</a>
            <div>
                @auth
                    <a href="{{ route('cart.index') }}" class="btn btn-warning me-2">Корзина</a>
                    <a href="{{ route('profile.index') }}" class="btn btn-outline-light me-2">Профиль</a>
                    @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-danger me-2">Админка</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf<button class="btn btn-secondary">Выйти</button></form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Войти</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Каталог товаров</h1>
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        @auth
        <form method="GET" class="row g-3 mb-4 bg-white p-3 rounded shadow-sm">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Поиск..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Все категории</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="sort_by" class="form-select">
                    <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>По имени</option>
                    <option value="base_price" {{ request('sort_by') == 'base_price' ? 'selected' : '' }}>По цене</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="sort_dir" class="form-select">
                    <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>По возрастанию</option>
                    <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>По убыванию</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Применить</button>
            </div>
        </form>
        @endauth

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="text-muted small">{{ $product->description }}</p>
                            <h6 class="fw-bold text-primary">{{ number_format($product->base_price, 0, '.', ' ') }} ₽</h6>
                            
                            <hr>
                            <p class="mb-2 fw-bold">Размеры в наличии:</p>
                            @foreach ($product->variants as $variant)
                                @if($variant->stock_quantity > 0)
                                    <form action="{{ route('cart.add', $variant) }}" method="POST" class="d-flex mb-2">
                                        @csrf
                                        <span class="badge bg-info text-dark me-2 p-2 align-self-center">Р. {{ $variant->size->value }}</span>
                                        @auth
                                            <input type="number" name="quantity" value="1" min="1" max="{{ $variant->stock_quantity }}" class="form-control form-control-sm me-2" style="width: 60px;">
                                            <button class="btn btn-sm btn-primary">В корзину</button>
                                        @endauth
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</body>
</html>