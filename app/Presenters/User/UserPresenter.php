<?php

namespace App\Presenters\User;

use App\Transformers\UserTransformer;

class UserPresenter extends \Nahid\Presento\Presenter
{

    public function present(): array
    {
        return [
            'user_id' => 'id',
            'first_name',
            'last_name',
            'email',
            'username',
            'phone',
            'address',
            'email_verified_at',
        ];
    }

    // UserPresenter.php
    public function transformer()
    {
        return UserTransformer::class;
    }
}
