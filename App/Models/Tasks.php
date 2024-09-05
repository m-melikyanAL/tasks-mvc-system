<?php 

class Tasks
{
    private $db;
    private $table = "tasks";

    public function __construct()
    {
        $this->db = new DB();
    }

    /**
     * @throws Exception
     */
    public function getAllTasks()
    {
        
        return $this->db->connect()->get($this->table);
    }


    /**
     * insert new task in db
     * @param array $data => fileds and values of tasks row
     * @throws Exception
     */
    public function insertTask(array $data): bool
    {
        return $this->db->connect()->insert($this->table,$data);
    }


    /**
     * delete product from db 
     * @param int $id => id of product 
     */
    public function deleteTask(int $id): bool
    {
        $delete = $this->db->connect()->where('id',$id);
        return $delete->delete($this->table);
    }


    /**
     * get data of product from database
     * @param int $id 
     * @return array
     */

    public function getTask(int $id): array
    {
        $task = $this->db->connect()->where('id', $id);
        return $task->get($this->table);
    }

    public function completeTask($id, $data): bool
    {
        $task = $this->db->connect()->where('id', $id);
        return $task->update($this->table,$data);
    }


}