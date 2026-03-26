<?php

/**
 * UserController — Manages user CRUD operations (Admin-only).
 *
 * Satisfies: FR-AUTH-09, FR-AUTH-10, FR-AUTH-11
 *
 * Pre-existing state: This file DID NOT EXIST. Created from scratch.
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display user management page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $users = User::orderBy('User_ID', 'desc')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Store a new user.
     *
     * FR-AUTH-09: Password must be minimum 8 characters, stored with Hash::make()
     * FR-AUTH-10: Email must be unique — rejects duplicates
     * FR-AUTH-11: Role must be one of the valid enum values
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'Username'   => 'required|string|max:255|unique:users,Username',
                'Email'      => 'required|email|unique:users,Email',
                'Password'   => 'required|string|min:8',
                'Role'       => 'required|in:Admin,SalesStaff,FinanceStaff,InventoryManager,SystemAdmin',
                'Full_Name'  => 'required|string|max:255',
                'Phone'      => 'required|string|max:20',
                'Department' => 'required|string|max:255',
            ], [
                'Password.min'    => 'Password must be at least 8 characters.',
                'Email.unique'    => 'Email address already exists.',
                'Username.unique' => 'Username already exists.',
                'Role.in'         => 'Invalid role. Must be one of: Admin, SalesStaff, FinanceStaff, InventoryManager, SystemAdmin.',
            ]);

            $user = User::create([
                'Username'      => $validated['Username'],
                'Email'         => $validated['Email'],
                'Password_Hash' => Hash::make($validated['Password']),
                'Role'          => $validated['Role'],
                'Full_Name'     => $validated['Full_Name'],
                'Phone'         => $validated['Phone'],
                'Department'    => $validated['Department'],
                'Status'        => 'Active',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'user'    => $user,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('User creation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while creating the user.',
            ], 500);
        }
    }
}
