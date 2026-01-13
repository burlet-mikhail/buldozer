<?php

namespace App\Http\Controllers;

use App\Services\Sitemap\SitemapService;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SitemapController extends Controller
{
    public function __construct(
        private readonly SitemapService $sitemapService
    ) {}

    /**
     * Отдать главный sitemap.xml (index)
     */
    public function index(): Response
    {
        $content = $this->sitemapService->getIndex();

        if (!$content) {
            abort(SymfonyResponse::HTTP_NOT_FOUND);
        }

        return $this->xmlResponse($content);
    }

    /**
     * Отдать конкретный sitemap файл
     */
    public function show(string $filename): Response
    {
        // Защита от path traversal
        $filename = basename($filename);

        if (!str_ends_with($filename, '.xml')) {
            abort(SymfonyResponse::HTTP_NOT_FOUND);
        }

        $content = $this->sitemapService->getCached($filename);

        if (!$content) {
            abort(SymfonyResponse::HTTP_NOT_FOUND);
        }

        return $this->xmlResponse($content);
    }

    private function xmlResponse(string $content): Response
    {
        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
