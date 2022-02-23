<?php

namespace App\Http\Controllers\Sercurity\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowListController extends Controller
{
    // Function show all list content view
    public function showListProject()
    {
        $data = DB::table('company')
        ->join('project', 'company.id', '=', 'project.company_id')
        ->join('work_room', 'project.work_room_id', '=', 'work_room.id')
        ->join('member', 'member.id', '=', 'member.company_id')
        ->join('device', 'member.id', '=', 'device.member_id')
        ->join('carbinet', 'work_room.id', '=', 'carbinet.work_room_id')
        ->select('company.id as company_id', 'company.name as company', 'project.id as project_id', 'project.name as project', 'work_room.id as work_room_id', 'work_room.name as work_room', 'member.id as member_id', 'member.name as member', 'device.id as device_id', 'device.user_login', 'carbinet.id as carbinet_id', 'carbinet.name as carbinet')
        ->get();
        if ($data) {
            return response()->json([
                'status' => 200,
                'message' => 'Lists content data.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'List content not found.',
            ]);
        }
    }

    // Function show company detail
    public function companyDetail($id)
    {
        $data = DB::table('company')->where('id', $id)->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Company content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Company content not found.',
            ]);
        }
    }

    // Function show work room detail
    public function workRoomDetail($id)
    {
        $data = DB::table('work_room')->where('id', $id)->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Work room content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Work room content not found.',
            ]);
        }
    }

    // Function show member
    public function memberDetail($id)
    {
        $data = DB::table('member')
        ->join('company', 'company.id', '=', 'member.company_id')
        ->select('member.*', 'company.name as company_name')
        ->where('member.id', $id)
        ->get();
        if ($data->isNotEmpty()) {
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

    // Function show project
    public function projectDetail($id)
    {
        $data = DB::table('project')
        ->join('company', 'company.id', '=', 'project.company_id')
        ->join('work_room', 'work_room.id', '=', 'project.work_room_id')
        ->select('project.*', 'company.name as company_name', 'work_room.name as work_room_name')
        ->where('project.id', $id)
        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Project content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Project content not found.',
            ]);
        }
    }

    // Function show member project
    public function memberProjectDetail($member_id, $project_id)
    {
        $data = DB::table('member_project')
        ->join('project', 'project.id', '=', 'member_project.project_id')
        ->join('member', 'member.id', '=', 'member_project.member_id')
        ->select('member_project.*', 'member.name as member_name', 'project.name as project_name')
        ->where('member_project.member_id', $member_id)
        ->where('member_project.project_id', $project_id)
        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Member project content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Member project content not found.',
            ]);
        }
    }

    // Function show content training
    public function trainingDetail($id)
    {
        $data = DB::table('training')
        ->join('member', 'member.id', '=', 'training.trainer')
        ->join('project', 'project.id', '=', 'training.project_id')
        ->select('training.*', 'member.name as trainer_name', 'project.name as project_name')
        ->where('training.id', $id)
        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Training content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training content not found.',
            ]);
        }
    }

    // Function show content training room
    public function trainingRoomDetail($training_id, $member_id)
    {
        $data = DB::table('training_room')
        ->join('training', 'training.id', '=', 'training_room.training_id')
        ->join('member', 'member.id', '=', 'training_room.member_id')
        ->select('training_room.*', 'member.id as trained_person_id', 'member.name as trained_person', 'training.trainer as trainer_id')
        ->where('training_room.training_id', $training_id)
        ->where('training_room.member_id', $member_id);

        $data2 = DB::table('member')
        ->joinSub($data, 'training_room', function ($join) {
            $join->on('member.id', '=', 'training_room.trainer_id');
        })
        ->select('training_room.*', 'member.name as trainer_name')
        ->get();

        if ($data2->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Training room content detail.',
                'data' => $data2
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Training room content not found.',
            ]);
        }
    }

    // Function show content device
    public function deviceDetail($id)
    {
        $data = DB::table('device')
        ->join('member', 'member.id', '=', 'device.member_id')
        ->select('device.*', 'member.name as member_name')
        ->where('device.id', $id)
        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Device content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Device content not found.',
            ]);
        }
    }

    // Function show content carbinet
    public function carbinetDetail($id)
    {
        $data = DB::table('carbinet')
        ->join('work_room', 'work_room.id', '=', 'carbinet.work_room_id')
        ->join('member', 'member.id', '=', 'carbinet.member_id')
        ->select('carbinet.*', 'work_room.name as work_room_name', 'member.name as member_name')
        ->where('carbinet.id', $id)
        ->get();
        if ($data->isNotEmpty()) {
            return response()->json([
                'status' => 200,
                'message' => 'Carbinet content detail.',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Carbinet content not found.',
            ]);
        }
    }
}
