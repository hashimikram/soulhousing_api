<?php

namespace Database\Seeders;

use App\Models\bed;
use App\Models\floor;
use App\Models\room;
use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'floors' => [
                [
                    'title' => 'Ground Floor',
                    'rooms' => [
                        [
                            'title' => 'Emergency Room 1',
                            'beds' => [
                                ['title' => 'Bed 1A'],
                                ['title' => 'Bed 1B'],
                                ['title' => 'Bed 1C'],
                            ],
                        ],
                        [
                            'title' => 'Emergency Room 2',
                            'beds' => [
                                ['title' => 'Bed 2A'],
                                ['title' => 'Bed 2B'],
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'First Floor',
                    'rooms' => [
                        [
                            'title' => 'ICU 1',
                            'beds' => [
                                ['title' => 'Bed 1A'],
                                ['title' => 'Bed 1B'],
                            ],
                        ],
                        [
                            'title' => 'ICU 2',
                            'beds' => [
                                ['title' => 'Bed 2A'],
                                ['title' => 'Bed 2B'],
                                ['title' => 'Bed 2C'],
                            ],
                        ],
                    ],
                ],
                [
                    'title' => 'Second Floor',
                    'rooms' => [
                        [
                            'title' => 'General Ward 1',
                            'beds' => [
                                ['title' => 'Bed 1A'],
                                ['title' => 'Bed 1B'],
                                ['title' => 'Bed 1C'],
                                ['title' => 'Bed 1D'],
                            ],
                        ],
                        [
                            'title' => 'General Ward 2',
                            'beds' => [
                                ['title' => 'Bed 2A'],
                                ['title' => 'Bed 2B'],
                                ['title' => 'Bed 2C'],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data['floors'] as $floorData) {
            $floor = Floor::create([
                'facility_id' => 1,
                'floor_name' => $floorData['title'],
            ]);

            foreach ($floorData['rooms'] as $roomData) {
                $room = Room::create([
                    'floor_id' => $floor->id,
                    'room_name' => $roomData['title'],
                ]);

                foreach ($roomData['beds'] as $bedData) {
                    Bed::create([
                        'room_id' => $room->id,
                        'bed_title' => $bedData['title'],
                        'status' => 'vacant',
                        'comments' => '',
                    ]);
                }
            }
        }
    }
}
