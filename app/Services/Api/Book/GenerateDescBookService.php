<?php

namespace App\Services\Api\Book;

use Illuminate\Support\Facades\Http;

/**
 * Class GenerateDescBook.
 */
class GenerateDescBookService
{
    public function generateDesc($oldDesc)
    {
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=AIzaSyBkpXSByq_QH2a05vUk-ltfzmH0uWHl_zM';
        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $oldDesc
                        ],
                        [
                            'text' => 'Tóm tắt nội dung'
                        ],
                        [
                            'text' => 'Nhân vật chính'
                        ],
                        [
                            'text' => 'Bối cảnh'
                        ]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        return $response->json();
    }
}
