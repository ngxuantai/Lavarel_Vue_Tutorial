<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    /**
     * Only use for test - Not use for product
     *
     */
    $this->call([
      UserSeeder::class,
    ]);
  }
}
