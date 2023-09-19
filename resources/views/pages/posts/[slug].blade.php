<?php

use App\Models\Post;
use Illuminate\View\View;
use function Laravel\Folio\name;
use function Laravel\Folio\render;

name('post.show');

render(function (View $view, string $slug) {
    $post = Post::getPostData($slug . '.md');

    return $view->with('post', $post);
});

?>

<x-layout>
    <h1>{{ $post?->meta?->title }}</h1>

    {!! $post->body !!}
</x-layout>
