<?php

declare(strict_types=1);

namespace App\Domains\CMS\Actions;

use App\Domains\CMS\Models\HomepageSection;
use Illuminate\Database\Eloquent\Collection;

class FetchHomepageSectionsAction
{
    /**
     * Fetch all homepage sections.
     *
     * @return Collection<int, HomepageSection>
     */
    public function execute(): Collection
    {
        return HomepageSection::query()->get();
    }
}
