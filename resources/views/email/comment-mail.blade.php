<h2>Hello {{ $article->user->name }}</h2>
<p>
    {{ $loginUser }} commented on your post " {{ $article->title }} "
</p>
<a href="{{ route('detail', $article->slug) }}">
    Read Detail
</a>
