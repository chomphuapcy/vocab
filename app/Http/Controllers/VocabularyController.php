<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VocabularyController extends Controller
{
    public function home()
    {
        $vocab_data = Vocabulary::all();
        return view('vocab.index', compact('vocab_data'));
    }

    public function fetchWord($word)
    {
        if ($word == "all") {
            $data = Vocabulary::where([["user_id", "LIKE", Auth::user()->id]])->orderBy('id', 'DESC')->get();
        } else {
            $data = Vocabulary::where([["word", 'LIKE', '%' . $word . '%'], ["user_id", "=", Auth::user()->id]])->orderBy('id', 'DESC')->get();
        }
        return response()->json($data);
    }

    public function favorite()
    {
        return view('vocab.favorite');
    }

    public function fetchFav($word)
    {
        if ($word == "all") {
            $data = Vocabulary::where([["user_id", "LIKE", Auth::user()->id], ["favorite", '=', 1]])->orderBy('id', 'DESC')->get();
        } else {
            $data = Vocabulary::where([["word", 'LIKE', '%' . $word . '%'], ["user_id", "=", Auth::user()->id], ["favorite", '=', 1]])->orderBy('id', 'DESC')->get();
        }
        return response()->json($data);
    }

    public function changeFav($id, $status)
    {
        $change = Vocabulary::find($id);
        $change->favorite = $status;
        $change->save();
        return $change;
    }

    public function flash()
    {
        return view('vocab.flash');
    }

    public function manage()
    {
        return view('vocab.manage');
    }

    public function edit($id)
    {
        return Vocabulary::find($id)->get();
    }

    public function fetchJson($id)
    {
        $data = Vocabulary::where([["user_id", "=", Auth::user()->id], ["id", '=', $id]])->get();
        return response()->json($data);
    }

    public function saveEdit(Request $request)
    {
        $edit = Vocabulary::find($request->e_id);
        $edit->word = $request->e_word;
        $edit->mean = $request->e_meaning;
        $edit->type = $request->e_word_type;
        $edit->save();
        return response()->json($request);
    }

    public function delete($word)
    {
        $del = Vocabulary::where([["id", "=", $word], ["user_id", '=', Auth::user()->id]]);
        $del->delete();
        if ($del) {
            return 1;
        }
    }

    public function addWord(Request $request)
    {
        Vocabulary::create([
            'word' => $request->word,
            'mean' => $request->meaning,
            'type' => $request->word_type,
	    'favorite' => 0,
            'user_id' => Auth::user()->id
        ]);
    }
}
