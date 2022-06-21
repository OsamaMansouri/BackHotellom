<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralSettingsRequest;
use App\Http\Resources\GeneralSettingsResource;
use App\Models\GeneralSetting;
use App\Repositories\GeneralSettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GeneralSettingsController extends Controller
{
    private $generalsettingsRepository;

    public function __construct(GeneralSettingsRepository $generalsettingsRepository)
    {
        $this->generalsettingsRepository = $generalsettingsRepository;
    }
    /**
     * @api {get} /settings List of settings
     * @apiName GeneralSettings_index
     * @apiGroup General Settings
     * @apiVersion 1.0.0
     *
     * @apiDescription  List all settings. It is possible to add some filters for more accuracy.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the general settings.
     * @apiSuccess  {String{..150}}              logo                           logo of the general settings.
     * @apiSuccess  {Integer}                    licence_days                   licence_days the general settings.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "logo": "logo_1619185986.jpeg",
     *        "licence_days": 30,
     *      }
     *  ]
     *}
     */
    public function index(Request $request)
    {
        $settings = $this->generalsettingsRepository->getSettings($request);
        return GeneralSettingsResource::collection($settings);
    }

    /**
     * @api {post} /settings New setting
     * @apiName New Setting
     * @apiGroup General Settings
     * @apiVersion 1.0.0
     *
     * @apiDescription  Add new settings.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the general settings.
     * @apiSuccess  {String{..150}}              logo                           logo of the general settings.
     * @apiSuccess  {Integer}                    licence_days                   licence_days the general settings.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "logo": "logo_1619185986.jpeg",
     *        "licence_days": 30,
     *      }
     *  ]
     *}
     */
    public function store(GeneralSettingsRequest $request)
    {
        $settings = $this->generalsettingsRepository->addSetting($request);
        return response(new GeneralSettingsResource($settings), Response::HTTP_CREATED);
    }

    /**
     * @api {get} /settings/1 Show a setting
     * @apiName Show a setting
     * @apiGroup General Settings
     * @apiVersion 1.0.0
     *
     * @apiDescription  Show a setting.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the general settings.
     * @apiSuccess  {String{..150}}              logo                           logo of the general settings.
     * @apiSuccess  {Integer}                    licence_days                   licence_days the general settings.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "logo": "logo_1619185986.jpeg",
     *        "licence_days": 30,
     *      }
     *  ]
     *}
     */
    public function show($id)
    {
        $setting = $this->generalsettingsRepository->getSetting($id);
        return new GeneralSettingsResource($setting);
    }

    public function getApiSettings()
    {
        $hotel_id = Auth::user()->hotel_id;
        $setting = GeneralSetting::where('hotel_id', $hotel_id)->first();
        return new GeneralSettingsResource($setting);
    }

    /**
     * @api {put} /settings/1 Update setting
     * @apiName Update Setting
     * @apiGroup General Settings
     * @apiVersion 1.0.0
     *
     * @apiDescription  Update setting.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the general settings.
     * @apiSuccess  {String{..150}}              logo                           logo of the general settings.
     * @apiSuccess  {Integer}                    licence_days                   licence_days the general settings.
     *
     * @apiSuccessExample {json} Success example
     *{
     *     "data": [
     *        {
     *        "id": 1,
     *        "hotel_id": "1",
     *        "logo": "logo_1619185986.jpeg",
     *        "licence_days": 30,
     *      }
     *  ]
     *}
     */
    public function update(Request $request, $id)
    {
        $setting = $this->generalsettingsRepository->updateSetting($request,$id);
        return response(new GeneralSettingsResource($setting), Response::HTTP_CREATED);
    }
    /**
     * @api {delete} /settings/1 Delete a setting
     * @apiName Delete a Setting
     * @apiGroup General Settings
     * @apiVersion 1.0.0
     *
     * @apiDescription  Delete a settings.
     *
     * @apiSuccess  {unsignedBigInteger}         hotel_id                       hotel_id of the general settings.
     * @apiSuccess  {String{..150}}              logo                           logo of the general settings.
     * @apiSuccess  {Integer}                    licence_days                   licence_days the general settings.
     *
     * @apiSuccessExample {json} Success example
     * 1
     *
     */
    public function destroy($id)
    {
        $this->generalsettingsRepository->deleteSetting($id);
        return  \response(null, Response::HTTP_NO_CONTENT);
    }
}
