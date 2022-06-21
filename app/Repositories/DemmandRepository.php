<?php


namespace App\Repositories;

use App\Models\Demmand;
use App\Models\DemmandOption;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class DemmandRepository
{

    public function __construct()
    {

    }

    /**
     * Display the list of categories
     */
    public function getDemmands(){
        //$hotel_id = Auth::user()->hotel_id;
        //$client_id = Auth::user()->id;
        //return Demmand::where('hotel_id', $hotel_id)->where('client_id', $client_id)->OrderBy('id','DESC')->get();
        return Demmand::OrderBy('sequence')->get();
    }

    /**
     * Add new Demmand
     * @param App\Http\Requests\CategoryRequest $request The category's request
     */
    public function addDemmand($request){
        //$request['hotel_id'] = Auth::user()->hotel_id;
        $filenamewithextensiong = $request->file('icon')->getClientOriginalName();
        $filenameg = pathinfo($filenamewithextensiong, PATHINFO_FILENAME);
        $extensiong = $request->file('icon')->getClientOriginalExtension();
        $icon_path = 'demmands/'. $filenameg.'_'.uniqid().'.'.$extensiong;
        Storage::disk('ftp')->put($icon_path, fopen($request->file('icon'), 'r+'));
        $isEmpthy = 0;
        if(isset($request['isEmpthy']) && $request['isEmpthy'] === 'true'){
            $isEmpthy = 1;
        }
        $demmand = Demmand::create(
            $request->only('name', 'sequence')
            + ['isEmpthy' => $isEmpthy, 'icon' => $icon_path]
        );
        if ($demmand && isset($request['options'])) {
            foreach ($request['options'] as $option) {
                $optionData = [
                    'demmand_id' => $demmand->id,
                    'name' => $option['name']
                ];
                $option = DemmandOption::create($optionData);
            }
        }
        return $demmand;
    }

    /**
     * Find category by id
     * @param int $id The category's id
     */
    public function getDemmand($id){
        return  Demmand::find($id);
    }

    /**
     * update a specified demmand
     * @param int $id The demmand's id
     * @param Illuminate\Http\Response $request The demmand's request
     */
    public function updateDemmand($request,$id){
        $demmand = Demmand::findOrFail($id);
        $icon_path = $demmand->icon;
        if ($request->hasFile('icon')) {
            Storage::disk('ftp')->delete($icon_path);
            $filenamewithextensiong = $request->file('icon')->getClientOriginalName();
            $filenameg = pathinfo($filenamewithextensiong, PATHINFO_FILENAME);
            $extensiong = $request->file('icon')->getClientOriginalExtension();
            $icon_path = 'types/'. $filenameg.'_'.uniqid().'.'.$extensiong;
            Storage::disk('ftp')->put($icon_path, fopen($request->file('icon'), 'r+'));
        }
        $isEmpthy = 0;
        if(isset($request['isEmpthy']) && $request['isEmpthy'] === 'true'){
            $isEmpthy = 1;
        }
        $demmand->update($request->only('name', 'sequence')
        + ['isEmpthy' => $isEmpthy,  'icon' => $icon_path]);

        if ($demmand && $request->input('options')) {
            foreach ($request->input('options') as $option) {
                DemmandOption::destroy($option['id']);
                $optionData = [
                    'name' => $option['name']
                ];
                $optionData['demmand_id'] = $demmand->id;
                $option = DemmandOption::create($optionData);
            }
        }
        return $demmand;
    }

    /**
     * Delete demmand
     * @param int $id The demmand's id
     */
    public function deleteDemmand($id){
        /* $demmand = Demmand::find($id);
        $icon = $demmand->icon;
        Storage::disk('ftp')->delete($icon);
        return Demmand::destroy($id); */
        return 1;
    }
}
