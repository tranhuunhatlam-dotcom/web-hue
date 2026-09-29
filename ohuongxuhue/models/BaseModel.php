<?php
/**
 * Lớp Model cơ sở (BaseModel)
 */

class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
}
