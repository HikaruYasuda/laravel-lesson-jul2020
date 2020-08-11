@extends('layout')

@section('title', 'ポートフォリオ')

@section('content')
    <section class="container my-5">
        <div class="card">
            <div class="card-header">
                ポートフォリオを編集
            </div>
            <div class="card-body">
                @component('_form', ['method' => 'put', 'action' => route('update', $thing), 'thing' => $thing])
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">保存</button>
                            <button type="submit" class="btn btn-danger" onclick="return confirm('削除しますか？') && !!(this.form._method.value = 'delete')">削除</button>
                            <a href="{{ route('index') }}" class="btn btn-link">戻る</a>
                        </div>
                    </div>
                @endcomponent
            </div>
        </div>
    </section>
@endsection
