<div class="row p-2">
    <div class="col-12">
        <div class="form-group">
            <label>Area</label>
            <select type="text" class="select2 form-control @error('tenant_area_uuid') is-invalid @enderror" name="tenant_area_uuid">
                {!! each_option($areas, 'name', ($tenant->area->uuid ?? old('tenant_area_uuid'))) !!}
            </select>
            @error('tenant_area_uuid') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control @error('tenant_name') is-invalid @enderror" placeholder="Masukkan Nama Tenant" name="tenant_name" value="{{$tenant->name ?? old('tenant_name')}}">
            @error('tenant_name') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control @error('tenant_email') is-invalid @enderror" placeholder="Masukkan Email Tenant" name="tenant_email" value="{{$tenant->email ?? old('tenant_email')}}">
            @error('tenant_email') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="text" class="form-control @error('tenant_phone_number') is-invalid @enderror" placeholder="Masukkan Nomor Telepon Tenant" name="tenant_phone_number" value="{{$tenant->phone_number ?? old('tenant_phone_number')}}">
            @error('tenant_phone_number') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Nama Pemilik Rekening</label>
                    <input type="text" class="form-control @error('tenant_bank_account_name') is-invalid @enderror" placeholder="Masukkan Nama Pemilik Rekening" name="tenant_bank_account_name" value="{{$tenant->bank_account_name ?? old('tenant_bank_account_name')}}">
                    @error('tenant_bank_account_name') <span class="text-danger">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Nomor Rekening</label>
                    <input type="text" class="form-control @error('tenant_bank_account_number') is-invalid @enderror" placeholder="Masukkan Nomor Rekening" name="tenant_bank_account_number" value="{{$tenant->bank_account_number ?? old('tenant_bank_account_number')}}">
                    @error('tenant_bank_account_number') <span class="text-danger">{{$message}}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

