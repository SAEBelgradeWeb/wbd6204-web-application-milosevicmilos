<?php

namespace Tests\Feature;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

abstract class APITest extends TestCase
{
    protected function userWithRoleCannotAccessEndpoints(string $role, string $resource): void
    {
        $apiDomain = Config::get('app.api_url');

        $this->actAsUserWithRole($role);

        $response = $this->get($apiDomain . $resource);
        $response->assertForbidden();

        $response = $this->get($apiDomain . $resource . '/1');
        $response->assertForbidden();

        $response = $this->post($apiDomain . $resource);
        $response->assertForbidden();

        $response = $this->patch($apiDomain . $resource . '/1');
        $response->assertForbidden();

        $response = $this->delete($apiDomain . $resource . '/1');
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

        $apiDomain = Config::get('app.api_url');

        $response = $this->getJson($apiDomain . '/' . $modelType->getTable());

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

        $apiDomain = Config::get('app.api_url');

        $response = $this->getJson($apiDomain . '/' . $modelType->getTable() . '/' . $model->id);

        $response
            ->assertStatus(200)
            ->assertJsonFragment($model->toArray());
    }

    public function userWithRoleCanCreateModelOfType(string $role, Model $modelType, array $inputAttributes, array $outputAttributes): void
    {
        $this->actAsUserWithRole($role);

        $apiDomain = Config::get('app.api_url');

        $response = $this->postJson($apiDomain . '/' . $modelType->getTable(), $inputAttributes);

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

        $apiDomain = Config::get('app.api_url');

        $response = $this->patchJson($apiDomain . '/' . $modelType->getTable() . '/' . $model->id, $attributes);

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

        $apiDomain = Config::get('app.api_url');

        $response = $this->deleteJson($apiDomain . '/' . $modelType->getTable() . '/' . $model->id);

        $response
            ->assertStatus(204);
    }
}
