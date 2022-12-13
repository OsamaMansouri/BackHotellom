<?php


namespace App\Repositories;


use App\Models\Article;
use App\Models\Choice;
use App\Models\Option;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleRepository
{
    private $upload;

    private $optionRepository;

    private $choiceRepository;


    public function __construct(UploadRepository $upload,OptionRepository $optionRepository,ChoiceRepository $choiceRepository)
    {
        $this->upload = $upload;
        $this->optionRepository   = $optionRepository;
        $this->choiceRepository   = $choiceRepository;
    }

    /**
     * Display the list articles
     * @param Illuminate\Http\Request $request The article's request
     */
    public function getArticles($request){
        //$hotel_id = $request->query('hotel_id');
        $hotel_id = Auth::user()->hotel_id;
        $articles = Article::with('category')->whereHas('category', function($q) use($hotel_id) {
            $q->where('hotel_id', $hotel_id);
        });
        if($request->query('web')){
            return $articles->get();
        } else {
            return $articles->paginate(15);
        }
    }


    /**
     * Display the list articles by category id
     * @param int $category_id The category id
     */
    public function getArticlesByCategory($category_id){
        return Article::where('category_id', $category_id)->get();
    }


    /**
         * Add new article
     * @param App\Http\Requests\ArticleRequest $request The article's request
     */
    public function addArticle($request){
        /* $path = $request->file('image')->store('articles'); */
        $image = $request['image'];
        $imageName = Str::random('30').'.'.'png';
        $exploded = explode(',', $image);
        $base64 = $exploded[1];
        $data = base64_decode($base64);

        //Storage::disk('articles')->put($imageName, $data);
        $imageName = 'articles/'.Str::random('30').'_'.uniqid().'.png';
        Storage::disk('ftp')->put($imageName, $data);

        $profit = floatval($request->price) - floatval($request->cost);
        return  Article::create(
            $request->only('category_id','name','description','price','max_options','cost')
           + ['image' => $imageName, 'profit' => $profit]
        );
    }

    /**
     * Find article by id
     * @param int $id The article's id
     */
    public function getArticle($id){
        return  Article::find($id);
    }

    /**
     * update a specified article
     * @param Illuminate\Http\Response $request The article's request
     * @param int $id The article's id
     */
    public function updateArticle($request, $id) {
        $article = Article::find($id);
        $filenametostore = $article->image;

        if ($request->hasFile('image')) {
            /* if (File::exists(public_path('storage/'.$path))) {
                File::delete(public_path('storage/'.$path));
            }
            $path = $request->file('image')->store('articles'); */
            Storage::disk('ftp')->delete($filenametostore);
            $filenamewithextension = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $filenametostore = 'articles/'. $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put($filenametostore, fopen($request->file('image'), 'r+'));
        }
        $profit = floatval($request->price) - floatval($request->cost);
        $article->update(
            $request->only('category_id','name','description','price','max_options','cost')
            + ['image' => $filenametostore, 'profit' => $profit]
        );

        if ($article && $request->input('options')) {
            foreach ($request->input('options') as $max_option) {
                $optionData = [
                    'name' => $max_option['name'],
                    'max_choice' => $max_option['max_choice']
                ];
                $option = Option::with('choices')->find($max_option['id']);

                if ($option) {
                    $option->update($optionData);
                } else {
                    $optionData['article_id'] = $article->id;
                    $optionRepo = App::make(OptionRepository::class);
                    $option = $optionRepo->addOption($optionData);
                }

                if ($option && isset($max_option['choices'])) {
                    foreach ($max_option['choices'] as $max_choice) {
                        $choiceData = [
                            'option_id' => $max_option['id'],
                            'name' => $max_choice['name']
                        ];
                        //$this->choiceRepository->updateChoice($optionData,$max_choice['id']);
                        $choice= Choice::find($max_choice['id']);
                        if($choice) {
                            $choiceData['id'] = $max_choice['id'];
                            $choice->update($choiceData);
                        } else {
                            Choice::create($choiceData);
                        }
                    }

                } else {
                    // exception
                }
            }
        }
        else{
            //exception
        }

        return $article;
    }

    /**
     * Delete article
     * @param int $id The article's id
     */
    public function deleteArticle($id){
        $article = Article::findOrFail($id);
        /* $path = $article->image;
        if (File::exists(public_path('storage/'.$path))) {
            File::delete(public_path('storage/'.$path));
        } */
        $path = $article->image;
        Storage::disk('ftp')->delete($path);
        Article::destroy($id);
    }
}
