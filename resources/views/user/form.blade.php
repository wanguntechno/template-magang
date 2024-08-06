<div class="row p-2">
    <div class="col-12">
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control @error('user_username') is-invalid @enderror" placeholder="Masukkan Username" name="user_username" value="{{$user->username ?? old('user_username')}}">
            @error('user_username') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        @if (!isset($user))
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control @error('user_password') is-invalid @enderror" placeholder="Masukkan Password" name="user_password" value="{{$user->passsword ?? old('user_passsword')}}">
                @error('user_password') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" class="form-control @error('user_password_confirmation') is-invalid @enderror" placeholder="Masukkan Konfirmasi Password" name="user_password_confirmation" >
                @error('user_password_confirmation') <span class="text-danger">{{$message}}</span> @enderror
            </div>
        @endif
        <div class="form-group">
            <label>Role</label>
            <select type="text" class="select2 form-control @error('user_role_uuid') is-invalid @enderror" name="user_role_uuid">
                {!! each_option($roles, 'name', ($user->userRole->role->uuid ?? old('user_role_uuid'))) !!}
            </select>
            @error('user_role_uuid') <span class="text-danger">{{$message}}</span> @enderror
        </div>
    </div>
</div>

