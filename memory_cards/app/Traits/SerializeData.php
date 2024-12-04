<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait SerializeData
{
    /**
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
