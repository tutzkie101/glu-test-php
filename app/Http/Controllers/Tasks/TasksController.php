<?php


namespace App\Http\Controllers\Tasks;


use App\Http\Controllers\Controller;
use App\Jobs\StoreScore;
use App\Models\tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TasksController extends Controller
{
    public function __construct()
    {
        Log::info("Tasks Controller Called");
    }//end of constructor

    /*
     * Function stores the task to the database
     * function expects a json package from the request.
     * Format: [
                {
                    "submitters_id": int,
                    "priority": int,
                    "package": {
                        "task": string,
                        "data": object
                    }
                },...
            ]
     */
    public function store(Request $request)
    {
        //get the package from the request
        $package = $request->all();
        $results = [];

        //loop through the tasks in the package then save each on to the database
        foreach($package as $task) {
            $taskData = new tasks();
            $taskData->submitters_id = $task['submitters_id'];
            $taskData->priority = $task['priority'];
            $taskData->package = json_encode($task['package']);
            $taskData->status = "queued";
            $taskData->save();

            $results[] = $taskData;
        }//end of for each task

        //respond with the tasks stored in the database
        return response($results,201);
    }

    /*
     * Function responds with the tasks data based on the ID request
     * @var id -> id of the task
     */
    public function read(Request $request,$id)
    {
        $taskData = tasks::where('id','=',$id)->first();
        return response($taskData,200);
    }

    /*
     * Function responds with the list of tasks in the database
     */
    public function list(Request $request)
    {
        $taskData = tasks::get();
        return response($taskData,200);
    }

    /*
     * Function responds with the next highest priority task in the database
     */
    public function nextPriority(Request $request)
    {
        //ordered by priority then ordered by id, 1 is the highest priority value
        $taskData = tasks::where('processor_id','=',null)->orderByRaw("priority ASC, id ASC")->first();
        return response($taskData,200);
    }


}//end of class
