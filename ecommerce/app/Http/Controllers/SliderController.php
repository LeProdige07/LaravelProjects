<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    //

    public function addslider(){
        return view('admin.addslider');
    }

    public function saveslider(Request $request){
        $this->validate($request, [
            'description1' => 'required',
            'description2' => 'required',
            'slider_image' => 'image|required|max:1999'
        ]);

            //nom de l'image avec extension
            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
            //nom  du fichier
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //extension
            $ext = $request->file('slider_image')->getClientOriginalExtension();
            //nom de l'image to store
            $fileNameToStrore = $filename . '_' . time() . '.' . $ext;
            //upload image et creation du dossier de stockage
            $path = $request->file('slider_image')->storeAs('public/slider_images', $fileNameToStrore);


        $slider = new Slider();
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        $slider->slider_image = $fileNameToStrore;
        $slider->status = 1;

        $slider->save();
        return redirect('/sliders')->with('status', 'Le slider a été enregistré avec succès !!');
    }
    public function edit_slider($id){
        $slider = Slider::find($id);
        return view('admin.editslider')->with('slider',$slider);
    }
    public function updateslider(Request $request){
        $this->validate($request, [
            'description1' => 'required',
            'description2' => 'required',
            'slider_image' => 'image|max:1999'
        ]);

        $slider = Slider::find($request->input('id'));
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');

        if ($request->hasFile('slider_image')) {
            //nom de l'image avec extension
            $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
            //nom  du fichier
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //extension
            $ext = $request->file('slider_image')->getClientOriginalExtension();
            //nom de l'image to store
            $fileNameToStrore = $filename . '_' . time() . '.' . $ext;
            //upload image et creation du dossier de stockage
            $path = $request->file('slider_image')->storeAs('public/slider_images', $fileNameToStrore);

            Storage::delete('public/slider_images/' . $slider->slider_image);

            $slider->slider_image = $fileNameToStrore;
        }

        $slider->update();

        return redirect('/sliders')->with('status', 'Le slider a été modifié avec succès !!');
    }
    public function delete_slider($id){
        $slider = Slider::find($id);

        Storage::delete('public/slider_images/' . $slider->slider_image);

        $slider->delete();

        return back()->with('status', 'Le slider a été supprimé avec succes !!');
    }
    public function sliders(){
        $sliders = Slider::all();
        return view('admin.sliders')->with('sliders',$sliders);
    }
    public function activer_slider($id)
    {
        $slider = Slider::find($id);

        $slider->status = 1;

        $slider->save();

        return back();
    }
    public function desactiver_slider($id)
    {
        $slider = Slider::find($id);

        $slider->status = 0;

        $slider->save();

        return back();
    }
}
