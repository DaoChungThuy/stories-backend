<?php

namespace App\Services\Crawl;

use App\Enums\StatusStory;
use App\Enums\StoryType;
use App\Interfaces\Book\BookRepositoryInterface;
use App\Jobs\CrawlContentChapter;
use App\Services\BaseService;
use App\Traits\UploadFileTrait;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CrawlDataService extends BaseService
{
    use UploadFileTrait;

    protected $client;
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->client = new Client();
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        $response = $this->client->get($this->data['url']);

        if ($response->getStatusCode() != 200) {
            Log::error(__('status.failed_load') . $response->getStatusCode());
            return false;
        }

        $body = $response->getBody()->getContents();
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new \DOMXPath($dom);

        $queryAvatar = $xpath->query(file_get_contents(app_path('XpathQueries/avatar_xpath.txt')));
        $queryTitle = $xpath->query(file_get_contents(app_path('XpathQueries/title_xpath.txt')));
        $queryChapter = $xpath->query(file_get_contents(app_path('XpathQueries/chapter_xpath.txt')));

        $title = $queryTitle[0]->nodeValue;
        $avatarUrl = $queryAvatar[0]->getAttribute('src');
        $imageData = file_get_contents($avatarUrl);

        if ($imageData === false) {
            Log::error(__('status.failed_load_img'));
            return false;
        }

        $tempFilePath = tempnam(sys_get_temp_dir(), 'img');
        file_put_contents($tempFilePath, $imageData);

        $uploadedFile = new UploadedFile(
            $tempFilePath,
            basename($avatarUrl),
            mime_content_type($tempFilePath),
            filesize($tempFilePath),
            UPLOAD_ERR_OK
        );

        $data = [
            'title' => $title,
            'cover_image' => $this->uploadFile($uploadedFile),
            'author_id' => $this->data['author_id'],
            'genre_id' => $this->data['genre_id'],
            'description' => $this->data['description'],
            'package_type' => $this->data['package_type'],
            'story_type' => StoryType::COMIC,
            'status' => StatusStory::ACTIVE,
        ];

        $book = $this->bookRepository->create($data);

        if ($queryChapter->length > 0) {
            for ($i = $queryChapter->length - 1; $i >= 1; $i--) {
                dispatch(new CrawlContentChapter(
                    $queryChapter[$i]->getAttribute('href'),
                    $book->id,
                    $queryChapter->length - 1 - $i
                ));
            }
        }

        return $book;
    }
}
