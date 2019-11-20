<?php


namespace App\Factories;

class DatabaseOperationConstants
{
    public const SAVE_FILE_IN_DATABASE_STRATEGY = 1;
    public const GET_ALL_VERSIONS_STRATEGY = 2;
    public const GET_VERSION_STRATEGY = 3;
    public const GET_LATEST_VERSION_STRATEGY = 4;
    public const HARD_DELETE_FILE_STRATEGY = 5;
    public const SOFT_DELETE_FILE_STRATEGY = 6;
    public const RESTORE_FILE_STRATEGY = 7;
    public const DELETE_VERSION_STRATEGY = 8;
}