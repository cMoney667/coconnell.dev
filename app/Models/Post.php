<?php

namespace App\Models;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use SplFileInfo;
use stdClass;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @property string slug
 * @property string body
 */
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
            try {
                $posts[] = self::getPostData($filename);
            } catch (CommonMarkException $exception) {
                Log::debug($exception->getMessage());
            }
        }

        return collect($posts);
    }

    /**
     * @param string $filename
     * @return Post
     * @throws \League\CommonMark\Exception\CommonMarkException
     */
    public static function getPostData(string $filename): object
    {
        $post = new stdClass();
        try {
            $file = (new self)->filesystem->get(app_path('Posts/' . $filename));
        } catch (FileNotFoundException $e) {
            Log::error("Error: loading...". $filename);
            throw new NotFoundHttpException();
        }

        $object = YamlFrontMatter::parse($file);

        $post->slug = str_replace('.md', '', $filename);
        $post->meta = (object)$object->matter();

        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new AttributesExtension());
        $converter = new CommonMarkConverter();

        $post->body = $converter->convert($object->body());

        return $post;
    }
}
