<?php

use Illuminate\Support\Facades\Route;

use App\Models\Aggregation;
use App\Models\Collection;
use App\Models\Comment;
use App\Models\Document;
use App\Models\Image;
use App\Models\Note;
use App\Models\Place;

use App\Models\Map;
use App\Models\MapKey;
use App\Models\MapLayer;
use App\Models\MapEntry;

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

            $aggregation->created_at = $s['attributes']['createdAt'];
            $aggregation->save();

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

Route::get('/import-old-maps', function() {
    $url = 'https://pia-api.dhlab.unibas.ch/api/v1/maps';
    $maps = json_decode(file_get_contents($url), true);

    foreach ($maps['data'] as $key => $m) {
        $map = Map::create([
            'label' => $m['attributes']['label'],
            'description' => $m['attributes']['description'],
            'origin' => $m['attributes']['origin'],
            'tiles' => $m['attributes']['tiles'],
        ]);

        $map_keys_url = 'https://pia-api.dhlab.unibas.ch/api/v1/maps/'.$m['id'].'/map-keys';
        $map_keys = json_decode(file_get_contents($map_keys_url), true);

        foreach ($map_keys['data'] as $key => $mk) {
            $map->mapKeys()->create([
                'label' => $mk['attributes']['label'],
                'icon' => $mk['attributes']['icon'],
                'icon_file_name' => $mk['attributes']['icon_file_name'],
                'original_icon_file_name' => $mk['attributes']['original_icon_file_name'],
            ]);
        }

        $map_layers_url = 'https://pia-api.dhlab.unibas.ch/api/v1/maps/'.$m['id'].'/map-layers';
        $map_layers = json_decode(file_get_contents($map_layers_url), true);

        foreach ($map_layers['data'] as $key => $ml) {
            $map_layer = $map->mapLayers()->create([
                'label' => $ml['attributes']['label'],
                'zoom_min' => $ml['attributes']['zoom_min'],
                'zoom_max' => $ml['attributes']['zoom_max'],
            ]);

            $map_entries_url = 'https://pia-api.dhlab.unibas.ch/api/v1/map-layers/'.$ml['id'].'/map-entries?include=location,map-keys,image';
            $map_entries = json_decode(file_get_contents($map_entries_url), true);

            $locations = [];
            $map_keys = [];
            $images = [];

            if(isset($map_entries['included'])) {
                foreach ($map_entries['included'] as $key => $incl) {
                    if($incl['type'] == 'locations') {
                        $locations[$incl['id']] = $incl;
                    }
                    if($incl['type'] == 'map-keys') {
                        $map_keys[$incl['id']] = $incl;
                    }
                    if($incl['type'] == 'images') {
                        $images[$incl['id']] = $incl;
                    }
                }
            }

            foreach ($map_entries['data'] as $key => $me) {
                $map_entry = $map_layer->mapEntries()->create([
                    'label' => $me['attributes']['label'],
                    'type' => $me['attributes']['type'],
                    'complex_data' => $me['attributes']['complex_data'],
                ]);

                if(isset($me['relationships']['location']['data'])) {
                    $l = $locations[$me['relationships']['location']['data']['id']];
                    $place = Place::create([
                        'label' => $l['attributes']['label'],
                        'latitude' => $l['attributes']['latitude'],
                        'longitude' => $l['attributes']['longitude'],
                    ]);

                    $map_entry->place_id = $place->id;
                    $map_entry->save();
                }
                if(isset($me['relationships']['map-keys']['data'])) {
                    foreach($me['relationships']['map-keys']['data'] as $key => $mek) {
                        $mek = $map_keys[$mek['id']];
                        $map_entry_key = MapKey::where('label', $mek['attributes']['label'])->first();
                        if($map_entry_key){
                            $map_entry->mapKeys()->attach($map_entry_key);
                        }
                    }
                }
                if(isset($me['relationships']['image']['data'])) {
                    $img = $images[$me['relationships']['image']['data']['id']];
                    $image = Image::where('signature', $img['attributes']['signature'])->first();
                    if($image){
                        $map_entry->image_id = $image->id;
                        $map_entry->save();
                    }
                }

            }
        }

        $collections_url = 'https://pia-api.dhlab.unibas.ch/api/v1/maps/'.$m['id'].'/collections';
        $collections = json_decode(file_get_contents($collections_url), true);

        foreach ($collections['data'] as $key => $c) {
            $collection = Collection::where('label', $c['attributes']['label'])->first();
            if($collection){
                $map->collections()->attach($collection);
            }
        }
    }
});

Route::get('/fix-comment-relations', function(){

    print('hello');

    DB::connection('pia')->table('comment_image')->get()->each(function($entry, $i){
        $comment = Comment::find($entry->comment_id);
        if($comment->image_id == ''){
            $comment->image_id = $entry->image_id;
            $comment->save();
        }
    });

    DB::connection('pia')->table('collection_comment')->get()->each(function($entry, $i){
        $comment = Comment::find($entry->comment_id);
        if($comment->collection_id == ''){
            $comment->collection_id = $entry->collection_id;
            $comment->save();
        }
    });

    DB::connection('pia')->table('album_comment')->get()->each(function($entry, $i){
        $comment = Comment::find($entry->comment_id);
        if($comment->album_id == ''){
            $comment->album_id = $entry->album_id;
            $comment->save();
        }
    });

    DB::connection('pia')->table('agent_comment')->get()->each(function($entry, $i){
        $comment = Comment::find($entry->comment_id);
        if($comment->agent_id == ''){
            $comment->agent_id = $entry->agent_id;
            $comment->save();
        }
    });

    print('bye');

});
