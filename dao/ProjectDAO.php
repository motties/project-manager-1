<?php

require_once 'framework/DAO.php';
require_once 'model/Project.php';

class ProjectDAO extends DAO {

    private static $select = 'SELECT * FROM `TM1_Project`';

    public function __construct() {
        parent::__construct('Project');
    }

    public function startList(): void {
        $sql = self::$select;
        $sql .= ' ORDER BY `TM1_Project`.`projectId`';
        $this->startListSql($sql);
    }

    public function get(?string $projectId) {
        if (empty($projectId)) {
            return new Project;
        } else {
            $sql = self::$select;
            $sql .= ' WHERE `TM1_Project`.`projectId` = ?';
            return $this->getObjectSql($sql, [$projectId]);
        }
    }

    public function delete(int $projectId) {
        $sql = 'DELETE FROM `TM1_Project` '
                . ' WHERE `projectId` = ?';
        $args = [
            $projectId
        ];
        $this->execute($sql, $args);
    }

    public function insert(Project $project) {
        $sql = 'INSERT INTO `TM1_Project` '
                . ' (title, description, owner)'
                . ' VALUES (?, ?, ?)';
        $args = [
            $project->getTitle(),
            $project->getDescription(),
            $project->getOwner(),
        ];
        $this->execute($sql, $args);
    }

    public function update(Project $project) {
        $sql = 'UPDATE `TM1_Project` '
                . ' SET title = ?, description = ?, owner = ? '
                . ' WHERE projectId = ?';
        $args = [
            $project->getTitle(),
            $project->getDescription(),
            $project->getOwner(),
            $project->getProjectId()
        ];
        $this->execute($sql, $args);
    }

    public function save(Project $project) {
        if (empty($project->getProjectId())) {
            $this->insert($project);
        } else {
            $this->update($project);
        }
    }

}
