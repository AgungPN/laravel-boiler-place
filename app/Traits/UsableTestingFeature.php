<?php

namespace App\Traits;

use App\Enums\Role;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Laravel\Sanctum\Sanctum;
use Psr\SimpleCache\InvalidArgumentException;

trait UsableTestingFeature
{
    // command this the real database will change
    use DatabaseTransactions;

    /**
     * acting login as admin
     *
     * @param User|null $user
     * @return User
     */
//    public function actingAsAdmin(?User $user = null): User
//    {
//        if (is_null($user)) {
//            $user = User::whereHas('roles', function ($query) {
//                $query->where('name', Role::Admin);
//            })->first();
//        }
//
//        Sanctum::actingAs(
//            $user,
//            ['role:' . Role::Admin]
//        );
//
//        return $user;
//    }

    /**
     * Assert response expected attribute is pagination instance.
     *
     * @param TestResponse $response
     * @return void
     */
    public function assertResponseAttributeIsPaginationInstance(TestResponse $response): void
    {
        $response->assertJsonStructure([
            'data',
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
                'path',
                'per_page',
                'to',
                'total',
            ],
        ])
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereAllType([
                    'data' => 'array',
                    'links' => 'array',
                    'meta' => 'array',
                ])
                ->etc()
            );
    }

}
