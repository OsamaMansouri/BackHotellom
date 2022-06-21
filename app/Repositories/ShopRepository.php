<?php


namespace App\Repositories;


use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ShopRepository
{

    private $upload;

    public function __construct(UploadRepository $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Display the list of shops
     * @param Illuminate\Http\Request $request The shop's request
     */
    public function getShops($request){
        //$hotel_id = $request->query('hotel_id');
        $hotel_id = Auth::user()->hotel_id;
        if($request->query('web')){
            return Shop::with('type')->where('hotel_id', $hotel_id)->orderBy('id', 'desc')->get();
        } else {
            return Shop::with('type')->where('hotel_id', $hotel_id)->orderBy('id', 'desc')->paginate();
        }
    }

    /**
     * Add new shop
     * @param App\Http\Requests\ShopRequest $request The shop's request
     */
    public function addShop($request){
        //$pdf_path = $request->file('pdf_file')->store('shops');
        $filenamewithextension = $request->file('pdf_file')->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $extension = $request->file('pdf_file')->getClientOriginalExtension();
        $filenametostore = 'shops/'. $filename.'_'.uniqid().'.'.$extension;
        Storage::disk('ftp')->put($filenametostore, fopen($request->file('pdf_file'), 'r+'));
        $request['hotel_id'] = Auth::user()->hotel_id;
        return  Shop::create(
            $request->only('hotel_id', 'name', 'type_id', 'color', 'menu', 'startTime', 'endTime', 'description', 'sequence', 'size')
            + ['pdf_file' => $filenametostore]
        );
    }

    /**
     * Find shop by id
     * @param int $id The shop's id
     */
    public function getShop($id){
        return  Shop::findOrFail($id);
    }

    /**
     * update a specified shop
     * @param int $id The shop's id
     * @param Illuminate\Http\Response $request The shop's request
     */
    public function updateShop($request,$id){
        $shop = Shop::find($id);
        $pdf_path = $shop->pdf_file;
        if ($request->hasFile('pdf_file')) {
            /* if (File::exists(public_path('storage/'.$pdf_path))) {
                File::delete(public_path('storage/'.$pdf_path));
            }
            $pdf_path = $request->file('pdf_file')->store('shops'); */
            Storage::disk('ftp')->delete($pdf_path);
            $filenamewithextension = $request->file('pdf_file')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('pdf_file')->getClientOriginalExtension();
            $pdf_path = 'shops/'. $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put($pdf_path, fopen($request->file('pdf_file'), 'r+'));
        }
        $shop->update(
            $request->only('name', 'type_id', 'color', 'menu', 'startTime', 'endTime', 'description', 'sequence', 'size')
            + ['pdf_file' => $pdf_path]
        );
        return $shop;
    }

    /**
     * Delete shop
     * @param int $id The shop's id
     */
    public function deleteShop($id){
        $shop = Shop::find($id);
        $pdf_path = $shop->pdf_file;
        Storage::disk('ftp')->delete($pdf_path);
        /* if (File::exists(public_path('storage/'.$pdf_path))) {
            File::delete(public_path('storage/'.$pdf_path));
        } */
        return Shop::destroy($id);
    }
}
