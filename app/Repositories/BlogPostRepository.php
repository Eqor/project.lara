<?php
namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Class BlogCategoryRepository
 * @package App\Repositories
 */
class BlogPostRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * Получить модель для редактирования в админке.
     * @param int $id
     * @return  Model
     */
    public function getEdit(int $id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     * @param int|null $perPage
     * @return LengthAwarePaginator
     */
    public  function getAllWithPaginate( int $perPage = null)
    {
        $colums = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id'
        ];

        $result = $this->startConditions()
            ->select($colums)
            ->orderBy('id', 'DESC')
            ->with([
                'category:id,title',
                'user:id,name'
            ])
            ->paginate(25);


        return $result;

    }

    /**
     * Получите список категорий для вывода в выпадающем списке
     * @return Collection
     */
    public function getForComboBox()
    {
        //return $this->startConditions()->all();

        $colums = implode(', ',[
            'id',
            'CONCAT (id, ". ", title) AS id_title',
        ]);

        $result = $this
            ->startConditions()
            ->selectRaw($colums)
            ->toBase()
            ->get();


        return $result;

    }
}
