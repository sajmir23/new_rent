<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterSellerRequest;
use App\Models\Admin\Company;
use App\Models\User;
use App\Notifications\BookingCreatedApiController;
use App\Notifications\ClientApiNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class RegisterSellerController extends Controller
{

    /**
     * Register a new seller along with their company and company admin.
     *
     * @param \App\Http\Requests\RegisterSellerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function registerSeller(RegisterSellerRequest $request)
    {
        DB::beginTransaction();

        try {

            $logoPath = null;

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('Images/Companies/Logos', 'public');
            }

            $password = Str::random(12);

            $company = Company::create([
                'name' => $request->company_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'notes' => $request->notes,
                'status' => false,
                'logo' => $logoPath,
            ]);

            $admin = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $company->email,
                'phone_number' => $company->phone,
                'user_type' => UserTypesEnum::COMPANY_ADMIN,
                'status' => false,
                'company_id' => $company->id,
                'password' => Hash::make($password),
            ]);

            $admin=User::where('user_type',UserTypesEnum::SYSTEM_ADMIN )->get();

            Notification::send($admin,new ClientApiNotification($company, $admin));


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'company' => $company,
                'admin' => $admin,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
