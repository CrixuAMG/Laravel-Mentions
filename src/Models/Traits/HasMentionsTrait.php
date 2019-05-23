<?php
namespace CrixuAMG\Mentions\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use CrixuAMG\Mentions\Models\Repositories\MentionRepository;
use CrixuAMG\Mentions\Models\Mention;

trait HasMentionsTrait
{
    /**
     * Create a new mention for the given model(s).
     *
     * @return bool|\CrixuAMG\Mentions\Models\Mention
     */
    public function mention(Model $model, bool $notify = true): Mention
    {
        return MentionRepository::create($this, $model, $notify);
    }

    /**
     * Gets all mentions for the given model.
     *
     * @return Collection Model
     */
    public function mentions(bool $resolve = true)
    {
        $mentions = MentionRepository::get($this);

        if ($resolve) {
            $mentions = $mentions->map(function ($mention) {
                return $mention->recipient();
            });
        }

        return $mentions;
    }
}
