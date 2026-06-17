<?php

namespace Database\Seeders;

use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        Borrowing::query()->delete();
        Item::query()->delete();

        $items = [
            [
                'item_name' => 'All in one video kit',
                'type' => 'Video kit',
                'description' => 'Complete video set',
                'category' => 'Kits',
                'image' => 'images/all_in_one_video_kit/DSC07525.JPG',
                'images' => [
                    'images/all_in_one_video_kit/DSC07524.JPG',
                    'images/all_in_one_video_kit/DSC07526.JPG',
                    'images/all_in_one_video_kit/DSC07527.JPG',
                    'images/all_in_one_video_kit/DSC07528.JPG',
                    'images/all_in_one_video_kit/DSC07529.JPG',
                    'images/all_in_one_video_kit/DSC07530.JPG',
                    'images/all_in_one_video_kit/DSC07531.JPG',
                    'images/all_in_one_video_kit/DSC07532.JPG',
                    'images/all_in_one_video_kit/DSC07534.JPG',
                    'images/all_in_one_video_kit/DSC07561.JPG',
                ],
                'quantity_total' => 1,
                'quantity_available' => 1,
                'status' => 'available',
                'video_link' => 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
            ],
            [
                'item_name' => 'Continu licht',
                'type' => 'Licht',
                'description' => 'Continu belichting',
                'category' => 'Licht',
                'image' => 'images/continu_licht/DSC07550.JPG',
                'images' => [],
                'quantity_total' => 2,
                'quantity_available' => 2,
                'status' => 'available',
                'video_link' => null,
            ],
            [
                'item_name' => 'LED panel + statief',
                'type' => 'Lichtset',
                'description' => 'LED paneel met statief',
                'category' => 'Licht',
                'image' => 'images/led_paneel_statief/DSC07564.JPG',
                'images' => [],
                'quantity_total' => 2,
                'quantity_available' => 2,
                'status' => 'available',
                'video_link' => 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
            ],
            [
                'item_name' => 'Microfoon',
                'type' => 'Microfoon',
                'description' => 'Audio opname',
                'category' => 'Audio',
                'image' => 'images/microfoon/DSC07545.JPG',
                'images' => [],
                'quantity_total' => 4,
                'quantity_available' => 4,
                'status' => 'available',
                'video_link' => null,
            ],
            [
                'item_name' => 'Mobile Gimbal',
                'type' => 'Gimbal',
                'description' => 'Stabilisatie voor mobiel',
                'category' => 'Stabilisatie',
                'image' => 'images/mobile_gimbal/DSC07520.JPG',
                'images' => [],
                'quantity_total' => 2,
                'quantity_available' => 2,
                'status' => 'available',
                'video_link' => 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
            ],
            [
                'item_name' => 'Osmo Pocket',
                'type' => 'Pocket camera',
                'description' => 'Compacte camera',
                'category' => 'Camera',
                'image' => 'images/osmo_pocket/DSC07505.JPG',
                'images' => [],
                'quantity_total' => 2,
                'quantity_available' => 2,
                'status' => 'available',
                'video_link' => null,
            ],
            [
                'item_name' => 'Reportage filter FILTERS',
                'type' => 'Filter',
                'description' => 'Reportage filter set',
                'category' => 'Filters',
                'image' => 'images/reportage_flitser_filters/DSC07507.JPG',
                'images' => [],
                'quantity_total' => 3,
                'quantity_available' => 3,
                'status' => 'available',
                'video_link' => 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
            ],
            [
                'item_name' => 'RGB continu licht paneel',
                'type' => 'RGB licht',
                'description' => 'RGB continu licht paneel',
                'category' => 'Licht',
                'image' => 'images/rgb_continue_licht_paneel/DSC07555.JPG',
                'images' => [],
                'quantity_total' => 2,
                'quantity_available' => 2,
                'status' => 'available',
                'video_link' => 'https://www.youtube.com/watch?v=oWJ1YAkF9yU',
            ],
            [
                'item_name' => 'RGB tube, magnetisch',
                'type' => 'RGB tube',
                'description' => 'Magnetische RGB licht tube',
                'category' => 'Licht',
                'image' => 'images/rgb_tube_magnetisch/DSC07552.JPG',
                'images' => [],
                'quantity_total' => 2,
                'quantity_available' => 2,
                'status' => 'available',
                'video_link' => null,
            ],
            [
                'item_name' => 'Sony set ZV-E10',
                'type' => 'Camera set',
                'description' => 'Sony ZV-E10 camera set',
                'category' => 'Camera',
                'image' => 'images/sony_set_zv_e10/DSC07510.JPG',
                'images' => [],
                'quantity_total' => 2,
                'quantity_available' => 2,
                'status' => 'available',
                'video_link' => null,
            ],
            [
                'item_name' => 'Wireless ME',
                'type' => 'Draadloze microfoon',
                'description' => 'Wireless audio set',
                'category' => 'Audio',
                'image' => 'images/wireless_me/DSC07538.JPG',
                'images' => [],
                'quantity_total' => 3,
                'quantity_available' => 3,
                'status' => 'available',
                'video_link' => null,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
