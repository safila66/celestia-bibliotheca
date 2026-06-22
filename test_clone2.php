<?php
class Builder {
    public function where() { return clone $this; }
    public function orderBy() { return clone $this; }
    public function get() { return new Result(); }
}
class Result {
    public function getResultArray() { return []; }
}
$db = new stdClass();
$db->table = new Builder();

$lists = clone $db->table->where()->orderBy()->get()->getResultArray();
echo "SUCCESS";
