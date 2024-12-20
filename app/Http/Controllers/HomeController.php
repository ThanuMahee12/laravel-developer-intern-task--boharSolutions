<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
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
        $tasks = Task::paginate(20); // Pagination for 20 tasks per page
        return view('tasks.index', compact('tasks'));
    }
}
