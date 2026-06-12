<?php

declare(strict_types=1);

namespace App\Domains\CMS\Actions;

use App\Domains\CMS\Models\HomepageSection;
use App\Domains\CMS\Tasks\UpdateSectionContentTask;
use InvalidArgumentException;

class MutateHomepageLayoutAction
{
    public function __construct(
        protected readonly UpdateSectionContentTask $updateSectionContentTask
    ) {}

    /**
     * Mutate the homepage layout section content.
     *
     * @param string $sectionKey
     * @param array<string, mixed> $content
     * @return HomepageSection
     * @throws InvalidArgumentException
     */
    public function execute(string $sectionKey, array $content): HomepageSection
    {
        if (empty($sectionKey)) {
            throw new InvalidArgumentException("Section key cannot be empty.");
        }

        // Validate structure of layout payload (e.g. must specify a layout_type)
        if (!isset($content['layout_type'])) {
            throw new InvalidArgumentException("Content payload must contain a 'layout_type' key.");
        }

        return $this->updateSectionContentTask->execute($sectionKey, $content);
    }
}
