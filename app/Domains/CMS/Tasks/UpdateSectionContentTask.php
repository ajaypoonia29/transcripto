<?php

declare(strict_types=1);

namespace App\Domains\CMS\Tasks;

use App\Domains\CMS\Models\HomepageSection;

class UpdateSectionContentTask
{
    /**
     * Update the json content of a section.
     *
     * @param string $sectionKey
     * @param array<string, mixed> $content
     * @return HomepageSection
     */
    public function execute(string $sectionKey, array $content): HomepageSection
    {
        /** @var HomepageSection $section */
        $section = HomepageSection::query()->where('section_key', $sectionKey)->firstOrFail();

        $section->update([
            'content' => $content,
        ]);

        return $section;
    }
}
