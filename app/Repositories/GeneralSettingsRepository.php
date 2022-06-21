<?php


namespace App\Repositories;


use App\Models\GeneralSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GeneralSettingsRepository
{
    private $upload;

    public function __construct(UploadRepository $upload)
    {
        $this->upload = $upload;
    }

    /**
     * Display the list of settings
     */
    public function getSettings($request){
        $hotel_id = $request->query('hotel_id');
        return GeneralSetting::where('hotel_id', $hotel_id)->paginate();
    }
    /**
     * Add new setting
     * @param App\Http\Requests\GeneralSettingsRequest $request The setting's request
     */
    public function addSetting($request){
        return  GeneralSetting::create(
            $request->only( 'hotel_id','licence_days')
            + ['logo' => $this->upload->upload($request,$file='logo',$type='Hotel',$path='Hotels')]
        );
    }

    /**
     * Find setting by id
     * @param int $id The setting's id
     */
    public function getSetting($id){
        return  GeneralSetting::find($id);
    }

    /**
     * Update a specified setting
     * @param int $id The setting's id
     * @param App\Http\Requests\GeneralSettingsRequest $request The setting's request
     */
    public function updateSetting($request,$id){
        $setting = GeneralSetting::find($id);
        $filenametostore = $setting->logo;
        if ($request->hasFile('logo')) {
            /* if (File::exists(public_path('storage/'.$path))) {
                File::delete(public_path('storage/'.$path));
            }
            $path = $request->file('logo')->store('settings'); */
            Storage::disk('ftp')->delete($filenametostore);
            $filenamewithextension = $request->file('logo')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('logo')->getClientOriginalExtension();
            $filenametostore = 'settings/'. $filename.'_'.uniqid().'.'.$extension;
            Storage::disk('ftp')->put($filenametostore, fopen($request->file('logo'), 'r+'));
        }
        $setting->update($request->only('timer', 'tax')
            + ['logo' => $filenametostore]
        );
        return $setting;
    }

    /**
     * Delete setting
     * @param int $id The setting's id
     */
    public function deleteSetting($id){
        GeneralSetting::destroy($id);
    }
}
