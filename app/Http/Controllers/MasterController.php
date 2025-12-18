<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BuildingStage;
use App\Models\Customer;
use App\Models\Followup;
use App\Models\ProjectType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class MasterController extends Controller
{
    //
    public function Store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'   => 'required|string|max:255',
            'type'   => 'required|string',
            'status' => 'required|in:1,2',
        ]);

        try {
            switch ($request->type) {

                case ProjectType::TYPE:
                    ProjectType::create([
                        'name'   => $request->name,
                        'status' => $request->status,
                    ]);
                    break;

                case BuildingStage::TYPE:
                    BuildingStage::create([
                        'name'   => $request->name,
                        'status' => $request->status,
                    ]);
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid type provided'
                    ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => ucfirst(str_replace('_', ' ', $request->type)) . ' added successfully'
            ]);
        } catch (\Exception $e) {

            Log::error('Common Store Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function datatable()
    {
        $data = ProjectType::get();
        $type = ProjectType::TYPE;
        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge bg-success">Active</span>';
                } else {
                    return '<span class="badge bg-danger">Inactive</span>';
                }
            })

            ->addColumn('action', function ($row) use ($type) {
                return '
                <button class="btn btn-sm btn-primary me-1"
                    onclick="editCommon(' . $row->id . ', \'' . $type . '\')">
                    <i class="fa fa-edit"></i>
                </button>

                <button class="btn btn-sm btn-danger"
                    onclick="deleteCommon(' . $row->id . ', \'' . $type . '\')">
                    <i class="fa fa-trash"></i>
                </button>
            ';
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    public function Stagedatatable()
    {
        $data = BuildingStage::get();
        $type = BuildingStage::TYPE;
        return DataTables::of($data)
            ->addIndexColumn()

            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge bg-success">Active</span>';
                } else {
                    return '<span class="badge bg-danger">Inactive</span>';
                }
            })

            ->addColumn('action', function ($row) use ($type) {
                return '
                <button class="btn btn-sm btn-primary me-1"
                    onclick="editCommon(' . $row->id . ', \'' . $type . '\')">
                    <i class="fa fa-edit"></i>
                </button>

                <button class="btn btn-sm btn-danger"
                    onclick="deleteCommon(' . $row->id . ', \'' . $type . '\')">
                    <i class="fa fa-trash"></i>
                </button>
            ';
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    private function getModel($type)
    {
        return match ($type) {
            ProjectType::TYPE => new ProjectType(),
            BuildingStage::TYPE => new BuildingStage(),
            default => null
        };
    }

    public function edit($type, $id)
    {
        $model = $this->getModel($type);

        if (!$model) {
            return response()->json(['message' => 'Invalid type'], 404);
        }

        return $model->findOrFail($id);
    }
    public function update(Request $request, $type, $id)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|in:1,2',
        ]);

        $model = $this->getModel($type);

        if (!$model) {
            return response()->json(['message' => 'Invalid type'], 404);
        }

        $record = $model->findOrFail($id);
        $record->update($request->only('name', 'status'));

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $type)) . ' updated successfully'
        ]);
    }
    public function destroy($type, $id)
    {
        $model = match ($type) {
            ProjectType::TYPE => ProjectType::class,
            BuildingStage::TYPE => BuildingStage::class,
            default => null
        };

        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid type'
            ], 404);
        }

        $model::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => ucfirst(str_replace('_', ' ', $type)) . ' deleted successfully'
        ]);
    }

    // Customer Store
    public function CustomerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:15|unique:customers,phone',
        ]);
        if ($validator->fails()) {
            // Return validation errors
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
        try {
            Customer::create([
                'name'            => $request->name,
                'email'           => $request->email,
                'phone'           => $request->phone,
                'alternative_phone'     => $request->alternative_phone,
                'address'         => $request->address,
                'state'           => $request->state,
                'city'            => $request->city,
                'building_stage'  => $request->building_stage,
                'project_type' => $request->type_of_project,
                'estimate'        => $request->estimate,
                'aadhar_no'       => $request->aadhar_no,
                'gst_no'          => $request->gst_no,
                'status'          => 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Customer added successfully'
            ]);
        } catch (\Exception $e) {
            // Log full error for debugging
            Log::error('Customer Store Error: ' . $e->getMessage());

            // Return actual error message for debugging
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function CustomerDatatable()
    {
        $data = Customer::with(['buildingStage', 'projectType', 'followUps'])->latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('building_stage_name', function ($row) {
                return $row->buildingStage ? $row->buildingStage->name : '-';
            })
            ->addColumn('project_type_name', function ($row) {
                return $row->projectType ? $row->projectType->name : '-';
            })
            ->addColumn('action', function ($row) {
                $btn = '<button class="btn btn-sm btn-primary me-1" onclick="editCustomer(' . $row->id . ')">
                        <i class="fa fa-edit"></i>
                    </button>';
                $btn .= '<button class="btn btn-sm btn-danger me-1"
                        onclick="deleteCustomer(' . $row->id . ')">
                        <i class="fa fa-trash"></i>
                    </button>';
                $btn .= '<button class="btn btn-sm btn-info toggleFollowUp" data-id="' . $row->id . '">
                            <i class="fa fa-eye"></i> 
                        </button>';
                return $btn;
            })
            ->addColumn('followup', function ($row) {
                $btn = '<button class="btn btn-sm btn-info toggleFollowUp" data-id="' . $row->id . '">
                        <i class="fa fa-eye"></i> 
                    </button>';
                return $btn;
            })
            ->rawColumns(['action', 'status', 'project_type_name', 'building_stage_name', 'followup'])
            ->make(true);
    }
    public function CustomerEdit($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }
    public function CustomerUpdate(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $validator = Validator::make($request->all(), [

            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // Update fields directly from request
        $customer->name           = $request->name;
        $customer->email          = $request->email;
        $customer->phone          = $request->phone;
        $customer->alternative_phone    = $request->alternative_phone;
        $customer->address        = $request->address;
        $customer->state          = $request->state;
        $customer->city           = $request->city;
        $customer->building_stage = $request->building_stage;
        $customer->project_type   = $request->type_of_project;
        $customer->estimate       = $request->estimate;
        $customer->aadhar_no      = $request->aadhar_no;
        $customer->gst_no         = $request->gst_no;
        $customer->save();

        return response()->json(['message' => 'Customer updated successfully']);
    }

    // Delete Customer
    public function CustomerDestroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }

    public function FollowupStore(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'followup_date.*' => 'required|date',
            'followup_description.*' => 'required|string',
        ]);

        try {
            foreach ($request->followup_date as $key => $date) {
                Followup::create([
                    'customer_id' => $request->customer_id,
                    'followup_date' => $date,
                    'followup_description' => $request->followup_description[$key],
                ]);
            }


            return response()->json([
                'status' => true,
                'message' => 'Followups saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function getFollowUps($id)
    {
        $customer = Customer::with('followUps')->findOrFail($id);
        // dd($customer);
        return response()->json($customer->followUps);
    }


    public function FollowupDatatable(Request $request)
    {
        $query = Followup::with('customer');

        // Dropdown filter
        if ($request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('customer_name', function ($row) {
                return $row->customer->name ?? '-';
            })

            ->addColumn('phone', function ($row) {
                return $row->customer->phone ?? '-';
            })

            ->editColumn('followup_date', function ($row) {
                return date('d-m-Y', strtotime($row->followup_date));
            })

            ->addColumn('description', function ($row) {
                return $row->followup_description;
            })

            // 🔥 THIS IS THE FIX — GLOBAL SEARCH
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {

                    $search = $request->search['value'];

                    $query->where(function ($q) use ($search) {

                        // Search in followups table
                        $q->where('followup_description', 'like', "%{$search}%")
                            ->orWhere('followup_date', 'like', "%{$search}%");

                        // Search in related customer table
                        $q->orWhereHas('customer', function ($qc) use ($search) {
                            $qc->where('name', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                    });
                }
            })

            ->rawColumns(['description'])
            ->make(true);
    }
    public function ReminderFollowupDatatable(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $query = Followup::with('customer')
            ->where('status', 1)
            ->whereHas('customer', function ($q) {
                $q->where('cus_status', 1);
            });

        // 🔹 Customer filter
        if ($request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        // 🔹 Date filters
        if ($request->from_date && $request->to_date) {

            // From & To date
            $query->whereBetween('followup_date', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        } elseif ($request->from_date) {

            // Single date
            $query->whereDate('followup_date', $request->from_date);
        } else {

            // ✅ Default: TODAY reminders
            $query->whereDate('followup_date', $today);
        }

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('customer_name', fn($row) => $row->customer->name ?? '-')
            ->addColumn('phone', fn($row) => $row->customer->phone ?? '-')

            ->editColumn('followup_date', function ($row) {
                return Carbon::parse($row->followup_date)->format('d-m-Y');
            })

            ->addColumn('description', fn($row) => $row->followup_description)

            // 🔍 Global Search
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {

                    $search = $request->search['value'];

                    $query->where(function ($q) use ($search) {
                        $q->where('followup_description', 'like', "%{$search}%")
                            ->orWhereDate('followup_date', 'like', "%{$search}%")
                            ->orWhereHas('customer', function ($qc) use ($search) {
                                $qc->where('name', 'like', "%{$search}%")
                                    ->orWhere('phone', 'like', "%{$search}%");
                            });
                    });
                }
            })

            ->rawColumns(['description'])
            ->make(true);
    }

    public function saveRoleAccess(Request $request)
    {
        $menuIds = $request->menu_ids ?? [];

        User::where('id', $request->role_id)
            ->update([
                'menus' => json_encode($menuIds),
                'updated_at' => now()
            ]);

        return back()->with('success', 'Role access updated successfully');
    }

}
