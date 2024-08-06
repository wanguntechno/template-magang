<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control @error('role_name') is-invalid @enderror" placeholder="Masukkan Nama Role" name="role_name" value="{{$role->name ?? old('role_name')}}">
            @error('role_name') <span class="text-danger">{{$message}}</span> @enderror
        </div>

        <div class="form-group">
            <label>Kode</label>
            <input type="text" class="form-control @error('role_code') is-invalid @enderror" placeholder="Masukkan Kode Role" name="role_code" value="{{$role->code ?? old('role_code')}}">
            @error('role_code') <span class="text-danger">{{$message}}</span> @enderror
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea type="text" class="form-control @error('role_description') is-invalid @enderror" placeholder="Masukkan Deskripsi Role" name="role_description">{{$role->description ?? old('role_description')}}</textarea>
            @error('role_description') <span class="text-danger">{{$message}}</span> @enderror
        </div>
    </div>
</div>

