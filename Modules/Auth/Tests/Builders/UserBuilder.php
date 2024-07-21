<?php

namespace Modules\Auth\Tests\Builders;

use Modules\Auth\Models\User;
use Tests\Builders\BaseBuilder;

class UserBuilder extends BaseBuilder
{
    function modelClass(): string
    {
        return User::class;
    }

    public function credentials(array $data): self
    {
        $this->data['password'] = $data['password'];
        $this->data['email'] = $data['email'];

        return $this;
    }

    public function password(string $value): self
    {
        $this->data['password'] = $value;
        return $this;
    }

    public function email(string $value): self
    {
        $this->data['email'] = $value;
        return $this;
    }
}

