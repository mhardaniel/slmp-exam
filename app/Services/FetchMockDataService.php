<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class FetchMockDataService
{
    public function fetch(): void
    {
        try {

            $response = Http::get(config('mock-api.url'));

            if ($response->failed()) {
                $response->throw();
            }

            $this->saveToDb($response);

        } catch (\Throwable|\Exception $e) {
            response('Error on Data Importer Class');
        }

    }

    private function saveToDb($respData): void
    {
        foreach ($respData as $resp) {

            $inputEmail = $resp['email'];

            $userQuery = User::updateOrCreate(
                ['email' => $inputEmail],
                [
                    'name' => $resp['name'],
                    'username' => $resp['username'],
                    'address' => $resp['address'],
                    'phone' => $resp['phone'],
                    'website' => $resp['website'],
                    'company' => $resp['company'],
                ]
            );

        }

    }
}
