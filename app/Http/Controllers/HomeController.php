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
        $lists = TodoList::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('home')->with('lists', $lists);
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

        return redirect('/home')->with('success', 'Todo List Created');
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
        return redirect('/home')->with('success', 'Todo List "'.$list->name.'"'.' Removed');
    }

}
