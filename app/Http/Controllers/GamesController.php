<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Auth;
use Illuminate\Http\Request;



class GamesController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Game::where('user_id', Auth::user()->id);

        if ($request->has('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        $sortDirection = $request->input('sort', 'desc');
        $query->orderBy('release_date', $sortDirection);

        $games = $query->get();

        return GameResource::collection($games);
    }


    public function allGames(Request $request)
    {
        $allGamesQuery = Game::query();

        
        if ($request->has('genre')) {
            $allGamesQuery->where('genre', $request->input('genre'));
        }

        
        $sortDirection = $request->input('sort', 'desc');
        $allGamesQuery->orderBy('release_date', $sortDirection);

        $allGames = $allGamesQuery->get();

        return GameResource::collection($allGames);
    }



    
    public function store(StoreGameRequest $request)
    {
        $request->validated($request->all());

        $game = Game::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'genre' => $request->genre,
            'description' => $request->description,
            'release_date' => $request->release_date
        ]);

        return new GameResource($game);
    }





    public function update(StoreGameRequest $request, $id)
    {

        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        if (Auth::user()->id !== $game->user_id) {
            return response()->json(['error' => 'You are not authorized'], 403);
        }

        $validatedData = $request->validated();

        $game->fill($validatedData);

        $game->save();

        return new GameResource($game);
    }

   


    
    public function destroy($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        if (Auth::user()->id !== $game->user_id) {
            return response()->json(['error' => 'You are not authorized'], 403);
        }
        

        $game->delete();

        return response()->json(['message' => 'Game deleted successfully'], 200);
    }




    public function admin_destroy($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Game not found'], 404);
        }

        if (Auth::user()->usertype !== 'admin') {
            return response()->json(['error' => 'You are not authorized, you are not admin'], 403);
        }
        

        $game->delete();

        return response()->json(['message' => 'Game deleted successfully'], 200);
    }

}
