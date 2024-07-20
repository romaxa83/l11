<?php

namespace Modules\Auth\Requests;

use ArondeParon\RequestSanitizer\Sanitizers\Lowercase;
use ArondeParon\RequestSanitizer\Traits\SanitizesInputs;
use Illuminate\Foundation\Http\FormRequest;

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
