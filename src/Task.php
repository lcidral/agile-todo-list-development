<?php
/**
 * Created by PhpStorm.
 * User: lcidral
 * Date: 08/04/18
 * Time: 11:34
 */

namespace Recruiting\Test;


class Task
{
    protected $db;
    protected $error;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $result = $this->db->table('tasks')->orderBy('sort_order', 'asc')->get();

        if (count($result) == 0) {
            $this->error['message'] = 'Wow. You have nothing else to do. Enjoy the rest of your day!';
            return $this->error;
        }

        return $result;
    }

    public function getTask($uuid)
    {
        $result = $this->db->table('tasks')->where('uuid', $uuid)->first();

        if (is_null($result)) {
            $result['message'] = 'Wow. You have nothing else to do. Enjoy the rest of your day!';
        }

        return $result;
    }

    public function save($data)
    {
        $result = [];

        if (!$this->isValid($data)) {
            return $this->error;
        }

        $data['uuid'] = \Ramsey\Uuid\Uuid::uuid1();
        $data['date_created'] = date('Y-m-d H:i:s');

        unset($data['sort_order']);

        $maxSortOrder = $this->db->table('tasks')->max('sort_order');

        if ($maxSortOrder == 0) {
            $data['sort_order'] = 1;
        } else {
            $data['sort_order'] = $maxSortOrder + 1;
        }

        $insert = $this->db->table('tasks')->insert($data);
        $result['success'] = $insert;

        return $result;
    }

    private function isValid($data)
    {
        if (empty($data['content'])) {
            $this->error['message'] = 'Bad move! Try removing the task instead of deleting its content.';
            return false;
        }

        $allowdTaskTypes = [
            'shopping',
            'work'
        ];

        if ( !in_array($data['type'], $allowdTaskTypes)) {
            $this->error['message'] = 'The task type you provided is not supported. You can only use shopping or work.';
            return false;
        }

        return (empty($this->error));
    }

    public function delete($uuid)
    {
        $message = 'Good news! The task you were trying to delete didn\'t even exist.';
        $delete = $this->db->table('tasks')->where('uuid', $uuid)->delete();

        if (!$delete) {
            $result['message'] = $message;
            return $result;
        }

        return [
            'success' => (bool) $delete
        ];
    }

    public function update($uuid, $data)
    {
        if (!$this->exists($uuid) || !$this->isValid($data)) {
            return $this->error;
        }

        unset($data['_METHOD']);
        unset($data['sort_order']);

        $update = $this->db->table('tasks')->where('uuid', $uuid)->update($data);

        $result['success'] = (bool) $update;

        return $result;
    }

    public function reorder($uuid, $sort_order)
    {
        if ($this->exists($uuid)) {

        }

        $tasksToReorder = $this->db->table('tasks')->orderBy('sort_order','ASC')->get();
        $newOrder = $sort_order + 1;
        foreach ($tasksToReorder as $newTaskOrder) {

            if ($uuid == $newTaskOrder->uuid) {
                continue;
            }

            $this->db->table('tasks')->where('uuid', $newTaskOrder->uuid)
                ->update(['sort_order' => $newOrder]);

            $newOrder++;
        }

        $update = $this->db->table('tasks')->where('uuid', $uuid)
            ->update([
                'sort_order' => $sort_order
            ]);

        return [
            'success' => (bool) $update
        ];
    }

    private function exists($uuid = null, $customMessage = null)
    {
        $resource = $this->db->table('tasks')->where('uuid', $uuid)->count();

        if ($resource == 0) {
            $message = 'Are you a hacker or something? The task you were trying to edit doesn\'t exist.';
            if (!is_null($customMessage)) {
                $message = $customMessage;
            }
            $this->error['message'] = $message;
        }

        return ($resource == 1);
    }
}