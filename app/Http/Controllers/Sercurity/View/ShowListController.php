<?php

namespace App\Http\Controllers\Sercurity\View;

use App\Http\Controllers\Controller;
use App\Models\Sercurity\Company;
use App\Models\Sercurity\Member;
use App\Models\Sercurity\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowListController extends Controller
{
    // Function show all list content view
    public function home(Request $request, $id = false)
    {
        if ($id) {
            $data = Project::with('company')
            ->with('member')
            ->with('workRoom')
            ->where('project.id', $id)
            ->get();
            if ($data->isNotEmpty()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Content data detail.',
                    'data' => $data,
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Content data detail not found.',
                ]);
            }
        } else {
            $data = Project::with('company')
            ->with('member')
            ->with('workRoom')
            ->paginate(2);
            $page = 1;
            if (isset($request->page)) {
                $page = $request->page;
            }
            $index = ($page - 1) * 2 + 1;
            if ($data) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Lists content data.',
                    'data' => $data,
                    'index' => $index,
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'List content not found.',
                ]);
            }
        }
    }

    // Function show content table company and work room
    public function companyAndWorkRoom($name, $id)
    {
        $data = DB::table($name)->where('id', $id)->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => $name . ' content detail.',
                'data' => $data,
                'table' => $name
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => $name . ' content not found.'
            ]);
        }
    }

    // Function show member
    public function member($id)
    {
        $data = Member::with('company')
        ->where('member.id', $id)
        ->get();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Member content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member content not found.',
            ]);
        }
    }

    public function search($name)
    {
        $data = Project::query()->with([
            'company' => function ($query) use ($name) {
                $query->where('company.name','like','%'.$name.'%');
            }
        ])->get();

        // Filter value == null
        function filterResult($data)
        {
            for ($i = 0; $i < sizeof($data); $i++) {
                if (is_null($data[$i]->company)) unset($data[$i]);
            }
            return array($data);
        }
        filterResult($data);

        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Data content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found.'
            ]);
        }
    }
}
