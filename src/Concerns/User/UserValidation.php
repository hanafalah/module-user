<?php

namespace Hanafalah\ModuleUser\Concerns\User;

trait UserValidation
{
    public function isTakenUsing($user_id, callable $closure, bool $throw = false, ?string $message = null): ?bool
    {
        $user = $this->user($closure)->whereNot('id', $user_id)->first();
        return $this->isExists($message ?? 'user using that conditions', $user, $throw);
    }

    public function isTakenByUsernameId(string $username, $user_id, bool $throw = false): ?bool
    {
        return $this->isTakenUsing($user_id, fn($q) => $q->where('username', $username), $throw, 'username');
    }

    public function isTakenByEmailId(string $email, $user_id, bool $throw = false): ?bool
    {
        return $this->isTakenUsing($user_id, fn($q) => $q->where('email', $email), $throw, 'email');
    }

    private function isExists($field, $model, $throw): ?bool
    {
        $isset = isset($model);
        if ($isset && $throw) throw new \Exception('The ' . $field . ' has already been taken.', 422);
        return $isset;
    }
}
