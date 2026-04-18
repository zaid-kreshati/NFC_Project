<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosDevice;
use App\Traits\JsonResponseTrait;
use \Illuminate\Support\Str;

class POSController extends Controller
{
    use JsonResponseTrait;
    public function createPOS(Request $request)
    {


        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'branch_id' => 'required|exists:branches,id',
            ]);
            $request->merge([
                'api_token' => 'POS_' . Str::random(32),
                'status' => 'active',
                'created_by' => $request->user()->id,
            ]);
            if (PosDevice::where('api_token', $request->api_token)->exists()) {
                return $this->error('POS Device with this API token already exists', 400);
            }
            $pos = PosDevice::create($request->all());

            $pos->load('creator', 'branch.store');

            return $this->success($pos, 'POS Device Created successfully', 201);
        } catch ( \Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function toggleStatus($id)
    {
        $pos = PosDevice::findOrFail($id);
        $pos->status = $pos->status === 'active' ? 'disabled' : 'active';
        $pos->save();
        $pos->load('creator', 'branch.store');

        return $this->success($pos, 'POS Device status updated successfully', 200);
    }

    public function deletePOS($id)
    {
        $pos = PosDevice::findOrFail($id);
        $pos->delete();

        return $this->success(null, 'POS Device deleted successfully', 204);
    }
}
