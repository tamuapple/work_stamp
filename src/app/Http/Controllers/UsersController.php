<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Auth;

use App\Models\User;

class UsersController extends Controller
{
  public function index(Request $request){
    $is_admin = $request->is_admin ? true : false;
    if($is_admin){
      $query = User::where('role', 1);
    }else{
      $query = User::where('role', 10);
    }
    $users = $query->oldest('role')->latest('username')->paginate(100);
    return view('users.index', compact('users', 'is_admin'));
  }
  public function show($user_id = null){
    $user = $user_id ? User::findOrFail($user_id) : Auth::user();

    if($user_id && $user->id == Auth::id()){
      return redirect()->route('home');
    }elseif($user->id != Auth::id() && Auth::user()->role != 1){
      abort(404);
    }

    $title = $user->id == Auth::id() ? 'ホーム' : $user->username;

    return view('users.show', compact('user', 'title'));
  }
  public function edit(User $user){
    if(Auth::user()->role != 1 && $user->id != Auth::id()){
      abort(404);
    }

    $title = $user->id == Auth::id() ? 'ホーム' : $user->username;

    return view('users.edit', compact('user', 'title'));
  }
  public function update(UserRequest $request, User $user){
    if(Auth::user()->role != 1 && $user->id != Auth::id()){
      abort(404);
    }

    $data = $request->except('password');

    $image = $request->file('image');
    if($image){
      $data['image'] = $image->store('image/' . Auth::id(), "public");
      $data['image'] = url('') . '/storage/' . $data['image'];
    }

    if($request->password){
      $data['password'] = bcrypt($data['password']);
    }

    $user->fill($data)->save();

    return redirect()->route('home');
  }
  public function destroy(User $user){
    if(Auth::user()->role != 1 || $user->id == Auth::id()){
      abort(404);
    }
    $user->delete();

    return back();
  }
}
