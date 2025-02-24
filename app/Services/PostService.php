<?php

namespace App\Services;

use App\Models\Post;
use App\Services\ModelManagementService;

class PostService extends ModelManagementService
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }
}
