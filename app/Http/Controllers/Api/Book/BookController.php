<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Services\Api\Book\GenerateDescBookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function generateBookDesc(Request $request)
    {
        $lines = explode("\n", $request->input('old_description'));
        $filteredLines = array_filter($lines, 'trim');
        $oldDescription = implode("\n", $filteredLines);

        $newDescription = resolve(GenerateDescBookService::class)->generateDesc($oldDescription);

        return response()->json($newDescription);
    }
}
