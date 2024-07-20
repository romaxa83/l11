<?php

namespace Modules\Auth\Requests;

use ArondeParon\RequestSanitizer\Sanitizers\Lowercase;
use ArondeParon\RequestSanitizer\Traits\SanitizesInputs;
use Illuminate\Foundation\Http\FormRequest;
use OpenAPI\Properties\PropertyString;
use OpenAPI\Schemas\BaseScheme;

#[BaseScheme(
    resource: LoginRequest::class,
    properties: [
        new PropertyString(
            property: 'email',
            example: 'example@example.com'
        ),
        new PropertyString(
            property: 'password',
            example: 'Pas$word1'
        ),
    ]
)]
class LoginRequest extends FormRequest
{
    use SanitizesInputs;
    protected $sanitizers = [
        'email' => [
            Lowercase::class,
        ],
    ];
    public function rules(): array
    {
        return [
            'email' => ['required'],
            'password' => ['required'],
        ];
    }
}
