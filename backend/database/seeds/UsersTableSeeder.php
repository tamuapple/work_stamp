<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    User::create([
      'username' => 'test',
      'email' => 'test@gmail.com',
      'password' => bcrypt('testtest')
    ]);

    // foreach(range(1, 10) as $i){
    //   $email = $i == 1 ? "admin@gmail.com" : "admin{$i}@gmail.com";

      User::create([
        'username' => '管理者',
        'email' => 'admin@gmail.com',
        // 'email' => $email,
        'password' => bcrypt('adminadmin'),
        'role' => 1
      ]);
    // }

    factory(User::class, 500)->create();
  }
}
