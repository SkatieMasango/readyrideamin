<?php

namespace App\Services;

use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $database;

    public function __construct()
    {
        $firebaseCredentials = config('firebase.credentials');

        if (! $firebaseCredentials || ! file_exists($firebaseCredentials)) {
            throw new \Exception('Firebase credentials file is missing or invalid.');
        }

        try {
            $factory = (new Factory)
                ->withServiceAccount($firebaseCredentials)
                ->withDatabaseUri(config('firebase.database'));

            $this->database = $factory->createDatabase();
        } catch (FirebaseException $e) {
            throw new \Exception('Firebase initialization failed: '.$e->getMessage());
        }
    }

    public function getDatabase()
    {
        return $this->database;
    }
}
