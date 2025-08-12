<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class FetchMockDataService
{
    public function fetch(): void
    {
        try {

            $responses = Http::pool(fn (Pool $pool) => [
                $pool->get(config('mock-api.url').'/users?_limit=10'),
                $pool->get(config('mock-api.url').'/posts?_limit=10'),
                $pool->get(config('mock-api.url').'/comments?_limit=10'),
            ]);

            foreach ($responses as $resp) {
                if ($resp->failed()) {
                    $resp->throw();
                }
            }

            $this->saveToDbUsers($responses[0]->json());
            $this->saveToDbPosts($responses[1]->json());
            $this->saveToDbComments($responses[2]->json());

        } catch (\Throwable|\Exception $e) {
            response('Error on Data Importer Class');
        }

    }

    private function saveToDbUsers(array $respData): void
    {
        foreach ($respData as $resp) {

            User::updateOrCreate(
                ['email' => $resp['email']],
                [
                    'name' => $resp['name'],
                    'username' => $resp['username'],
                    'password' => Hash::make('password'),
                    'address' => $resp['address'],
                    'phone' => $resp['phone'],
                    'website' => $resp['website'],
                    'company' => $resp['company'],
                ]
            );

        }

    }

    private function saveToDbPosts(array $respData): void
    {
        foreach ($respData as $resp) {

            $user = User::find($resp['userId']);

            $post = $user->posts()->create([
                'title' => $resp['title'],
                'body' => $resp['body'],
            ]);

        }

    }

    private function saveToDbComments(array $respData): void
    {
        foreach ($respData as $resp) {

            $post = Post::find($resp['postId']);

            $comment = $post->comments()->create([
                'name' => $resp['name'],
                'email' => $resp['email'],
                'body' => $resp['body'],
            ]);
        }

    }
}
