<?php


namespace App\Repositories;


use App\Models\Choice;

class ChoiceRepository
{
    /**
     * Display the list choices
     */
    public function getChoices(){
        return Choice::paginate();
    }

    /**
     * Add new choice
     * @param App\Http\Requests\ChoiceRequest $request The choice's request
     */
    public function addChoice($request){
        return  Choice::create($request);
    }

    /**
     * Find choice by id
     * @param int $id The choice's id
     */
    public function getChoice($id){
        return  Choice::find($id);
    }

    /**
     * update a specified choice
     * @param int $id The choice's id
     * @param Illuminate\Http\Response $request The choice's request
     */
    public function updateChoice($request,$id){
        $choice = Choice::find($id);
        $choice->update($request->all());
        return $choice;
    }

    /**
     * Delete choice
     * @param int $id The choice's id
     */
    public function deleteChoice($id){
        Choice::destroy($id);
    }
}
