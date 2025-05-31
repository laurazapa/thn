<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Users\Domain\Entity\User;
use Src\Users\Domain\ValueObject\UserEmail;
use Src\Users\Domain\ValueObject\UserId;
use Src\Users\Domain\ValueObject\UserName;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id' => '9d491317-a39b-4ffd-91fe-9a91a5d21ece',
                'name' => 'Voldemort',
                'email' => 'voldemort@example.com',
            ],
            [
                'id' => '5a69179a-3b9d-4c0e-960d-91649eaab013',
                'name' => 'Nagini',
                'email' => 'Nagini@example.com',
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setId(new UserId($userData['id']));
            $user->setName(new UserName($userData['name']));
            $user->setEmail(new UserEmail($userData['email']));
            $user->save();
        }
    }
}
