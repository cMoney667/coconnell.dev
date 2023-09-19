<?php

use App\Models\Post;
use function Laravel\Folio\name;

name('home');

$postsClass = new Post;

$posts = Post::getLatest(5);

?>

<x-layout>
    <h2>Hello!</h2>
    <p>
        My name is Collin O'Connell, I am currently the Lead Developer at <a href="https://www.gardner-white.com"
                                                                             target="_blank">Gardner-White Furniture</a>.
        I enjoy working with HTML, CSS, PHP and Javascript.
    </p>

    @forelse($posts as $post)
        <article>
            <h3>
                <a href="/posts/{{ $post->slug }}" preload>
                    {{ $post->meta?->title }}
                </a>
            </h3>
            <p>
                <time>{{ date('M d, Y', $post->meta->published_on) }}</time>
            </p>

            <p>
                {{ $post->meta?->excerpt }}
            </p>
        </article>
    @empty
        <p class="text-align:center">No Posts.... yet</p>
    @endforelse
</x-layout>
