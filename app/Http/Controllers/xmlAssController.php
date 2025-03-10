<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\xmlAssModel;
use App\Exports\ExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use XMLReader;

class xmlAssController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $xmlAssModel = xmlAssModel::all();
        return view('xmlAssPage', compact('xmlAssModel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, xmlAssController $xmlAssController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, xmlAssController $xmlAssController)
    {

        $xmlAss = xmlAssModel::find($request->id);
        
    	if($xmlAss->exists()){
    		return response()->json($xmlAss);
    	}
    	else{
    		return response()->json('Failed');
    	}
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, xmlAssController $xmlAssController)
    {
        $xmlAss = xmlAssModel::find($request->id);

    	if($xmlAss->exists())
    	{

    		$xmlAss->name = $request->name;
    		$xmlAss->lastname = $request->lastname;
            $xmlAss->phone = $request->phone;
    		$data = $xmlAss->save();

    		return response()->json($data);
    	} 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, xmlAssController $xmlAssController)
    {
        $data = xmlAssModel::destroy($request->id);
    	return response()->json($data);
    }

    public function xmlUpload(Request $req) {
        
        if ($req->isMethod("POST")) {

            try{
                if (!empty($req->file('user_file'))) {
                    $xmlDataString = file_get_contents($req->file('user_file'));
                    $xmlObject = simplexml_load_string($xmlDataString);

                    $json = json_encode($xmlObject);
                    $phpDataArray = json_decode($json, true);

                    if (count($phpDataArray['contact']) > 0) {

                        $dataArray = array();

                        foreach ($phpDataArray['contact'] as $index => $data) {
                            $userDetails = xmlAssModel::where(array('phone' => $data['phone']))->first();
                            if (empty($userDetails)) {
                                $dataArray[] = [
                                    "name" => $data['name'],
                                    "lastName" => $data['lastName'],
                                    "phone" => $data['phone']
                                ];
                            }
                        }
                        xmlAssModel::insert($dataArray);
                        return back()->with('message', 'Data saved successfully and duplicate data has been ignored!');
                    }
                }   
            } catch (\Exception $exception) {
                return back()->with('message', 'XML File Not Found');
            }

             
        }

    }

     /**

    * @return \Illuminate\Support\Collection

    */

    public function export() 
    {

        return Excel::download(new ExcelExport, 'ExcelExport.xlsx');

    }
    
}
