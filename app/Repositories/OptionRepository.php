<?php


namespace App\Repositories;


use App\Models\Option;

class OptionRepository
{
    /**
     * Display the list options
     */
    public function getOptions(){
        return Option::with('choices')->paginate();
    }

    /**
     * Add new option
     * @param App\Http\Requests\OptionRequest $request The option's request
     */
    public function addOption($request){
        return  Option::create($request);
    }

    /**
     * Find option by id
     * @param int $id The option's id
     */
    public function getOption($id){
        return  Option::find($id);
    }

    /**
     * update a specified option
     * @param int $id The option's id
     * @param Illuminate\Http\Response $request The option's request
     */
    public function updateOption($request,$id){
        $option = Option::find($id);
        $option->update($request->all());
        return $option;
    }

    /**
     * Delete option
     * @param int $id The option's id
     */
    public function deleteOption($id){
        Option::destroy($id);
    }
}
