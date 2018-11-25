<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Field;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultFields = [
            [
                'meta' => null,
                'name' => 'name',
                'protected' => 1,
                'required' => 1,
                'title' => 'Name',
                'type' => 'string',
            ], [
                'meta' => json_encode([
                    'validations' => [
                        'email',
                        'unique',
                    ],
                ]),
                'name' => 'email_address',
                'protected' => 1,
                'required' => 1,
                'title' => 'Email Address',
                'type' => 'string',
            ], [
                'meta' => json_encode([
                    'options' => [
                        'active',
                        'unsubscribed',
                        'junk',
                        'bounced',
                        'unconfirmed',
                    ],
                ]),
                'name' => 'state',
                'protected' => 1,
                'required' => 1,
                'title' => 'State',
                'type' => 'list',
            ], [
                'name' => 'where_did_you_hear_from_us',
                'meta' => null,
                'protected' => 0,
                'required' => 0,
                'title' => 'Where did you hear from us?',
                'type' => 'string',
            ],
        ];

        foreach ($defaultFields as $fieldData) {
            Field::updateOrCreate([
                'name' => $fieldData['name'],
            ], $fieldData);
        }
    }
}
