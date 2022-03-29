<?php
namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class BlogCategoryRepository
 * @package App\Repositories
 */
class BlogCategoryRepository extends CoreRepository
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
        $colums = ['id', 'title', 'parent_id'];

        $result = $this->startConditions()
            ->select($colums)
            ->with([
                'parentCategory:id,title'
            ])
            ->paginate($perPage);

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
