@foreach (\App\Models\LinkdumpCategory::whereIntegratedWithTemplate(false)->whereLangCode($langCode->name)->get() as $category)
    @if ($loop->first)
        <div class="row border-top pt-3 rtl">
    @endif
        
    @if ($category->links()->count())
        <div class="col-md-4 mb-3">
            {{ $category->name }} <br>
            @foreach ($category->links as $link)
                <a href="{{ $link->link }}">{{ $link->text }}</a> <br>
            @endforeach
        </div>
    @endif
    
    @if ($loop->last)
        </div>
    @endif
@endforeach
