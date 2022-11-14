<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{

    /**
     * Получить всех участников.
     *
     * @return \Illuminate\Http\Response
     */

    public function show() {
        $members = Member::get();
        return response()->json($members, 200);
    }
}
