<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Company;
use Illuminate\Support\Facades\Input;

use App\Http\Requests\CompanieFormRequest;

use Illuminate\Support\Facades\Validator;

class CompaniesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'isActive']);
    }
    
    public function index()
    {
        $companies = Company::orderby('name')->paginate(15);

        return view('backoffice.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('backoffice.companies.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $company = new Company;
        $company->name = $request->name;
        $company->save();
    
        flash('Company successfully created!')->success();
    
        return redirect()->route('companies.index');
    }

    public function edit($company_id)
    {
        $company = Company::find($company_id);

        return view('backoffice.companies.edit', compact('company'));
    }

    public function update(Request $request, $company_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
        ])->validate();

        $company = Company::find($company_id);
        $company->name = $request->name;
        $company->save();
    
        flash('Company successfully updated!')->success();
    
        return redirect()->route('companies.index');
        
    }

    public function delete($company_id)
    {
        Company::destroy($company_id);

        flash('Company successfully deleted')->success();
    
        return redirect()->route('companies.index');
    }


    public function search(Request $request)
    {
        $companies = Company::select('companies.*');

        if( $request->input('search')){
            $companies = $companies->where('name', 'LIKE', "%" . $request->search . "%")
           ;
        } 
        
        $companies = $companies->paginate(15);
        
        return view('backoffice.companies.index', [
            'companies' => $companies->appends(Input::except('page'))
        ]);
    }
    
}
