<?php /** @var \App\Models\Thing $thing */ ?>
<div class="col-sm-6 mb-5">
    <div class="card">
        <div class="card-body">
            @auth
                <small class="float-right">
                    <a href="{{ route('edit', $thing) }}">編集</a>
                </small>
            @else
                <div class="float-right">
                    @if($thing->liked)
                        <form action="{{ route('like.destroy', $thing) }}" method="post">
                            @method('delete')
                            @csrf
                            <button class="btn btn-info btn-sm" data-like="{{ $thing->id }}">
                                いいね <[ {{ $thing->likesCount }} ]
                            </button>
                        </form>
                    @else
                        <form action="{{ route('like.store', $thing) }}" method="post">
                            @csrf
                            <button class="btn btn-outline-secondary btn-sm" data-like="{{ $thing->id }}">
                                いいね <[ {{ $thing->likesCount }} ]
                            </button>
                        </form>
                    @endif
                </div>
            @endauth
            <h5 class="card-title">{{ $thing->name }}</h5>
            <p class="card-text text-muted"><small>{{ $thing->name_kana }}</small></p>
            <p class="card-text" style="white-space: pre-wrap">{{ $thing->description }}</p>
            @isset($thing->rating)
                <p class="card-text">評価： {{ $thing->rating }}</p>
            @endif
            @if($thing->link)
                <a href="{{ $thing->link }}" class="card-link">{{ $thing->name }}</a>
            @endif
            @foreach($thing->extra ?? [] as $key => $attr)
                <p class="card-text">{{ $key }}： {{ $attr }}</p>
            @endforeach
        </div>
        @if($thing->image)
            <a href="{{ $thing->image }}" target="_blank">
                <img
                    src="{{ $thing->image }}"
                    alt="{{ $thing->name }}"
                    class="bd-placeholder-img card-img-bottom"
                    width="100%"
                    style="max-height: 180px; object-fit: cover;"
                />
            </a>
        @endif
    </div>
</div>
