<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all users for admin
        $data = User::all();

        return view('dashboard', compact('data'));
    }
    
    public function delete(Request $request)
    {
        $id = $request->id;

        try {
            // Find the user by ID
            $user = User::findOrFail($id);
            $user->delete(); // Delete the user

            return redirect()->back()->with('success', 'User Deleted Successfully');
        } catch (Exception $e) {
            // Log the error message
            Log::error('Error deleting user: ' . $e->getMessage(), [
                'id' => $id,
                'request' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Something went wrong! Please try again later.');
        }
  }

  public function changepassword(Request $request)
  {
      $data = $request->validate([
          'id' => 'required|exists:users,id',
          'password' => 'required|min:6',
          'confirm_password' => 'required|same:password',
      ]);
  
      try {
          $user = User::findOrFail($data['id']);
          $user->password = Hash::make($data['password']);
          $user->save();
  
          return response()->json(['message' => 'Password changed successfully.'], 200);
      } catch (Exception $e) {
          Log::error('Error changing password for user ID ' . $data['id'] . ': ' . $e->getMessage(), [
              'request_data' => $request->all(),
          ]);
  
          return response()->json(['error' => 'Something went wrong! Please try again later.'], 500);
      }
  }

  public function edituser(Request $request)
  {
    $id = $request->id;
    $data = User::findOrFail($id);
    return view('user', compact('data'));
  }

  public function updateuser(Request $request, $id)
  {
      // Validate the incoming request
      $data = $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|email|unique:users,email,' . $id, // Validate unique email while ignoring the current user's email
          'role' => 'required|in:admin,user', // Validate role is either admin or user
      ]);
  
      try {
          // Find the user by ID
          $user = User::findOrFail($id);
  
          // Update user details
          $user->name = $data['name'];
          $user->email = $data['email'];
          $user->role = $data['role'];
          $user->save();
  
          return redirect()->route('dashboard')->with('success', 'User updated successfully.');
      } catch (Exception $e) {
          // Log the error
          Log::error('Error updating user ID ' . $id . ': ' . $e->getMessage(), [
              'request_data' => $request->all(),
          ]);
  
          return redirect()->back()->with('error', 'Something went wrong! Please try again later.')->withInput();
      }
  }
  

}
