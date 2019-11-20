<?php
namespace App\Factories;

use App\Strategies\CommandStrategies\SaveFileInDataBaseStrategy;
use App\Strategies\CommandStrategies\HardDeleteFileStrategy;
use App\Strategies\CommandStrategies\SoftDeleteFileStrategy;
use App\Strategies\CommandStrategies\RestoreFileStrategy;
use App\Strategies\CommandStrategies\DeleteVersionStrategy;
use App\Strategies\QueryStrategies\GetAllVersionsStrategy;
use App\Strategies\QueryStrategies\GetVersionStrategy;
use App\Strategies\QueryStrategies\GetLatestVersionStrategy;

class DatabaseCommandFactory
{
    public $strategy;

    public function getInstance($strategy) {
        
        switch ($strategy) {
            case DatabaseOperationConstants::SAVE_FILE_IN_DATABASE_STRATEGY:
                $this->strategy = new SaveFileInDataBaseStrategy();
            break;

            case DatabaseOperationConstants::GET_ALL_VERSIONS_STRATEGY:
                $this->strategy = new GetAllVersionsStrategy();
            break;

            case DatabaseOperationConstants::GET_VERSION_STRATEGY:
                $this->strategy = new GetVersionStrategy();
            break;

            case DatabaseOperationConstants::GET_LATEST_VERSION_STRATEGY:
                $this->strategy = new GetLatestVersionStrategy();
            break;

            case DatabaseOperationConstants::HARD_DELETE_FILE_STRATEGY:
                $this->strategy = new HardDeleteFileStrategy();
            break;

            case DatabaseOperationConstants::SOFT_DELETE_FILE_STRATEGY:
                $this->strategy = new SoftDeleteFileStrategy();
            break;

            case DatabaseOperationConstants::RESTORE_FILE_STRATEGY:
                $this->strategy = new RestoreFileStrategy();
            break;

            case DatabaseOperationConstants::DELETE_VERSION_STRATEGY:
                $this->strategy = new DeleteVersionStrategy();
            break;
           
        }


    }
}