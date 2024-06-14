<?php

namespace App\Services\Api\Book;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

/**
 * Class GenerateDescBook.
 */
class GenerateDescBookService
{
    public function generateDesc($oldDesc)
    {
        $url = env('API_AI');
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' =>  "Phần mô tả cũ: $oldDesc"],
                        ['text' => config('common.prompt')],
                    ],
                ],
            ],
        ];

        try {
            $response = Http::retry(3, 100)
                ->timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $data);

            if ($response->successful()) {
                return $response->json();
            } else {
                return false;
            }
        } catch (ConnectionException | RequestException $e) {
            return false;
        }
    }
}
