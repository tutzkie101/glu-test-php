<?php


namespace App\Http\Controllers\Processor;


use App\Http\Controllers\Controller;
use App\Models\processor;
use App\Models\tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProcessorController extends Controller
{
    public function __construct()
    {
        Log::info("Processor Controller Called");
    }//end of constructor

    /*
     * Function assigns a task to a process and tags a task with the processor processing it.
     * Process function expects an array package in json format:
     * [{"name":string},...]
     */
    public function process(Request $request)
    {
        //get the package from the request.
        //Format is:[{"name":string},...]
        $package = $request->all();
        $results = [];

        //loop through the array of processes in the package
        foreach($package as $proc) {

            //get time start on process
            $time_start = microtime(true);

            //get the next priority task
            //we lock the row to prevent accidentally selecting or updating the data during the transaction process
            //ordered by priority then ordered by id, 1 is the highest priority value
            $taskData = tasks::where('processor_id','=',null)->orderByRaw("priority ASC, id ASC")->lockForUpdate()->first();

            //if there are no tasks to process then break the loop to prevent adding processes without tasks
            if(is_null($taskData)) {
                break;
            }

            //initialize processor model
            //as we create the processor we assign a task id to it
            $procData = new processor();
            $procData->name = $proc['name'];
            $procData->task_id = $taskData->id;
            $procData->save();

            //after task data is assign to the processor, we then assign the processor to the task and update it
            //this secures the relationship between the two tables
            $taskData->processor_id = $procData->id;
            $taskData->status = "processed";
            $taskData->save();

            //get end time and save it to the process row
            $time_end  = microtime(true);

            //time in milliseconds is stored to the processor
            $procData->process_time = (($time_end-$time_start)*1000);
            $procData->save();

            //assign the processor data to results so we could send it back to the requester
            $results[] = $procData;
        }//end of for each loop

        //response back to the request with results
        return response($results,201);
    }

    /*
     * Function gets a processor from the database based on the given ID
     * @var id -> id of the processor to read
     */
    public function read(Request $request,$id)
    {
        $results = processor::where('id','=',$id)->first;
        return response($results,200);
    }

    /*
     * Function responds with the list of processors in the database
     */
    public function list(Request $request)
    {
        $results = processor::get();
        return response($results,200);
    }

    /*
     * Function returns the average process time for all the processors in the database
     */
    public function averageProcDuration(Request $request)
    {
        //request all the processor from the database
        $results = processor::get();
        $average = 0;

        //loop through each row and add the total process_time to the average
        foreach($results as $proc) {
            $average += $proc->process_time;
        }//end of for each

        //calculate the average
        $average = $average/count($results);

        return response("{\"average\":$average}",200);
    }

}//end of class
