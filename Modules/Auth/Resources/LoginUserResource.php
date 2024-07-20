<?php

namespace Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenAPI\Properties\PropertyString;
use OpenAPI\Schemas\BaseScheme;

#[BaseScheme(
    resource: LoginUserResource::class,
    properties: [
        new PropertyString(property: 'token'),
    ]
)]
class LoginUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'token' => $this['token'],
        ];
    }
}
