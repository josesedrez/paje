<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidation;
use App\Mail\ForgotPassword;
use App\Mail\NewPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function list()
    {
        $users = User::all()->sortByDesc('updated_at');

        $allUsers = $users->chunk(5);

        return view('users.list', compact('allUsers'));
    }

    public function updateProfileImage(UserValidation $request, User $user)
    {
        $profileName = $this->uploadFileAndGetName($request->file('profile'), 'profiles');

        $user->update([
            'profile' => $profileName
        ]);

        return redirect(route('users.profile'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (is_null($request->file('profile'))) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            return redirect(route('users.profile'));
        }

        $profileName = $this->uploadFileAndGetName($request->file('profile'), 'profiles');

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'profile' => $profileName
        ]);

        return redirect(route('users.profile'));
    }

//    public function changePassword(User $user)
//    {
//        return view('users.password', compact('user'));
//    }

    public function updatePassword(UserValidation $request, User $user)
    {
        if (Hash::check($request->password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->newPassword)
            ]);

            return redirect(route('users.profile'));
        }

        return redirect()->back()->withErrors(['wrongPassword' => 'A senha informada está errada']);
    }

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function getAllUsers()
    {
        $users = User::orderBy('name')->get();

        $response = new Collection();

        foreach ($users as $user) {
            $item = new Collection();
            $item->put('id', $user->id);
            $item->put('name', $user->name);
            $item->put('email', $user->email);
            $item->put('profile', $user->profile);
            $item->put('evaluationsCount', $user->evaluations->count());

            $response->push($item);
        }

        return $response;
    }

    public function getUserEvaluationsCount() {
        $user = User::find(request('userId'));

        return $user->evaluations->count();
    }

    public function changeProfile()
    {
        $image = request('image');

        $exploded = explode(',', $image);

        if (str_contains($exploded[0], 'png')) {
            $extension = 'png';
        } else if (str_contains($exploded[0], 'jpg')) {
            $extension = 'jpg';
        } else if (str_contains($exploded[0], 'jpeg')) {
            $extension = 'jpg';
        } else {
            return 'invalidExtension';
        }

        $decode = base64_decode($exploded[1]);

        $filename = Str::random(10) . '.' . $extension;

        $path = public_path() . '/images/profiles/' . $filename;

        file_put_contents($path, $decode);

        $user = Auth::user();
//
//        $file = request('file');
//
//        $profileName = $this->uploadFileAndGetName($file, 'profiles');
//
        $user->profile = $filename;
        $user->save();
//
        return "sucesso";
    }

    public function editName(Request $request) {
        try {
            $user = Auth::user();
            $user->name = $request['newName'];
            $user->save();

            return $user;
        } catch (\Exception $exception) {
            return 'failed';
        }
    }

    public function editEmail(Request $request) {
        try {
            $user = Auth::user();
            $user->email = $request['newEmail'];
            $user->save();

            return $user;
        } catch (\Exception $exception) {
            return 'failed';
        }
    }

    public function editPassword(Request $request) {
        try {
            $user = Auth::user();
            $user->password = Hash::make($request['newPassword']);
            $user->save();

            toastr()->success('Senha alterada com sucesso!');
            return $user;
        } catch (\Exception $exception) {
            return 'failed';
        }
    }

    public function forgotPasswordSendEmail(Request $request)
    {
        $user = User::where('email', $request['email'])->first();

        if (empty($user)) {
            return "noUser";
        }

        Mail::to($request['email'])->send(new ForgotPassword($user->id));

        return "success";
    }

    public function changePassword(User $user)
    {
        $newPassword = Str::random(8);

        $user->password = Hash::make($newPassword);
        $user->save();

        Mail::to($user->email)->send(new NewPassword($newPassword));

        toastr()->success('Nova senha enviada para o seu e-mail!');
        return redirect('/login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
