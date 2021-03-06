<?php

namespace App\Http\Controllers\Blog\Admin;



use App\Http\Requests\BlogPostCreateRequest;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Jobs\BlogPostAfterCreateJob;
use App\Jobs\BlogPostAfterDeleteJob;
use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use Illuminate\Http\Response;

class PostController extends BaseController
{

    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepositoty;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepositoty = app(BlogCategoryRepository::class);
    }
    /**
     * Управление статьями блога
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();
        return view('blog.admin.post.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $item = new BlogPost();
        $categoryList = $this->blogCategoryRepositoty->getForComboBox();

        return view('blog.admin.post.edit',compact('item','categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param   BlogPostCreateRequest $request
     * @return Response
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();

        $item = BlogPost::create($data);



        if ($item) {
            $job = new BlogPostAfterCreateJob($item);
            $this->dispatch($job);

            return redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => "ошибка сохранения"])
                ->withInput();
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            abort(404);
        }
        $categoryList = $this->blogCategoryRepositoty->getForComboBox();

        return view('blog.admin.post.edit', compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogPostUpdateRequest $request
     * @param  int  $id
     * @return Response
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{ $id } не найдена"])
                ->withInput();
        }

        $data = $request->all();


        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else {
            return back()
                ->withErrors(['msg' => "ошибка сохранения"])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //Софт удаления, в бд данные остаются, но deleted_at будет равно 1, а не NULL
        $result = BlogPost::destroy($id);
        //
        //       //Полное удалиние из бд
//       $result = BlogPost::find($id)->forceDelete();

       if ($result) {

           BlogPostAfterDeleteJob::dispatch($id);
           return redirect()
           ->route('blog.admin.posts.index')
           ->with(['success' => 'Запись удалена']);
       } else {
           return back()->withErrors(['msg' => 'Ошибка удаления']);
       }
    }
}
