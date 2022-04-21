<?php

use Illuminate\Support\Facades\Route;

use App\Models\Aggregation;
use App\Models\Collection;
use App\Models\Document;
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

Route::get('/import-old-documents', function() {
    $url = 'https://pia-api.dhlab.unibas.ch/api/v1/documents';
    $documents = json_decode(file_get_contents($url), true);

    foreach ($documents['data'] as $key => $d) {
        $document = Document::where('label', $d['attributes']['label'])->first();

        if(!$document){
            $document_collection_url = 'https://pia-api.dhlab.unibas.ch/api/v1/documents/'.$d['id'].'/collections';
            $document_collection = json_decode(file_get_contents($document_collection_url), true);

            if(count($document_collection['data']) > 0){
                $collection = Collection::where('label', $document_collection['data'][0]['attributes']['label'])->first();
                if($collection){
                    $collection->documents()->create([
                        'label' => $d['attributes']['label'],
                        'file_name' => $d['attributes']['file_name'],
                        'original_file_name' => $d['attributes']['original_file_name'],
                        'base_path' => $d['attributes']['base_path']
                    ]);
                    
                }
            }
        }
    }
});

Route::get('/import-old-restoration', function() {
    $url = 'https://pia-api.dhlab.unibas.ch/api/v1/sets';
    $sets = json_decode(file_get_contents($url), true);

    foreach ($sets['data'] as $key => $s) {
        if($s['attributes']['deletedAt'] == null){
            $aggregation = Aggregation::create([
                'label' => $s['attributes']['label'],
                'description' => $s['attributes']['description'],
                'signatures' => $s['attributes']['signatures'],
                'origin' => $s['attributes']['origin'],
            ]);

            $set_documents_url = 'https://pia-api.dhlab.unibas.ch/api/v1/sets/'.$s['id'].'/documents';
            $set_documents = json_decode(file_get_contents($set_documents_url), true);


            foreach ($set_documents['data'] as $key => $sd) {
                $aggregation->documents()->create([
                    'label' => $sd['attributes']['label'],
                    'file_name' => $sd['attributes']['file_name'],
                    'original_file_name' => $sd['attributes']['original_file_name'],
                    'base_path' => $sd['attributes']['base_path']
                ]);
        }
        }
    }
});
