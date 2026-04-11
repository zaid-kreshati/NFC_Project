<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosDevice;
use App\Traits\JsonResponseTrait;

class POSController extends Controller
{
    use JsonResponseTrait;
    public function createPOS(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ]);
        $request->merge([
            'api_token' => $request->name . date('YmdHis'),
            'status' => 'active',
            'created_by' => $request->user()->id,
        ]);
        $pos = PosDevice::create($request->all());

        $pos->load('creator');

        return $this->success($pos, 'POS Device Created successfully', 201);
    }

    public function toggleStatus($id)
    {
        $pos = PosDevice::findOrFail($id);
        $pos->status = $pos->status === 'active' ? 'disabled' : 'active';
        $pos->save();
        $pos->load('creator', 'branch');

        return $this->success($pos, 'POS Device status updated successfully', 200);
    }

    public function deletePOS($id)
    {
        $pos = PosDevice::findOrFail($id);
        $pos->delete();

        return $this->success(null, 'POS Device deleted successfully', 204);
    }
}
