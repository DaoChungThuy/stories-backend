<?php

namespace App\Jobs;

use App\Models\Chapter;
use App\Models\ChapterImage;
use App\Traits\UploadFileImageTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Exception;

class CrawlContentChapterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use UploadFileImageTrait;

    protected $url;
    protected $bookId;
    protected $chapterNumber;
    protected $bookTitle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $bookId, $chapterNumber, $bookTitle)
    {
        $this->url = $url;
        $this->bookId = $bookId;
        $this->chapterNumber = $chapterNumber;
        $this->bookTitle = $bookTitle;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $response = Http::get($this->url);
            $body = $response->getBody()->getContents();
            $dom = new \DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'));
            $xpath = new \DOMXPath($dom);

            $queryContent = $xpath->query(config('xpaths')['nettruyenfull']['content_xpath']);

            $chapterData = [
                'book_id' => $this->bookId,
                'chapter_number' => $this->chapterNumber,
                'chapter_title' =>  $this->bookTitle . ' - ' . __('book.chapter') . $this->chapterNumber,
                'chapter_content' => __('book.comic_style'),
            ];

            $chapter = Chapter::create($chapterData);

            if ($queryContent->length > 0) {
                for ($i = 0; $i < $queryContent->length - 2; $i++) {
                    $response = Http::retry(3, 100)->get($queryContent[$i]->getAttribute('data-original'));

                    if ($response->failed() || !str_starts_with($response->header('Content-Type'), 'image')) {
                        continue;
                    }

                    $tempFile = tempnam(sys_get_temp_dir(), 'temp');
                    file_put_contents($tempFile, $response->body());

                    $file = new UploadedFile($tempFile, time() . '_cover_image.jpg');

                    $chapterImageData = [
                        'chapter_id' => $chapter->id,
                        'url' => $this->uploadFileImage($file, 'img_content_story'),
                        'image_number' => $i,
                    ];

                    ChapterImage::create($chapterImageData);

                    unlink($tempFile);
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
