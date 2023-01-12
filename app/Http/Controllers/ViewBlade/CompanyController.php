<?php

namespace App\Http\Controllers\ViewBlade;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecurityRequest\CompanyRequest;
use App\Repositories\Company\CompanyRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Throwable;

class CompanyController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index()
    {
        $data = $this->companyRepository->getAll();
        return view('Company.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view('Company.add');
    }

    public function store(CompanyRequest $request)
    {
        $this->companyRepository->create($request->all());
        return redirect()->route('company.home');
    }

    public function show($id)
    {
        $data = $this->companyRepository->find($id);
        return view('Company.edit', [
            'data' => $data
        ]);
    }

    public function update(CompanyRequest $request, $id)
    {
        $data = $request->all();
        $result = $this->companyRepository->update($id, $data);
        if ($result) {
            return redirect()->route('company.home');
        }
        return redirect()->route('company.add');
    }

    public function destroy($id)
    {
        // $data = $this->companyRepository->destroy($id);
        // if ($data) {
        //     return redirect()->route('company.home');
        // }
        // // return redirect()->route('company.home')->with('error', 'Delet failed!);

        try {
            $this->companyRepository->destroy($id);
            Session::flash('success', 'Company is created successfully');
            return redirect()->route('company.home');
        } catch (Exception $exception) {
            // return back()->withError($exception->getMessage())->withInput();
            DB::rollback();
            Session::flash('error', 'Company delete failed! Please try again');
            return redirect()->route('company.home');
        }
    }

    public function search(Request $request)
    {
        $data = $this->companyRepository->search($request->name);
        dd($data);
        if ($data) {
            return view('Company.index', [
                'data' => $data
            ]);
        }
        else {
            Session::flash('error', 'Data content detail not found!!!');
            return view('Company.index');
        }

        // try {
        //     $data = $this->companyRepository->search($request->name);
        //     // dd($data->name);
        //     // Session::flash('success', 'Company is created successfully');
        //     return view('Company.index', [
        //         'data' => $data
        //     ]);
        // } catch (Exception $exception) {
        //     // return back()->withError($exception->getMessage())->withInput();
        //     // DB::rollback();
        //     Session::flash('error', 'Data content detail not found!!!');
        //     // return view('Company.index', [
        //     //     'data' => $data
        //     // ]);
        // }
    }
}
