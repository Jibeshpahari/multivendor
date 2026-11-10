<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

class Product extends Model
{

    use HasUuids;

    protected $primaryKey = 'uuid';

    protected $guarded = [];


    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    #[Override]
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function productMedia(): HasMany
    {
        return $this->hasMany(ProductMedia::class, 'product_id', 'uuid');
    }
}
