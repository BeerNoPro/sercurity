<?php
namespace App\Repositories\Member;

use App\Models\Sercurity\Member;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;

class MemberRepository extends EloquentRepository
{
    public function getModel()
    {
        return Member::class;
    }

    public function getAll()
    {
        $data = Member::with('company')->paginate(6);
        return $data ? $data : false;
    }

    public function showForeignKey()
    {
        $data = DB::table('company')->select('company.id', 'company.name')->get();
        return $data ? $data : false;
    }

    public function edit($id, $company_id = false)
    {
        if ($company_id) {
            $data = Member::with('company')
            ->where('member.id', $id)
            ->where('member.company_id', $company_id)
            ->get();
            return $data ? $data : false;
        } else {
            $data = Member::with('company')
            ->where('member.id', $id)
            ->get();
            return $data ? $data : false;
        }
    }

    public function search($name)
    {
        $data = Member::with('company')
        ->where('member.name','like','%'.$name.'%')->get();
        return $data ? $data : false;
    }
}
