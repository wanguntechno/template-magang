<div class="row p-2">
    <div class="col-12">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control @error('item_category_name') is-invalid @enderror" placeholder="Masukkan Nama Kategori Item" name="item_category_name" value="{{$item_category->name ?? old('item_category_name')}}">
            @error('item_category_name') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Code</label>
            <input type="text" class="form-control @error('item_category_code') is-invalid @enderror" placeholder="Masukkan Kode Kategori Item" name="item_category_code" value="{{$item_category->code ?? old('item_category_code')}}">
            @error('item_category_code') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" class="form-control @error('item_category_description') is-invalid @enderror" placeholder="Masukkan Kode Kategori Item" name="item_category_description" value="{{$item_category->description ?? old('item_category_description')}}">
            @error('item_category_description') <span class="text-danger">{{$message}}</span> @enderror
        </div>
        
    </div>
</div>

