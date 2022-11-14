<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\SecretSanta;

class SecretSantaController extends Controller
{

    /**
     * Получить по id участника информации о участнике и подопечном.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function get(Request $request) {
        $member = Member::find($request->id);
        $ward_id = $member->secretSanta()->first();
        $ward = Member::find($ward_id->id);
        return response()->json(['участник' => $member, 'подопечный' => $ward], 200);

    }
}
