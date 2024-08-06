<div class="row p-2">
    <div class="col-12">
        <div class="form-group">
            <label>Tenant</label>
            <input type="text" class="form-control @error('tenant_user_tenant_name') is-invalid @enderror" placeholder="Masukkan Nama Karyawan Tenant" name="tenant_user_tenant_name" value="{{$tenant->name ?? old('tenant_user_tenant_name')}}" disabled>
            @error('tenant_user_tenant_name') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        @if (!isset($tenant_user->user))
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control @error('tenant_user_username') is-invalid @enderror" placeholder="Masukkan Username" name="tenant_user_username" value="{{$user->username ?? old('tenant_user_username')}}">
            @error('tenant_user_username') <span class="text-danger">{{$message}}</span> @enderror
        </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control @error('tenant_user_password') is-invalid @enderror" placeholder="Masukkan Password" name="tenant_user_password" value="{{$tenant_user->passsword ?? old('user_passsword')}}">
                @error('tenant_user_password') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" class="form-control @error('tenant_user_password_confirmation') is-invalid @enderror" placeholder="Masukkan Konfirmasi Password" name="tenant_user_password_confirmation" >
                @error('tenant_user_password_confirmation') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <br><hr>
        @endif
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control @error('tenant_user_name') is-invalid @enderror" placeholder="Masukkan Nama Karyawan Tenant" name="tenant_user_name" value="{{$tenant_user->name ?? old('tenant_user_name')}}">
            @error('tenant_user_name') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Nomor Induk Karyawan</label>
            <input type="text" class="form-control @error('tenant_user_employee_number') is-invalid @enderror" placeholder="Masukkan Nomor Induk Karyawan Tenant" name="tenant_user_employee_number" value="{{$tenant_user->employee_number ?? old('tenant_user_employee_number')}}">
            @error('tenant_user_employee_number') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" class="form-control @error('tenant_user_phone_number') is-invalid @enderror" placeholder="Masukkan Nomor Telepon Karyawan Tenant" name="tenant_user_phone_number" value="{{$tenant_user->phone_number ?? old('tenant_user_phone_number')}}">
            @error('tenant_user_phone_number') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control @error('tenant_user_address') is-invalid @enderror" placeholder="Masukkan Alamat Karyawan Tenant" name="tenant_user_address" value="{{$tenant_user->address ?? old('tenant_user_address')}}">
            @error('tenant_user_address') <span class="text-danger">{{$message}}</span> @enderror
        </div>
    </div>
</div>

