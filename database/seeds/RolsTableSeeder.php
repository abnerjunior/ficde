<?php

use Illuminate\Database\Seeder;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('rols')->insert([
        	[
        		'nombre' => 'admin',
        		'permissions' => '
        			[
        				{
							"admin": {
						      "viewAny": true,
						      "inscription": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "students": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "users": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "headquarters": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "sheadquarters": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "classrooms": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "semesters": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "courses": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "coursesclassrooms": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "subjects": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "modalities": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      },
						      "turn": {
						        "viewAny": true,
						        "read": true,
						        "add": true,
						        "edit": true,
						       "delete": true,
						        "restore": true
						      }
	        				}
        				}
        			]
        		',
        		'user_r' => 'Luis Palma'
        	]
        ]);
    }
}
