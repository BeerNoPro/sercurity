<?php
namespace App\Repositories\Company;

use App\Models\Sercurity\Company;
use App\Repositories\EloquentRepository;

class CompanyRepository extends EloquentRepository
{
    public function getModel()
    {
        return Company::class; 
    }
}
