<?php

namespace App\Jobs;

use App\Models\Chapter;
use App\Models\ChapterImage;
use App\Traits\UploadFileTrait;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Exception;

class CrawlContentChapter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use UploadFileTrait;

    protected $url;
    protected $bookId;
    protected $chapterNumber;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $bookId, $chapterNumber)
    {
        $this->url = $url;
        $this->bookId = $bookId;
        $this->chapterNumber = $chapterNumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        try {
            $response = $client->get($this->url);

            $body = $response->getBody()->getContents();
            $dom = new \DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'));
            $xpath = new \DOMXPath($dom);

            $queryContent = $xpath->query(file_get_contents(app_path('XpathQueries/content_xpath.txt')));

            $chapterData = [
                'book_id' => $this->bookId,
                'chapter_number' => $this->chapterNumber,
                'chapter_title' => __('book.chapter') . $this->chapterNumber,
                'chapter_content' => __('book.comic_style'),
            ];

            $chapter = Chapter::create($chapterData);

            if ($queryContent->length > 0) {
                for ($i = 0; $i < $queryContent->length - 2; $i++) {
                    $imgUrl = $queryContent[$i]->getAttribute('data-original');
                    $imageData = file_get_contents($imgUrl);

                    if ($imageData === false) {
                        continue;
                    }

                    $tempFilePath = tempnam(sys_get_temp_dir(), 'img');
                    file_put_contents($tempFilePath, $imageData);

                    $uploadedFile = new UploadedFile(
                        $tempFilePath,
                        basename($imgUrl),
                        mime_content_type($tempFilePath),
                        filesize($tempFilePath),
                        UPLOAD_ERR_OK
                    );

                    $uploadedImageUrl = $this->uploadFile($uploadedFile);

                    $chapterImageData = [
                        'chapter_id' => $chapter->id,
                        'url' => $uploadedImageUrl,
                        'image_number' => $i,
                    ];

                    ChapterImage::create($chapterImageData);

                    unlink($tempFilePath);
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
