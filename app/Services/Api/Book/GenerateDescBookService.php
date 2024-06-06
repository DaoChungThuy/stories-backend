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
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=' . getenv('API_KEY');
        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' =>
                            "Phần mô tả cũ: $oldDesc\n\n" .
                                "Tóm tắt nội dung: Hãy bổ sung thêm một đoạn tóm tắt nội dung chi tiết của câu chuyện. Vui lòng cung cấp một đoạn văn ngắn gọn tóm tắt nội dung chính của câu chuyện. Ví dụ:\n" .
                                "- Câu chuyện kể về hành trình của một người anh hùng đi tìm kiếm kho báu.\n" .
                                "- Một câu chuyện tình yêu giữa hai người ở hai thế giới khác nhau.\n" .
                                "Độ dài: Khoảng 100-200 từ.\n\n" .
                                "Nhân vật chính: Hãy bổ sung thêm thông tin về nhân vật chính. Vui lòng cung cấp các thông tin sau:\n" .
                                "- Tên của nhân vật chính\n" .
                                "- Mô tả ngắn về ngoại hình của nhân vật chính\n" .
                                "- Tính cách của nhân vật chính\n" .
                                "- Vai trò của nhân vật chính trong câu chuyện\n" .
                                "Ví dụ:\n" .
                                "- Tên: John, Ngoại hình: Cao, tóc đen, mắt xanh, Tính cách: Dũng cảm, trung thực, Vai trò: Anh hùng tìm kiếm kho báu.\n" .
                                "- Tên: Anna, Ngoại hình: Nhỏ nhắn, tóc vàng, mắt nâu, Tính cách: Thông minh, nhiệt tình, Vai trò: Nhà khoa học khám phá thế giới mới.\n\n" .
                                "Nhân vật phụ: Hãy bổ sung thêm thông tin về các nhân vật phụ quan trọng. Vui lòng cung cấp các thông tin sau:" .
                                "- Tên của nhân vật phụ\n" .
                                "- Mối quan hệ với nhân vật chính\n" .
                                "- Vai trò của nhân vật phụ trong câu chuyện\n" .
                                "Ví dụ:\n" .
                                "- Tên: Sarah, Mối quan hệ: Bạn thân của John, Vai trò: Người hỗ trợ trong cuộc tìm kiếm kho báu\n" .
                                "- Tên: Mark, Mối quan hệ: Đối thủ của Anna, Vai trò: Kẻ thách thức trong cuộc khám phá thế giới mới\n\n" .
                                "Bối cảnh: Hãy bổ sung thêm thông tin về bối cảnh của câu chuyện. Vui lòng cung cấp các thông tin sau:\n" .
                                "- Thời gian diễn ra câu chuyện\n" .
                                "- Địa điểm diễn ra câu chuyện\n" .
                                "- Môi trường xung quanh\n" .
                                "Ví dụ:\n" .
                                "- Thời gian: Thế kỷ 21, Địa điểm: Thành phố New York, Môi trường: Hiện đại, nhộn nhịp.\n" .
                                "- Thời gian: Thời Trung Cổ, Địa điểm: Một ngôi làng nhỏ ở châu Âu, Môi trường: Cổ kính, yên bình.\n\n" .
                                "Cốt truyện chính: Hãy bổ sung chi tiết về các sự kiện chính và các bước ngoặt trong câu chuyện. Vui lòng cung cấp các thông tin sau:\n" .
                                "- Các sự kiện chính\n" .
                                "- Những bước ngoặt quan trọng\n" .
                                "- Phát triển của cốt truyện\n" .
                                "Ví dụ:\n" .
                                "- Sự kiện chính: John tìm thấy manh mối về kho báu, Bước ngoặt: John phát hiện ra người bạn thân Sarah là gián điệp\n" .
                                "- Phát triển: John phải đối mặt với kẻ thù và quyết định tiếp tục cuộc tìm kiếm một mình.\n\n" .
                                "Chủ đề: Hãy bổ sung thông tin về các chủ đề chính của câu chuyện. Vui lòng cung cấp các thông tin sau:\n" .
                                "- Chủ đề chính của truyện\n" .
                                "- Thông điệp mà câu chuyện muốn truyền tải\n" .
                                "Ví dụ:\n" .
                                "- Chủ đề: Sự dũng cảm và lòng trung thực\n" .
                                "- Thông điệp: Sự dũng cảm và trung thực sẽ giúp con người vượt qua mọi thử thách."
                        ],
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
