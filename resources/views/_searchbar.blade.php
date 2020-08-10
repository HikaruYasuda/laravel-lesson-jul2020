<form method="get">
    <div class="input-group mb-3">
        <input type="text" name="q" class="form-control" title value="{{ request('q') }}">
        <div class="input-group-append">
            <button class="btn btn-secondary">
                <!-- https://github.com/danklammer/bytesize-icons/blob/master/LICENSE.md -->
                <svg id="i-search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <circle cx="14" cy="14" r="12" />
                    <path d="M23 23 L30 30"  />
                </svg>
            </button>
        </div>
    </div>
</form>
