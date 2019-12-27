<?php

declare(strict_types=1);

namespace PrusakTech\Laravel\Firebase\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kreait\Firebase\Firestore
 * @mixin \Kreait\Firebase\Firestore
 */
final class FirebaseFirestore extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'firebase.firestore';
    }
}
