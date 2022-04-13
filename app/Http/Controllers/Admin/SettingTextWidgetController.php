<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SettingTextWidget;
use Illuminate\Http\Request;

use App\Http\Helpers\Common;

class SettingTextWidgetController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function index()
    {

        $setting = SettingTextWidget::where('id', 1)->first();

        return view('admin.settings.text-widgets', compact('setting'));
    }

    public function storeData(Request $request)
    {
        $request->validate([
            's1_title' => 'required',
            's2_title' => 'required',
            's2_text' => 'required',
            's3_title' => 'required',
            's3_text' => 'required',
            's4_title' => 'required',
            's4_text' => 'required',
            's5_title' => 'required',
            's5_text' => 'required',
            's6_title' => 'required',
            's6_text' => 'required',
        ], [
            's1_title.*' => 'This field is required',
            's2_title.*' => 'This field is required',
            's2_text.*' => 'This field is required',
            's3_title.*' => 'This field is required',
            's3_text.*' => 'This field is required',
            's4_title.*' => 'This field is required',
            's4_text.*' => 'This field is required',
            's5_title.*' => 'This field is required',
            's5_text.*' => 'This field is required',
            's6_title.*' => 'This field is required',
            's6_text.*' => 'This field is required',
        ]);

        $getData = SettingTextWidget::where('id', 1)->first();

        if ($getData != '') {
            $setting = $getData;
        } else {
            $setting = new SettingTextWidget();
        }

        $setting->s1_title = $request->s1_title;
        $setting->s2_title = $request->s2_title;
        $setting->s2_text = $request->s2_text;
        $setting->s3_title = $request->s3_title;
        $setting->s3_text = $request->s3_text;
        $setting->s4_title = $request->s4_title;
        $setting->s4_text = $request->s4_text;
        $setting->s5_title = $request->s5_title;
        $setting->s5_text = $request->s5_text;
        $setting->s6_title = $request->s6_title;
        $setting->s6_text = $request->s6_text;
        $setting->save();

        $this->helper->one_time_message('success', 'Updated Successfully');

        return redirect()->back();
    }
}
