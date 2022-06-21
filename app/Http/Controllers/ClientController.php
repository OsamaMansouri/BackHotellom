<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        Client::create(
            $request->only('fullName', 'email', 'phone', 'demmands', 'etablissement', 'poste', 'datePre', 'type', 'profile', 'vendeur', 'commentaire', 'ville', 'priorite', 'nbrChambre')
        );
        return redirect()->back()->with('status','Votre demande à été ajouté avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client, $id)
    {
        $client = Client::find($id);
        $client->update(
            $request->only('fullName', 'email', 'phone', 'demmands', 'etablissement', 'poste', 'datePre', 'type', 'profile', 'vendeur', 'commentaire', 'ville', 'priorite', 'nbrChambre')
        );
        $clients = Client::where('type', 'hotellom')->orderBy('id', 'DESC')->get();
        return view("listHotellom", compact('clients'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
