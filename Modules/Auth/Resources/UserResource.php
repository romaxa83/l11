<?php

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Models\User;
use OpenAPI\Properties\PropertySlug;
use OpenAPI\Properties\PropertyString;
use OpenAPI\Schemas\BaseScheme;

#[BaseScheme(
    resource: UserResource::class,
    properties: [
        new PropertyString(property: 'name'),
        new PropertySlug(),
    ]
)]
/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
