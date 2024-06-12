<?php

namespace App\Services\Crawl;

use App\Enums\StatusStory;
use App\Enums\StoryType;
use App\Interfaces\Book\BookRepositoryInterface;
use App\Jobs\CrawlContentChapterJob;
use App\Services\BaseService;
use App\Traits\UploadFileImageTrait;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CrawlDataService extends BaseService
{
    use UploadFileImageTrait;

    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            $response = Http::get($this->data['url']);
            $body = $response->getBody()->getContents();
            $dom = new \DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'));
            $xpath = new \DOMXPath($dom);
            $queryAvatar = $xpath->query(config('xpaths')['nettruyenfull']['avatar_xpath']);
            $queryTitle = $xpath->query(config('xpaths')['nettruyenfull']['title_xpath']);
            $queryChapter = $xpath->query(config('xpaths')['nettruyenfull']['chapter_xpath']);

            $title = $queryTitle[0]->nodeValue;
            $response = Http::get($queryAvatar[0]->getAttribute('src'));
            $tempFile = tempnam(sys_get_temp_dir(), 'temp');
            file_put_contents($tempFile, $response->body());

            $uploadedFile = new UploadedFile($tempFile, basename($queryAvatar[0]->getAttribute('src')));

            $data = [
                'title' => $title,
                'cover_image' => $this->uploadFileImage($uploadedFile, 'avatar_user'),
                'author_id' => $this->data['author_id'],
                'genre_id' => $this->data['genre_id'],
                'description' => $this->data['description'],
                'package_type' => $this->data['package_type'],
                'story_type' => StoryType::COMIC,
                'status' => StatusStory::ACTIVE,
            ];

            $book = $this->bookRepository->create($data);

            if ($queryChapter->length > 0 && !empty($book)) {
                for ($i = $queryChapter->length - 1; $i >= 1; $i--) {
                    dispatch(new CrawlContentChapterJob(
                        $queryChapter[$i]->getAttribute('href'),
                        $book->id,
                        $queryChapter->length - 1 - $i,
                        $book->title
                    ));
                }
            }

            return $book;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
