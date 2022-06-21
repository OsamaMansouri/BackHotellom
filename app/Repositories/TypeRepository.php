<?php


namespace App\Repositories;


use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TypeRepository
{
    private $upload;

    public function __construct(UploadRepository $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Display the list of types
     */
    public function getTypes($request){
        //$hotel_id = $request->query('hotel_id', 1);
        //$hotel_id = Auth::user()->hotel_id;
        if($request->query('web')){
            //return Type::where('hotel_id', $hotel_id)->orderBy('id', 'desc')->get();
            return Type::orderBy('id', 'desc')->get();
        } else {
            return Type::orderBy('id', 'desc')->paginate();
        }
    }

    /**
     * Add new type
     * @param App\Http\Requests\TypeRequest $request The type's request
     */
    public function addType($request){
        //$gold_path = $request->file('gold_img')->store('types');
        //$purple_path = $request->file('purple_img')->store('types');

        //get filename with extension
        $filenamewithextensiong = $request->file('gold_img')->getClientOriginalName();
        $filenamewithextensionp = $request->file('purple_img')->getClientOriginalName();
        //get filename without extension
        $filenameg = pathinfo($filenamewithextensiong, PATHINFO_FILENAME);
        $filenamep = pathinfo($filenamewithextensionp, PATHINFO_FILENAME);
        //get file extension
        $extensiong = $request->file('gold_img')->getClientOriginalExtension();
        $extensionp = $request->file('purple_img')->getClientOriginalExtension();
        //filename to store
        $gold_path = 'types/'. $filenameg.'_'.uniqid().'.'.$extensiong;
        $purple_path = 'types/'. $filenamep.'_'.uniqid().'.'.$extensionp;
        //Upload File to external server
        Storage::disk('ftp')->put($gold_path, fopen($request->file('gold_img'), 'r+'));
        Storage::disk('ftp')->put($purple_path, fopen($request->file('purple_img'), 'r+'));
        return  Type::create(
            $request->only('name')
            + ['gold_img' => $gold_path]
            + ['purple_img' => $purple_path ]
        );
    }

    /**
     * Find type by id
     * @param int $id The type's id
     */
    public function getType($id){
        return  Type::findOrFail($id);
    }

    /**
     * update a specified type
     * @param int $id The type's id
     * @param Illuminate\Http\Response $request The type's request
     */
    public function updateType($request,$id){
        $type = Type::find($id);
        $gold_path = $type->gold_img;
        $purple_path = $type->purple_img;
        if ($request->hasFile('gold_img')) {
            /* if (File::exists(public_path('storage/'.$gold_path))) {
                File::delete(public_path('storage/'.$gold_path));
            }
            $gold_path = $request->file('gold_img')->store('types'); */
            Storage::disk('ftp')->delete($gold_path);
            $filenamewithextensiong = $request->file('gold_img')->getClientOriginalName();
            $filenameg = pathinfo($filenamewithextensiong, PATHINFO_FILENAME);
            $extensiong = $request->file('gold_img')->getClientOriginalExtension();
            $gold_path = 'types/'. $filenameg.'_'.uniqid().'.'.$extensiong;
            Storage::disk('ftp')->put($gold_path, fopen($request->file('gold_img'), 'r+'));
        }
        if ($request->hasFile('purple_img')) {
            /* if (File::exists(public_path('storage/'.$purple_path))) {
                File::delete(public_path('storage/'.$purple_path));
            }
            $purple_path = $request->file('purple_img')->store('types'); */
            Storage::disk('ftp')->delete($purple_path);
            $filenamewithextensionp = $request->file('purple_img')->getClientOriginalName();
            $filenamep = pathinfo($filenamewithextensionp, PATHINFO_FILENAME);
            $extensionp = $request->file('purple_img')->getClientOriginalExtension();
            $purple_path = 'types/'. $filenamep.'_'.uniqid().'.'.$extensionp;
            Storage::disk('ftp')->put($purple_path, fopen($request->file('purple_img'), 'r+'));
        }
        $type->update($request->only('name')
            + ['gold_img' => $gold_path]
            + ['purple_img' => $purple_path ]
        );
        return $type;
    }

    /**
     * Delete type
     * @param int $id The type's id
     */
    public function deleteType($id){
        $type = Type::find($id);
        $gold_path = $type->gold_img;
        $purple_path = $type->purple_img;
        Storage::disk('ftp')->delete($purple_path);
        Storage::disk('ftp')->delete($gold_path);
        /* if (File::exists(public_path('storage/'.$gold_path))) {
            File::delete(public_path('storage/'.$gold_path));
        }
        if (File::exists(public_path('storage/'.$purple_path))) {
            File::delete(public_path('storage/'.$purple_path));
        } */
        return Type::destroy($id);
    }
}
