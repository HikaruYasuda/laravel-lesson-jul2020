<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Hello, world!</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
</nav>
<section class="container my-5">
    <div class="card">
        <div class="card-header">データを追加</div>
        <div class="card-body">
            <form method="post" action="{{ route('store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">名前</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="description">説明</label>
                    <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">画像URL</label>
                    <input type="text" class="form-control" name="image" id="image">
                </div>
                <div class="form-group">
                    <label for="link">リンク</label>
                    <input type="text" class="form-control" name="link" id="link">
                </div>
                <div class="form-group">
                    <label for="rating">評価</label>
                    <input type="number" class="form-control" name="rating" id="rating">
                </div>
                <button type="submit" class="btn btn-primary">送信</button>
            </form>
        </div>
    </div>
</section>
<section class="container my-5">
    <h4><small>データ</small></h4>
    <div class="row">
        <div class="col-sm-12">
            <form method="get">
                <div class="input-group mb-3">
                    <input type="text" name="q" class="form-control" title value="{{ request('q') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary">検索</button>
                    </div>
                </div>
            </form>
        </div>
        @foreach($things as $thing)
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $thing->name }}</h5>
                        <p class="card-text" style="white-space: pre-wrap">{{ $thing->description }}</p>
                        @isset($thing->rating)
                            <p class="card-text">評価： {{ $thing->rating }}</p>
                        @endif
                        @if($thing->link)
                            <a href="{{ $thing->link }}" class="card-link">{{ $thing->name }}</a>
                        @endif
                    </div>
                    @if($thing->image)
                        <img src="{{ $thing->image }}" alt class="bd-placeholder-img card-img-bottom" width="100%" height="180"/>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
