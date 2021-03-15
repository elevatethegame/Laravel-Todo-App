<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoList;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('home')->with('lists', $user->todo_lists);
    }

    /**
     * Store a newly created list in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        // Create List
        $list = new TodoList();
        $list->name = $request->input('name');
        $list->user_id = Auth::id();
        $list->save();

        return redirect('/home')->with('success', 'List Created');
    }

    /**
     * Display the specified list.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = TodoList::find($id);
        return view('lists.show')->with('list', $list);
    }

    /**
     * Remove the specified list from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list = TodoList::find($id);

        // Check for correct user
        if(Auth::id() !== $list->user_id) {
            return redirect("/home")->with('error', 'Unauthorized Page');
        }

        $list->delete();
        return redirect('/home')->with('success', 'List Removed');
    }

}
