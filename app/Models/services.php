<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Subscriptions;

class Service extends Model
{
    protected $fillable = ["name", "price", "description", "status"];
    protected function casts(): array
    {
        return [
            "status" => "boolean",
            "price" => "integer",
        ];
    }
    /**
     * @return HasMany<Subscriptions, $this>
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscriptions::class);
    }
}
