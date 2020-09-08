@php
/** @var \App\Models\Thing|null $thing */
$extra = (old('keys') || old('attrs')) ? array_combine(old('keys', []), old('attrs', [])) : $thing->extra ?? [];
$tags = \App\Models\Tag::all();
@endphp

<form method="post" action="{{ $action }}">
    @csrf
    @method($method)

    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="tag_ids">タグ</label>
        <select class="form-control col-sm-9" name="tag_ids[]" id="tag_ids" multiple size="4">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tag_ids', isset($thing) ? $thing->tags->pluck('id')->all() : [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="name">名前</label>
        <input type="text" class="form-control col-sm-9" name="name" id="name"
               value="{{ old('name', $thing->name ?? null) }}">
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="description">説明</label>
        <textarea name="description" id="description" class="form-control col-sm-9"
                  rows="4">{{ old('description', $thing->description ?? null) }}</textarea>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="image">画像URL</label>
        <input type="text" class="form-control col-sm-9" name="image" id="image"
               value="{{ old('image', $thing->image ?? null) }}">
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="link">リンク</label>
        <input type="text" class="form-control col-sm-9" name="link" id="link"
               value="{{ old('link', $thing->link ?? null) }}">
    </div>
    <div class="form-group row">
        <label class="col-sm-3 col-form-label" for="rating">評価</label>
        <div class="col-sm-9 px-0">
            <input type="number" class="form-control w-auto" name="rating" id="rating"
                   min="0" max="5" step="0.5"
                   value="{{ old('rating', $thing->rating ?? 0) }}">
        </div>
    </div>
    <fieldset class="form-group">
        <div class="row">
            <label class="col-sm-3 col-form-label">追加項目</label>
            <div class="col-sm-9">
                @foreach($extra as $key => $value)
                    <div class="row mb-2">
                        <div class="col-sm-3 px-0 pr-sm-1">
                            <div class="input-group mb-1">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-secondary" onclick="+function(self){self.parentNode.removeChild(self)}(this.closest('.row'))">
                                        <!-- https://github.com/danklammer/bytesize-icons/blob/master/LICENSE.md -->
                                        <svg id="i-minus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <path d="M2 16 L30 16" />
                                        </svg>
                                    </button>
                                </div>
                                <input type="text" class="form-control" name="extra[keys][]" title value="{{ $key }}">
                            </div>
                        </div>
                        <div class="col-sm-9 px-0">
                            <textarea name="extra[attrs][]" rows="1" class="form-control" title>{{ $value }}</textarea>
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <button type="button" class="btn btn-secondary" onclick="+function(self, newRow){self.parentNode.insertBefore(newRow, self)}(this.closest('.row'), document.importNode(document.querySelector('#extra-row').content, true))">
                        <!-- https://github.com/danklammer/bytesize-icons/blob/master/LICENSE.md -->
                        <svg id="i-plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M16 2 L16 30 M2 16 L30 16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </fieldset>

    {{ $slot }}
</form>

<template id="extra-row">
    <div class="row mb-2">
        <div class="col-sm-3 px-0 pr-sm-1">
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <button type="button" class="btn btn-secondary" onclick="+function(self){self.parentNode.removeChild(self)}(this.closest('.row'))">
                        <!-- https://github.com/danklammer/bytesize-icons/blob/master/LICENSE.md -->
                        <svg id="i-minus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M2 16 L30 16" />
                        </svg>
                    </button>
                </div>
                <input type="text" class="form-control" name="extra[keys][]" title>
            </div>
        </div>
        <div class="col-sm-9 px-0">
            <textarea name="extra[attrs][]" rows="1" class="form-control" title></textarea>
        </div>
    </div>
</template>
