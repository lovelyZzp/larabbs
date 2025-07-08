<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Storage;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

     public function edit(User $user)
        {
            return view('users.edit', compact('user'));
        }

        public function update(UserRequest $request, User $user)
        {
            $data = $request->except('avatar');

            if ($request->avatar) {
                // 存储文件并获取相对路径（相对于storage/app/public）
                $relativePath = Storage::disk('public')->putFile('avatars', $request->avatar);

                // 仅保存相对路径到数据库（如 "avatars/abc123.jpg"）
                $data['avatar'] = $relativePath;
            }

            $user->update($data);
            return redirect()->route('users.show', $user->id)->with('success', '更新成功！');
        }

}
