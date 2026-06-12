<?php

declare(strict_types=1);

namespace App\Http\Controllers\CMS;

use App\Domains\CMS\Actions\MutateHomepageLayoutAction;
use App\Domains\CMS\Actions\FetchHomepageSectionsAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use InvalidArgumentException;

class HomepageSectionController extends Controller
{
    public function __construct(
        protected readonly MutateHomepageLayoutAction $mutateHomepageLayoutAction,
        protected readonly FetchHomepageSectionsAction $fetchHomepageSectionsAction
    ) {}

    /**
     * Display a listing of homepage sections.
     */
    public function index(): JsonResponse
    {
        $sections = $this->fetchHomepageSectionsAction->execute();

        return response()->json([
            'success' => true,
            'data' => $sections,
        ], Response::HTTP_OK);
    }

    /**
     * Update the layout content for a homepage section.
     */
    public function update(Request $request, string $sectionKey): JsonResponse
    {
        $validated = $request->validate([
            'content' => ['required', 'array'],
        ]);

        try {
            $section = $this->mutateHomepageLayoutAction->execute(
                $sectionKey,
                (array) $validated['content']
            );

            return response()->json([
                'success' => true,
                'message' => 'Homepage section content mutated successfully.',
                'data' => [
                    'id' => $section->id,
                    'section_key' => $section->section_key,
                    'title' => $section->title,
                    'subtitle' => $section->subtitle,
                    'content' => $section->content,
                    'is_visible' => $section->is_visible,
                ],
            ], Response::HTTP_OK);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
