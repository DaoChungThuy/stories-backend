<?php

namespace App\Services\Crawl;

use App\Models\Chapter;
use App\Services\BaseService;
use DOMElement;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class CrawlDataService extends BaseService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function handle()
    {
        try {
            $response = $this->client->get($this->data['url']);

            if ($response->getStatusCode() === 200) {
                $body = $response->getBody()->getContents();

                $dom = new \DOMDocument();
                @$dom->loadHTML(mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'));

                $xpath = new \DOMXPath($dom);

                $queryAvata = $xpath->query(
                    './/div[@class="info"]
                    //div[@class="row info-content"]
                    //div[@class="col-md-12 comic-intro m-b-0"]
                    //div[@class="none-box m-b-30"]
                    //div[@class="row"]
                    //div[@class="col-sm-4 margin-bottom-15px"]
                    //img'
                );
                $queryTitle = $xpath->query(
                    './/div[@class="col-sm-8 comic-info"]
                    //h2'
                );
                $queryAuhtorName = $xpath->query(
                    './/div[@class="col-sm-8 comic-info"]
                    //p
                    //span'
                );
                $queryDescription = $xpath->query(
                    './/div[@class="none-box m-b-30"]
                    //div[@class="margin-bottom-15px intro-container"]
                    //p'
                );

                $queryChapter = $xpath->query(
                    './/div[@class="table-scroll"]
                    //table
                    //tbody
                    //tr
                    //td[2]
                    //a[@class="text-capitalize"]'
                );

                $title = $queryTitle['0']->nodeValue;
                $author_name = $queryAuhtorName['1']->nodeValue;
                $chapters = [];
                $descriptionText = '';

                if ($queryChapter->length > 0) {
                    for ($i = $queryChapter->length - 1; $i >= 0; $i--) {
                        $chapters[] = $queryChapter[$i]->getAttribute('href');
                    }
                }

                foreach ($queryDescription as $description) {
                    $descriptionText .= $description->nodeValue . ' ';
                }

                $chapterContent = $this->getContentStory($chapters);

                $avatar = $queryAvata['0']->getAttribute('src');

                return $chapterContent;
            } else {
                Log::error('error: ' . json_encode($response));
                return false;
            }
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
    public function getContentStory(array $url)
    {
        $data = [];

        foreach ($url as $item) {
            $response = $this->client->get($item);

            if ($response->getStatusCode() === 200) {
                $body = $response->getBody()->getContents();

                $dom = new \DOMDocument();
                @$dom->loadHTML(mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'));

                $xpath = new \DOMXPath($dom);

                $queryContent = $xpath->query(
                    './/div[@class="none-shadow"]//div[@id="view-chapter"]'
                )->getIterator();
                foreach ($xpath->query('.//div[@class="none-shadow"]//div[@id="view-chapter"]') as $node) {
                    dd($xpath);
                    $a = $this->lazyLoad($node);
                    dd($a);
                }
                dd($dom->getElementsByTagName('.//div[@class="none-shadow"]//div[@id="view-chapter"]//img'));
                dd($queryContent);

                foreach ($xpath->query(
                    './/div[@class="none-shadow"]//div[@id="view-chapter"]'
                ) as $est) {
                    $est->nodeValue = "This is a {$est->tagName} tag.";
                }
            } else {
                Log::error('error: ' . json_encode($response));
                return false;
            }
        }

        return $data;
    }

    /**
     * @param DOMDocument $dom
     * @param DOMElement $node
     */
    protected function lazyLoad(DOMElement $node)
    {
        if (!$node->hasAttribute('data-src')) {
            // Set the data-src attribute.
            $node->setAttribute('data-src', $node->getAttribute('src'));

            // Set the src attribute to loading image.
            $node->setAttribute('src', asset('images/loading.gif'));

            // Merge the lazy load class into the class list.
            $node->setAttribute('class', join(' ', [
                $node->getAttribute('class'),
                'lazy-load'
            ]));

            return $node;
        }
    }
}
