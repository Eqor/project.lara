<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class DiggingDeeperController extends Controller
{
    public function collections()
    {
        /**
         * @var Collection $eloquentColletion
         */
        $eloquentColletion = BlogPost::withTrashed()->get();
//       dd(__METHOD__,$eloquentColletion,$eloquentColletion->toArray());

        $collection = collect($eloquentColletion->toArray());
//       dd(
//         get_class($eloquentColletion),
//           get_class($collection),
//           $collection
//       );
//       $result['first'] = $collection->first();
//       $result['last'] = $collection->last();
//       dd($result);

//        $result['where']['data'] = $collection
//            ->where('category_id', 4)
//            ->sortByDesc('id')
//            ->values()
//            ->keyBy('id');

//       $result['where']['count'] = $result['where']['data']->count();
//       $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
//       $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty();
//
//        Базовая переменная не изменитья
//       $result['map']['all'] = $collection->map(function (array $item) {
//           $newItem = new \stdClass();
//           $newItem->item_id = $item['id'];
//           $newItem->item_name = $item['title'];
//           $newItem->exists = is_null($item['deleted_at']);
//           return $newItem;
//       })
//           ->values()
//           ->keyBy('item_id');

        $collection->transform(function (array $item) {
            $newItem = new \stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);

            return $newItem;

        });


//        $newItem = new \stdClass();
//        $newItem->id = 999;
//
//        $newItem2 = new \stdClass();
//        $newItem2->id = 1999;

        // Цстановить элементв начало коллекции и в конец, вытащить из колекции N-ый элемент
//        $newItemFirst = $collection->prepend($newItem)->first();
//        $newItemLast = $collection->push($newItem2)->last();
//        $pullItem = $collection->pull(10);
//        dd(compact('collection', 'newItemFirst','newItemLast', 'pullItem'));

        //Фильтрация. Замена orWhere()
//        $filtred = $collection->filter(function ($item) {
//            $byDay= $item->created_at->isFriday();
//            $byDate = $item->created_at->day == 7;
//            $result = $byDate && $byDay;
//
//            return $result;
//        });
//        dd(compact('filtred'));


    }
}
