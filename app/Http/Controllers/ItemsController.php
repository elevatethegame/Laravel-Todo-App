<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TodoList;
use App\Models\ListItem;

class ItemsController extends Controller
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
     * Show all of the todo items associated with a particular list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($list_id)
    {
        $list = TodoList::find($list_id);

        // Only allow user to view lists that belongs to him
        if(Auth::id() !== $list->user_id) {
            return redirect("/home")->with('error', 'Unauthorized Page');
        }

        $items = ListItem::where('todo_list_id', $list_id)->where('is_completed', false)->orderBy('created_at', 'desc')->get();

        $data = [
            'list'  => $list,
            'items'   => $items
        ];
        
        return view('items.index')->with($data);
    }

    /**
     * Store a newly created item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $list_id)
    {
        $validated = $request->validate([
            'description' => 'required',
        ]);

        // Create Todo Item
        $item = new ListItem();
        $item->description = $request->input('description');
        $item->todo_list_id = $list_id;
        $item->save();

        return redirect('/list/'.$list_id.'/items')->with('success', 'Todo Added');
    }

    /**
     * Mark the specified Todo item as completed in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markCompleted($list_id, $item_id)
    {
        $list = TodoList::find($list_id);
        $item = ListItem::find($item_id);

        // Check for correct user
        if(Auth::id() !== $list->user_id) {
            return redirect("/home")->with('error', 'Unauthorized Page');
        }

        $item->is_completed = true;

        $item->save();

        return redirect('/list/'.$list_id.'/items')->with('success', 'Todo Marked as Completed');
    }

}
