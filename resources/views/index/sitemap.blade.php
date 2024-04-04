<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($posts as $post)
<url>
<loc>{{ route('post', ['langCode' => $post->lang_code, 'post' => $post->slug]) }}</loc>
</url>
@endforeach
</urlset>