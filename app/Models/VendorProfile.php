<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class VendorProfile extends Model
{

    protected $guarded = [];

    #[Override]
    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
