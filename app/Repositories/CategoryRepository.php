<?php


namespace App\Repositories;


use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryRepository
{
    private $upload;

    public function __construct(UploadRepository $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Display the list of categories
     */
    public function getCategories($request){
        $hotel_id = Auth::user()->hotel_id;
        if($request->query('web')){
            return Category::with('shop')->where('hotel_id', $hotel_id)->OrderBy('sequence','DESC')->get();
        } else {
            return Category::with('shop')->where('hotel_id', $hotel_id)->OrderBy('sequence','ASC')->paginate(50);
        }

    }

    /**
     * Add new category
     * @param App\Http\Requests\CategoryRequest $request The category's request
     */
    public function addCategory($request){
        /* $path = $request->file('icon')->store('categories'); */
        $image = $request['icon'];
        $imageName = Str::random('30').'.'.'png';
        $exploded = explode(',', $image);
        $base64 = $exploded[1];
        $data = base64_decode($base64);

        //Storage::disk('categories')->put($imageName, $data);
        $imageName = 'categories/'.Str::random('30').'_'.uniqid().'.png';
        Storage::disk('ftp')->put($imageName, $data);
        return  Category::create(
            $request->only('hotel_id', 'shop_id', 'name', 'startTime', 'endTime', 'Sequence')
            + ['icon' => $imageName]
        );
    }

    /**
     * Find category by id
     * @param int $id The category's id
     */
    public function getCategory($id){
        return  Category::find($id);
    }

    /**
     * update a specified category
     * @param int $id The category's id
     * @param Illuminate\Http\Response $request The category's request
     */
    public function updateCategory($request,$id){
        $category = Category::find($id);
        $filenametostore = $category->icon;
        if ($request->hasFile('icon')) {
            /* if (File::exists(public_path('storage/'.$path))) {
                File::delete(public_path('storage/'.$path));
            }
            $path = $request->file('icon')->store('categories'); */
            Storage::disk('ftp')->delete($filenametostore);
            $filenamewithextension = $request->file('icon')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('icon')->getClientOriginalExtension();
            $filenametostore = 'categories/'. $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put($filenametostore, fopen($request->file('icon'), 'r+'));
        }
        $category->update($request->only('name','shop_id','startTime','endTime','Sequence')
            + ['icon' => $filenametostore]
        );
        return $category;
    }

    /**
     * Delete category
     * @param int $id The category's id
     */
    public function deleteCategory($id){
        $category = Category::findOrFail($id);
        $path = $category->icon;
        Storage::disk('ftp')->delete($path);
        /* $path = $category->icon;
        if (File::exists(public_path('storage/'.$path))) {
            File::delete(public_path('storage/'.$path));
        } */
        return Category::destroy($id);
    }
}
