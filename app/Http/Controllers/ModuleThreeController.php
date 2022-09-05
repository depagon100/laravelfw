<?php

namespace App\Http\Controllers;

use App\Models\AdministrativeCost;
use App\Models\CostOfChemical;
use App\Models\CostOfNew;
use App\Models\CostOfOperating;
use App\Models\DischargeLocation;
use App\Models\DreportofWaste;
use App\Models\NewInvestment;
use App\Models\PersonEmployed;
use App\Models\PersonEmployedCost;
use App\Models\UtilityCost;
use App\Models\WaterPolutionData;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF as PDF;

class ModuleThreeController extends Controller
{
    public function index(){

        $waterpolutiondata = WaterPolutionData::all();
        $personEmployed = PersonEmployed::all();
        $personEmployedCost = PersonEmployedCost::all();
        $costofchemical = CostOfChemical::all();
        $utilitycost = UtilityCost::all();
        $administrativecosts = AdministrativeCost::all();
        $costofoperating = CostOfOperating::all();
        $newinvestment = NewInvestment::all();
        $costofnew = CostOfNew::all();
        $dischargeLocation = DischargeLocation::all();
        $dreportofwaste = DreportofWaste::all();


        return view('layout.moduleThree');
        -with(['waterpolutiondata'=>$waterpolutiondata,'personEmployed'=>$personEmployed,'personEmployedCost'=>$personEmployedCost,
        'costofchemical'=>$costofchemical,'utilitycost'=>$utilitycost,'administrativecosts'=>$administrativecosts,'costofoperating'=>$costofoperating,
        'newinvestment'=>$newinvestment,'costofnew'=>$costofnew,'dischargeLocation'=>$dischargeLocation,'dreportofwaste'=>$dreportofwaste
    ]);
    }

    public function save(Request $request){

        $waterpolutiondata  = new WaterPolutionData();
        $waterpolutiondata->Domestic_wastewater = $request->input('domwaste');
        $waterpolutiondata->Cooling_water = $request->input('coolingw');
        $waterpolutiondata->Waste_water_equipment = $request->input('wequip');
        $waterpolutiondata->Processs_wastewater = $request->input('processwaste');
        $waterpolutiondata->others_n = $request->input('othern');
        $waterpolutiondata->others_m = $request->input('othercm');
        $waterpolutiondata->Waste_water_floor = $request->input('wwfloor');
       

        $waterpolutiondata->save();

        $personEmployed = new PersonEmployed();
        $personEmployed->Month_1 = $request->input('pemonth1');
        $personEmployed->Month_2 = $request->input('pemonth2');
        $personEmployed->Month_3 = $request->input('pemonth3');

        $personEmployed->save();

        $personEmployedCost = new PersonEmployedCost();
        $personEmployedCost->Month_1 = $request->input('pecmonth1');
        $personEmployedCost->Month_2 = $request->input('pecmonth2');
        $personEmployedCost->Month_3 = $request->input('pecmonth3');

        $personEmployedCost->save();

        $costofchemical = new CostOfChemical();
        $costofchemical->Month_1 = $request->input('cocw1');
        $costofchemical->Month_2 = $request->input('cocw2');
        $costofchemical->Month_3 = $request->input('cocw3');

        $costofchemical->save();

        $utilitycost = new UtilityCost();
        $utilitycost->Month_1 = $request->input('ucw1');
        $utilitycost->Month_2 = $request->input('ucw2');
        $utilitycost->Month_3 = $request->input('ucw3');

        $utilitycost->save();

        $administrativecosts = new AdministrativeCost();
        $administrativecosts->Month_1 = $request->input('aoc1');
        $administrativecosts->Month_2 = $request->input('aoc2');
        $administrativecosts->Month_3 = $request->input('aoc3');

        $administrativecosts->save();

        $costofoperating = new CostOfOperating();
        $costofoperating->Month_1 = $request->input('colab1');
        $costofoperating->Month_2 = $request->input('colab2');
        $costofoperating->Month_3 = $request->input('colab3');

        $costofoperating->save();

        $newinvestment = new NewInvestment();
        $newinvestment->Month_1 = $request->input('nai1');
        $newinvestment->Month_2 = $request->input('nai2');
        $newinvestment->Month_3 = $request->input('nai3');

        $newinvestment->save();

        $costofnew = new CostOfNew();
        $costofnew->Month_1 = $request->input('cnai1');
        $costofnew->Month_2 = $request->input('cnai2');
        $costofnew->Month_3 = $request->input('cnai3');

        $costofnew->save();

        $dischargeLocation = $request->input('dischargeLocation');
        for ($x=0; $x<count($dischargeLocation); $x+=3 ){
            $DBdischargeLocation = new DischargeLocation();
            $DBdischargeLocation->Outlet_Number = $dischargeLocation[$x];
            $DBdischargeLocation->Location_of_Outlet = $dischargeLocation[$x+1];
            $DBdischargeLocation->Name_of_Receiving_water_body = $dischargeLocation[$x+2];

            $DBdischargeLocation->save();
        }

        $dreportofwaste = $request->input('dreportofwaste');
        for ($x=0; $x<count($dreportofwaste); $x+=9 ){
            $DBdreportofwaste = new DreportofWaste();
            $DBdreportofwaste->Outlet_No = $dreportofwaste[$x];
            $DBdreportofwaste->date = $dreportofwaste[$x+1];
            $DBdreportofwaste->NEffluent_Flow_Rate = $dreportofwaste[$x+2];
            $DBdreportofwaste->BOD_mg_L = $dreportofwaste[$x+3];
            $DBdreportofwaste->TSS_mg_L = $dreportofwaste[$x+4];
            $DBdreportofwaste->Color = $dreportofwaste[$x+5];
            $DBdreportofwaste->pH = $dreportofwaste[$x+6];
            $DBdreportofwaste->Oil_Grease_mg_L = $dreportofwaste[$x+7];
            $DBdreportofwaste->Temp_Rise = $dreportofwaste[$x+8];
            

            $DBdreportofwaste->save();
        }



        return redirect('/moduleThree');

}
        public function pdf(){

            $waterpolutiondata = WaterPolutionData::get();
            $personEmployed = PersonEmployed::get();
            $personEmployedCost = PersonEmployedCost::get();
            $costofchemical = CostOfChemical::get();
            $utilitycost = UtilityCost::get();
            $administrativecosts = AdministrativeCost::get();
            $costofoperating = CostOfOperating::get();
            $newinvestment = NewInvestment::get();
            $costofnew = CostOfNew::get();
            $dischargeLocation = DischargeLocation::get();
            $dreportofwaste = DreportofWaste::get();
            $customPaper = array(0,0,800.05,900.100);
            $pdf = PDF::loadview('layout.pdf3',['waterpolutiondata'=>$waterpolutiondata,'personEmployed'=>$personEmployed,
            'personEmployedCost'=>$personEmployedCost,'costofchemical'=>$costofchemical,'utilitycost'=>$utilitycost,'administrativecosts'=>$administrativecosts,
            'costofoperating'=>$costofoperating,'newinvestment'=>$newinvestment,'costofnew'=>$costofnew,'dischargeLocation'=>$dischargeLocation,
            'dreportofwaste'=>$dreportofwaste


            ])->setPaper($customPaper,'A4');


            return $pdf->download('moduleThree.pdf'); 

        }
    }
    
