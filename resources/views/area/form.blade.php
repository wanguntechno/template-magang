<div class="row p-2">
    <div class="col-12">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control @error('area_name') is-invalid @enderror" placeholder="Masukkan Nama Area" name="area_name" value="{{$area->name ?? old('area_name')}}">
            @error('area_name') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Code</label>
            <input type="text" class="form-control @error('area_code') is-invalid @enderror" placeholder="Masukkan Kode Area" name="code" value="{{$area->code ?? old('area_code')}}">
            @error('area_code') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" class="form-control @error('area_description') is-invalid @enderror" placeholder="Masukkan Deskripsi Area" name="description" value="{{$area->description ?? old('area_description')}}">
            @error('area_description') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        
    </div>
</div>

