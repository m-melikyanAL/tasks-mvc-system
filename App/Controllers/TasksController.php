<?php


class TasksController extends Controller
{
    private $task;

    public function __construct()
    {
        $this->task = new Tasks();
    }

    /**
     * To work at first time
     * @return  view
     */
    public function index(): View
    {
        $data['tasks'] = $this->task->getAllTasks();
        return $this->view('tasks/index', $data);
    }

    /**
     * Get all tasks
     * @return  array
     */
    public function all()
    {
        $data['tasks'] = $this->task->getAllTasks();
        $this->prepareResponse($data);
    }

    /**
     * Get single task
     * @param int $id
     * @return  object
     */
    public function get(int $id)
    {
        $data = $this->task->getTask($id);
        $this->prepareResponse($data);
    }

    /**
     * Store task
     * @return  array
     */
    public function store()
    {
        $postData = $this->preparePostData();

        if ($this->task->insertTask(["name" => $postData['name']])) {
            $data['success'] = "Data Added Successfully";
        } else {
            $data['error'] = "Data Insertion Failed";
        }
        $this->prepareResponse($data);
    }


    /**
     * Completed / uncompleted task
     * @return  array
     */
    public function complete()
    {
        $postData = $this->preparePostData();
        $dataInsert = ["complete" => $postData['complete']];

        if ($this->task->completeTask($postData['id'], $dataInsert)) {
            $data['success'] = "Data Updated Successfully";
        } else {
            $data['error'] = "Error";
        }
        $this->prepareResponse($data);
    }


    /**
     * Delete task
     * @param int $id
     * @return  array
     */
    public function delete(int $id)
    {
        if ($this->task->deleteTask($id)) {
            $data['success'] = "Task Have Been Deleted";
        } else {
            $data['error'] = "Error";
        }
        $this->prepareResponse($data);
    }

}