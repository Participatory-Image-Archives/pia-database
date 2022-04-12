<?php

use Illuminate\Support\Facades\Route;

use App\Models\Collection;
use App\Models\Image;
use App\Models\Note;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'hello';
});

Route::get('/import-old-collections', function() {
    $url = 'https://pia-api.dhlab.unibas.ch/api/v1/collections?filter[origin]=pia';
    $collections = json_decode(file_get_contents($url), true);

    foreach ($collections['data'] as $key => $c) {
        $collection = Collection::where('label', $c['attributes']['label'])->first();

        if(!$collection){
            $collection_images_url = 'https://pia-api.dhlab.unibas.ch/api/v1/collections/'.$c['id'].'/images';
            $collection_images = json_decode(file_get_contents($collection_images_url), true);

            $collection = Collection::create([
                'label' => $c['attributes']['label'],
                'origin' => 'pia'
            ]);

            foreach ($collection_images['data'] as $key => $i) {
                $image = Image::where('signature', $i['attributes']['signature'])->first();

                if(!$image) {
                    $image = Image::create([
                        'signature' => $i['attributes']['signature'],
                        'title' => $i['attributes']['title'],
                        'base_path' => $i['attributes']['base_path'],
                    ]);
                }
                $collection->images()->attach($image->id);
            }
        }
    }
});

Route::get('/import-old-notes', function() {
    $url = 'https://pia-api.dhlab.unibas.ch/api/v1/pia-docs';
    $notes = json_decode(file_get_contents($url), true);

    foreach ($notes['data'] as $key => $n) {
        $note = Note::where('label', $n['attributes']['label'])->first();

        if(!$note){
            $note_collection_url = 'https://pia-api.dhlab.unibas.ch/api/v1/pia-docs/'.$n['id'].'/collections';
            $note_collection = json_decode(file_get_contents($note_collection_url), true);

            if(count($note_collection['data']) > 0){
                $collection = Collection::where('label', $note_collection['data'][0]['attributes']['label'])->first();
                $collection->notes()->create([
                    'label' => $n['attributes']['label'],
                    'content' => $n['attributes']['content']
                ]);
            }
        }
    }
});