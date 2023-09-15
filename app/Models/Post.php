<?php

namespace App\Models;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use SplFileInfo;
use stdClass;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Post
{
    public static Collection $filenames;
    public Filesystem $filesystem;

    public function __construct(
    )
    {

        $this->filesystem = new Filesystem();

        self::$filenames = collect(File::allFiles(app_path("Posts")))
            ->sortByDesc(function (SplFileInfo $file) {
                return $file->getBaseName();
            })
            ->map(function (SplFileInfo $file) {
               return $file->getBasename();
            });
    }

    public static function getLatest(int $limit): Collection
    {
        $posts = [];

        foreach (self::$filenames->take($limit) as $filename) {
            $posts[] = self::getPostData($filename);
        }

        return collect($posts);
    }

    public static function getPostData(string $filename): object
    {
        $post = new stdClass();
        $file = null;
        try {
            $file = (new self)->filesystem->get(app_path('Posts/' . $filename));
        } catch (FileNotFoundException $e) {
            Log::error("Error: loading...". $filename);
            throw new NotFoundHttpException();
        }

        $object = YamlFrontMatter::parse($file);

        $post->slug = str_replace('.md', '', $filename);
        $post->meta = $object->matter();

        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new AttributesExtension());
        $converter = new CommonMarkConverter();

        $post->body = $converter->convert($object->body());

        return $post;
    }
}
