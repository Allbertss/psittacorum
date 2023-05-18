<?php

namespace App\form\user;

use App\entity\User;

class RegistrationForm
{
    private string $username;
    private string $password;
    private array $errors = [];

    public function save(): User
    {
        $user = User::create($this->username, $this->password);

        $this->userMapper->save($user);

        return $user;
    }

    public function hasValidationErrors(): bool
    {
        return count($this->getValidationErrors()) > 0;
    }

    public function getValidationErrors(): array
    {
        if (!empty($this->errors)) {
            return $this->errors;
        }

        if (strlen($this->username) < 5 || strlen($this->username) > 255) {
            $this->errors[] = "Username must be between 5 and 255 characters";
        }

        if (!preg_match('/^w+$/', $this->username)) {
            $this->errors[] = "Username can only consists of word characters without spaces";
        }

        if (strlen($this->password) < 6 || strlen($this->password) > 255) {
            $this->errors[] = "Password must be between 6 and 255 characters";
        }

        return $this->errors;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return RegistrationForm
     */
    public function setUsername(string $username): RegistrationForm
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return RegistrationForm
     */
    public function setPassword(string $password): RegistrationForm
    {
        $this->password = $password;
        return $this;
    }
}