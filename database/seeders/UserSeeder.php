<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'editer', 'user'];

        foreach($roles as $r){
            $role = new Role();
            $role->name = $r;
            $role->save();
        }

        $users = [
            ['name'=> 'admin', 'username'=> 'admin', 'email'=>'admin@gmail.com', 'password'=> 'admin', 'role_id'=>1],
            ['name'=> 'editer', 'username'=> 'editer', 'email'=>'editer@gmail.com', 'password'=> 'editer', 'role_id'=>2],
            ['name'=> 'user', 'username'=> 'user', 'email'=>'user@gmail.com', 'password'=> 'user', 'role_id'=>3]
        ];

        foreach($users as $user){
            User::create($user);
        }
    }
}
