<?php

namespace App\Http\Controllers\Crawl;

use App\Http\Controllers\Controller;
use App\Services\Crawl\CrawlDataService;
use Illuminate\Http\Request;

class CrawlStoryController extends Controller
{
    public function crawl(Request $request)
    {
        $story = resolve(CrawlDataService::class)->setParams($request->all())->handle();

        return response()->json($story);
    }
}
