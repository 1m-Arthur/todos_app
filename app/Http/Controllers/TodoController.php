<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use App\TodoDetail;
use Carbon\Carbon;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'data' => $todos]);
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
        $this->validate($request, [
            'name' => 'required|max:100',
            'due_date' => 'required|date'
        ]);
        $due_date = Carbon::parse($request->due_date)->format('Y-m-d');
        Todo::create([
            'name' => $request->name,
            'note' => $request->note,
            'due_date' => $due_date,
            'status' => false
        ]);
        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::with(['details' => function ($q) {
            $q->orderBy('status', 'ASC');
        }])->find($id);
        return response()->json(['status' => 'success', 'data' => $todo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        $todo->update(['status' => true]);
        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();
        return response()->json(['status' => 'success']);
    }

    public function storeDetail(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
        ]);
        $todo = TodoDetail::create([
            'todo_id' => $request->id,
            'name'  => $request->name,
            'status'  => false
        ]);
        return response()->json(['status' => 'success']);
    }

    public function updateDetail($id)
    {
        $detail = TodoDetail::find($id);
        $detail->update(['status' => true]);
        return \response()->json(['status' => 'success']);
    }
}
