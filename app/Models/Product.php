<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Override;

class Product extends Model
{

    use HasUuids;

    #[Override]
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
