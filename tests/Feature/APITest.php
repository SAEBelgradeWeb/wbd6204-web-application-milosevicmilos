<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

abstract class APITest extends TestCase
{
    // TODO: Add Sanctum Test for valid and invalid logins.

    /**
     * @param string $role
     * @return User
     */
    public function actAsUserWithRole(string $role): User
    {
        $user = User::factory()->create(['role' => $role]);

        Sanctum::actingAs(
            $user
        );

        return $user;
    }

    /**
     * @return string
     */
    protected function getApiDomain(): string
    {
        return Config::get('app.api_url');
    }

    /**
     * @param string $role
     * @param string $resource
     */
    protected function userWithRoleCannotAccessEndpoints(string $role, string $resource): void
    {
        $this->actAsUserWithRole($role);

        $response = $this->get($this->getApiDomain() . $resource);
        $response->assertForbidden();

        $response = $this->get($this->getApiDomain() . $resource . '/1');
        $response->assertForbidden();

        $response = $this->post($this->getApiDomain() . $resource);
        $response->assertForbidden();

        $response = $this->patch($this->getApiDomain() . $resource . '/1');
        $response->assertForbidden();

        $response = $this->delete($this->getApiDomain() . $resource . '/1');
        $response->assertForbidden();
    }

    /**
     * @param string $role
     * @param Model $modelType
     * @throws Exception
     */
    public function userWithRoleCanGetAllModelsOfType(string $role, Model $modelType): void
    {
        $this->actAsUserWithRole($role);

        $entitiesCount = random_int(1, 100);

        $modelType::factory()->count($entitiesCount)->create();

        $response = $this->getJson($this->getApiDomain() . '/' . $modelType->getTable());

        $response
            ->assertStatus(200)
            ->assertJsonCount($entitiesCount + 1, $modelType->getTable())
            ->assertJsonStructure([
                $modelType->getTable() => [
                    '*' => array_values($modelType->getVisible())
                ]
            ]);
    }

    /**
     * @param string $role
     * @param Model $modelType
     */
    public function userWithRoleCanGetOneModelOfType(string $role, Model $modelType): void
    {
        $this->actAsUserWithRole($role);

        /** @var Model $model */
        $model = $modelType::factory()->create();

        $response = $this->getJson($this->getApiDomain() . '/' . $modelType->getTable() . '/' . $model->id);

        $response
            ->assertStatus(200)
            ->assertJsonFragment($model->toArray());
    }

    public function userWithRoleCanCreateModelOfType(string $role, Model $modelType, array $inputAttributes, array $outputAttributes): void
    {
        $this->actAsUserWithRole($role);

        $response = $this->postJson($this->getApiDomain() . '/' . $modelType->getTable(), $inputAttributes);

        $response
            ->assertStatus(201)
            ->assertJsonFragment($outputAttributes);
    }

    /**
     * @param string $role
     * @param Model $modelType
     * @param array $attributes
     */
    public function userWithRoleCanUpdateModelOfType(string $role, Model $modelType, array $attributes): void
    {
        $this->actAsUserWithRole($role);

        $model = $modelType::factory()->create();

        $response = $this->patchJson($this->getApiDomain() . '/' . $modelType->getTable() . '/' . $model->id, $attributes);

        $response
            ->assertStatus(200)
            ->assertJsonFragment($attributes);
    }

    /**
     * @param string $role
     * @param Model $modelType
     */
    public function userWithRoleCanDeleteModelOfType(string $role, Model $modelType): void
    {
        $this->actAsUserWithRole($role);

        $model = $modelType::factory()->create();

        $response = $this->deleteJson($this->getApiDomain() . '/' . $modelType->getTable() . '/' . $model->id);

        $response
            ->assertStatus(204)
            ->assertNoContent();
    }
}
