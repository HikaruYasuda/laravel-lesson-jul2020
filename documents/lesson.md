---
marp: true
# theme: uncover
paginate: true
backgroundColor: white
footer: Laravelの理解を深める 中級編
---

# Laravel 講習

## 事前準備

---

## 事前準備

- [Docker](https://www.docker.com/get-started)を動かす環境があること
- Laravelインストール
    - composerがインストールされていない人は公式Composerイメージを使おう
    - Laravel5.xを使います
    - `docker run --rm --interactive --tty --volume $PWD:/app composer create-project laravel/laravel:5.* demo --prefer-dist`

---

## 事前準備

- 実行環境構築
    - docker-composeに自信のない人は[magic-lamp](https://www.npmjs.com/package/magic-lamp)を使おう
    - Nodeをインストール → `npm i -g magic-lamp`
    - `cd demo`
    - `lamp create web db smtp`
    - `lamp start`
    - `lamp composer update`
    - docker-compose.ymlを見て.envのDB接続情報を設定

---

# Laravel 講習

## サービスコンテナ

(1〜2日)

---

## サービスコンテナ

元々は公式にIoCコンテナと呼ばれていたが、現在では単にコンテナ、またはサービスコンテナと呼ばれている。

→ IoCコンテナ？コンテナ？

---

## IoCってなに？

制御の反転（Inversion of Control）の略。
抽象化原則の一種で、手続き型プログラミングではプロシージャ（手続き）を「呼び出す側」が「呼び出される側」を制御していたが、それとは制御の流れが逆になるようにすること。

例えば）
BatchControllerクラスはFileAccessorオブジェクトを使う。
単純に手続きを書くと BatchController → FileAccessor という流れになる。
これを FileAccessor → BatchController という流れにすること。

---
![bg](./ioc_1.png)

---
![bg](./ioc_2.png)

---
![bg](./ioc_3.png)

---
![bg](./ioc_4.png)

---

IoCは依存性の注入（Dependency Injection）と一緒に語られることも多い。

> _依存性の注入(DI)..._
あるモジュール（や処理）が他のモジュールに依存しているとき、依存しているモジュールを外から注入すること。依存対象の知識を最低限にとどめる。

DIはIoCの実践方法のひとつ。
注入以外にも、Factoryパターン、イベント駆動アーキテクチャなどがある。

LaravelのサービスコンテナはFactoryの役割やDIの役割をする（他の役割もする）。

---

ハリウッド原則　と言ったりもする

![](./hollywood_joyu_woman.png)

「あなたの方から連絡してこないで。あなたが必要な時はこっちから連絡するから」

---

もちろんメリットとデメリットがある。
主なデメリットは、元が単純な手続きだった場合にかえって複雑になってしまうこと。

なんでもかんでも反転させればいい訳ではない！
目的をちゃんと理解することが大事。

---

## 結合と登録と解決

---

### 結合？

Laravelのサービスコンテナで「結合」とは、抽象クラス（またはキーワード）と実オブジェクトを結合するということ。

BatchControllerの例で言うと、
(´・ω・`) .｡o（ファイル読み込みしたいなぁ）が抽象クラス
　要件「readというメソッドにファイル名を渡したらコンテンツが返ってきてほしい」
　※このようなインプットとアウトプットの要件をPHPではインターフェースと言う
(´∀｀) 「S3FileAccessorあげます」が実オブジェクト

---

Laravelコンテナの結合関係を登録するメソッドのシグネチャ

```php
// \Illuminate\Contracts\Container\Container

/**
 * Register a binding with the container.
 *
 * @param  string  $abstract
 * @param  \Closure|string|null  $concrete
 * @param  bool  $shared
 * @return void
 */
public function bind($abstract, $concrete = null, $shared = false)
```

・`abstract`: 抽象クラスやインターフェースなど
・`concrete`: 実体クラスやファクトリ関数など
・`shared`: 最初に生成したオブジェクトを共有する（使い回す）かどうかのフラグ

---

#### 解決？

英語でresolve. 抽象オブジェクトから実オブジェクトを決定すること。
Laravelのコンテナでは`make`と`get`で解決できる。

> メモ： `get`は[PSR-11](https://www.ritolab.com/entry/107)に準拠するために実装されている。通常は`make`を使う

```php
// \Illuminate\Contracts\Container\Container

/**
 * Resolve the given type from the container.
 *
 * @param  string  $abstract
 * @param  array  $parameters
 * @return mixed
 *
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
public function make($abstract, array $parameters = []);
```

`app()`ヘルパや`resolve()`ヘルパでもできる。記述量も減るしわかりやすい。

---

#### Q. サービスコンテナってどこにあるの？どうやって使うの？

LaravelのApplicationクラスはサービスコンテナを継承しているのでLaravelの本体と言っても過言ではない（過言かも）。
Laravelというフレームワークを分解すると、便利なクラス群とそれらを管理するコンテナで出来ている。モダンなフルスタックフレームワークは大体こんな構成。

こんな方法でコンテナを取ってこれる
- `app()`ヘルパ
- `App`ファサード
- `Container`ファサード
- `Illuminate\Container\Container::getInstance()` （シングルトンパターン）
- `Illuminate\Contracts\Container\Container`を解決した実オブジェクト
などなど

「『コンテナが欲しい』と呼び出すと実オブジェクトとしてApplicationをくれる」

---

#### Q. 結合関係はどこで登録するのが一番いいの？

サービスプロバイダの`register`メソッド

なぜ？

サービスプロバイダの`register`セクションはアプリケーション起動の最初期に実行され、基本的にはサービスコンテナへの登録はすべてここでおこなわれる。
外で登録することもできるが、処理の前後関係を意識しないと解決できない場合がある。
定義自体が重かったり利用頻度が低いなどの場合には遅延で`register`を実行する仕組みもある（`defer`）。

---

### [実践] 趣味ポートフォリオを作ろう

※ 各講義で書いたソースコードは、GitHubの[HikaruYasuda/laravel-lesson-jul2020](https://github.com/HikaruYasuda/laravel-lesson-jul2020/tree/lesson/day1)リポジトリにタグを付けてコミットしておきます。

---

1. まずは登録するためのフォームを作る。

```sh
php artisan make:controller HomeController
```

> 以降`php artisan ・・・`コマンドは、magic-lampを使っている人は`lamp artisan ・・・`、docker-composeを使っている人は`docker-compose exec web php artisan ・・・`に読み替えてください。

---

2. トップページとデータ登録アクションを作る。

```php
// app\Http\Controllers\HomeController.php

// 略

public function index()
{
    return view('index');
}

public function store()
{
    return redirect()->route('index');
}
```

3. アクションのルートを定義する。

```php
// routes/web.php
Route::get('/', 'HomeController@index')->name('index');
Route::post('/create', 'HomeController@store')->name('store');
```

---

4. indexテンプレートを定義する。

`<head>`の内容などは[Bootstrap - Introduction](https://getbootstrap.jp/docs/4.5/getting-started/introduction/#%E3%82%B9%E3%82%BF%E3%83%BC%E3%82%BF%E3%83%BC%E3%83%86%E3%83%B3%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88)を参考にして実装します。

```html
// resources/view/index.blade.php
<!doctype html>
<html lang="ja">
<head>(略)</head>
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
                    <label for="memo">メモ</label>
                    <textarea name="memo" id="memo" rows="4" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">送信</button>
            </form>
        </div>
    </div>
</section>
<script>(略)</script>
</body>
</html>
```

---

5. ポートフォリオデータを保存したり取得したりするリポジトリを作る。

```php
// app/Repositories/PortfolioRepository.php
use Illuminate\Contracts\Filesystem\Filesystem;

class PortfolioRepository
{
    public function getAll()
    {
        $portfolios = collect();
        foreach (resolve(Filesystem::class)->files() as $path) {
            if ($path === '.gitignore') {
                continue;
            }
            $contents = resolve(Filesystem::class)->get($path);
            $portfolios[] = json_decode($contents, true);
        }
        return $portfolios;
    }

    public function create(array $data)
    {
        $json = collect($data)->only('name', 'memo')->toJson(JSON_UNESCAPED_UNICODE);

        resolve(Filesystem::class)->put("{$data['name']}.txt", $json);
    }
}
```

---

6. コントローラからリポジトリを呼び出す。

```php
// app\Http\Controllers\HomeController.php

// 略

public function index()
{
    $portfolios = resolve(PortfolioRepository::class)->getAll();

    return view('index', compact('portfolios'));
}

public function store(Request $request)
{
    resolve(PortfolioRepository::class)->create($request->all());

    return redirect()->route('index');
}
```

---

7. indexテンプレートにデータの一覧を追加

```html
<section class="container my-5">
    <h4><small>データ</small></h4>
    <div class="row">
        @foreach($portfolios as $portfolio)
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $portfolio['name'] }}</h5>
                        <p class="card-text">{{ $portfolio['memo'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
```

---

8. リポジトリをシングルトンとして登録

```php
// app/Providers/AppServiceProvider.php

use App\Repositories\PortfolioRepository;

// 略

public function register()
{
    $this->app->singleton(PortfolioRepository::class);
}
```

一旦ここまででデータの登録と一覧表示ができました。

---

`App\Repositories\PortfolioRepository`のコンテナ登録でやったこと

```php
$this->app->singleton(PortfolioRepository::class);
```

これは

```php
//               abstract                    concrete                   shared
$this->app->bind(PortfolioRepository::class, PortfolioRepository::class, true);
```

したのと同じ登録定義になります。

---

**tinkerを使ってシングルトンの挙動を確認する**

tinkerでPortfolioRepositoryを解決してみる。
何度実行してもオブジェクトIDが変わらないことがわかる
 → 同じインスタンス。インスタンスのプロパティを共有できる。

```sh
$ php artisan tinker
>>> resolve(App\Repositories\PortfolioRepository::class)
=> App\Repositories\PortfolioRepository {#2985}
>>> resolve(App\Repositories\PortfolioRepository::class)
=> App\Repositories\PortfolioRepository {#2985}
```

singletonをbindに戻した場合は毎回オブジェクトIDが変わる
 → 別のインスタンス。インスタンスのプロパティはその場限り。

---

**抽象クラスから実オブジェクトへの解決フロー**

1. resolveやmakeなどで抽象クラスが要求される
　　↓
2. |　抽象クラスに対応したインスタンスが保存されている場合
　　　 → 保存されたインスタンスを返却
　　↓
3. |　concreteがクラス名の場合はビルド（インスタンス化）する。
|　concreteがファクトリ関数の場合は呼び出して結果を取得する。
　　↓
4. |　sharedがついている場合 3の結果をコンテナ内に保存する
　　↓
5. 実オブジェクトとして3の結果を返却する

---

#### コンストラクタでDIする

```php
// app/Repositories/PortfolioRepository.php

/**
 * @var \Illuminate\Contracts\Filesystem\Filesystem
 */
private $filesystem;

public function __construct(Filesystem $filesystem)
{
    $this->filesystem = $filesystem;
}
```

リポジトリで使っているファイルドライバを外から変更できるようになる

---

"**ビルド**"はコンテナがクラスをインスタンス化すること

ただし次の場合はインスタンス化できない

- インターフェースやabstractの付いたクラス(PHP的にはこれが抽象クラス)
- コンストラクタ(`__construct`)のアクセスレベルがpublicでないクラス
- コンストラクタに必要な引数がコンテナで用意できない
    - make()の第二引数でコンストラクタに使うパラメータを指定することもできる

次のような場合は、コンテナに暗黙ビルドさせる代わりにファクトリ関数を使った方がよい

- インスタンス化されるクラスを動的に切り替えたい
- 想定と違う引数でインスタンス化されちゃうけど毎回パラメータ使って解決したくない


---

`App\Repositories\PortfolioRepository`を登録しなくても動いていた

なんで？

→ 登録がない場合、コンテナは要求された抽象クラスを暗黙的にビルドして返却してくれる
　※ ビルドできない場合はエラー


---

PortfolioRepositoryの中、`resolve()`ヘルパで要求しているのはFilesystemのContract（契約）です。
> [公式Doc](https://readouble.com/laravel/5.8/ja/contracts.html)にもあるとおり、Laravelで"契約"とはインターフェイスのこと

```php
// app/Repositories/PortfolioRepository.php

use Illuminate\Contracts\Filesystem\Filesystem;

resolve(Filesystem::class)->put("{$data['name']}.txt", $json);
```

抽象クラス`Illuminate\Contracts\Filesystem\Filesystem`を要求すると、`config/filesystem.php`で設定されているデフォルトドライバのオブジェクトが返却されます。

---

#### クラス名以外で結合を登録する

結合は、抽象クラス名を使う代わりにキーワードになる文字列を使って登録することができる。

```php
$this->app->singleton('portfolios', PortfolioRepository::class);
```

この場合、porfoliosとPortfolioRepositoryの両方でインスタンスが保存されてしまうので、片方をエイリアスにする。

```php
//                解決に使う抽象クラス   紐付ける要求
$this->app->alias('portfolios', PortfolioRepository::class);
```

---

抽象クラス`Illuminate\Contracts\Filesystem\Filesystem`が実オブジェクトに解決されるフローは、少し複雑ですがコンテナの仕組みを理解すれば追うことができます。

