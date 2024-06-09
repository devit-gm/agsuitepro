<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LicenciasController extends Controller
{

    public function index(Request $request)
    {
        //Obtener las licencias de la tabla Licenses
        $sites = Site::where('id', '>', 1)->get();
        if ($request->method() == 'GET') {
            $licenses = [];
            return view('licencias.index', compact('licenses', 'sites', 'request'));
        } else {
            switch ($request->estado_licencia) {
                case 0:
                    $licenses = DB::connection('central')->table('licenses')->where('site_id', $request->site_id)->whereNotNull('actived')->where('expires_at', '>', Carbon::now())->orderBy('id')->get();
                    break;
                case 1:
                    $licenses = DB::connection('central')->table('licenses')->where('site_id', $request->site_id)->whereNotNull('actived')->where('expires_at', '<', Carbon::now())->orderBy('id')->get();
                    break;
                case 2:
                    $licenses = DB::connection('central')->table('licenses')->where('site_id', $request->site_id)->orderBy('id')->get();
                    break;
            }
            $errors = new \Illuminate\Support\MessageBag();
            if ($licenses->isEmpty()) {
                $errors->add('msg', 'No se encontraron licencias');
            } else {
                foreach ($licenses as $license) {
                    $license->site = Site::find($license->site_id);
                    $license->user = User::find($license->user_id);
                    $license->borrable = false;
                    $license->estado = '<span class="badge btn bt-sm btn-success">Activa</span>';

                    if (Carbon::parse($license->expires_at)->isPast()) {
                        $license->estado = '<span class="badge btn bt-sm btn-danger">Caducada</span>';
                        $license->borrable = true;
                    } else {
                        if (!$license->actived) {
                            $license->estado = '<span class="badge btn bt-sm btn-dark">Inactiva</span>';
                            $license->borrable = true;
                        }
                    }
                }
            }
            return view('licencias.index', compact('licenses', 'sites', 'request', 'errors'));
        }
    }

    public function create()
    {
        return view('licencias.create');
    }

    public function edit($id)
    {
        $license = License::find($id);
        return view('licencias.edit', compact('license'));
    }

    public function update(Request $request, $id)
    {
        $license = License::find($id);
        $license->update($request->all());
        return redirect()->route('licencias.index')->with('success', 'Licencia actualizada con éxito');
    }

    public function destroy($id)
    {
        $license = License::find($id);
        $license->delete();
        return redirect()->route('licencias.index')->with('success', 'Licencia eliminada con éxito');
    }
}
