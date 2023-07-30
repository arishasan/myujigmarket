<div class="row">
    <div class="col-lg-4">
        
        <center>
            <a href="{{ asset('') }}/{{ $data_produk->image }}" target="_blank">
                <img src="{{ asset('') }}/{{ $data_produk->image }}" class="img-responsive" style="max-height: 200px; max-width: 200px" alt="NONE" />
            </a>

            <div class="row">
                <div class="col-lg-6">
                    <a href="{{ asset('') }}/{{ $data_produk->image2 }}" target="_blank">
                        <img src="{{ asset('') }}/{{ $data_produk->image2 }}" class="img-responsive" style="max-height: 100px; max-width: 100px" alt="NONE" />
                    </a>
                </div>
                <div class="col-lg-6">
                    <a href="{{ asset('') }}/{{ $data_produk->image3 }}" target="_blank">
                        <img src="{{ asset('') }}/{{ $data_produk->image3 }}" class="img-responsive" style="max-height: 100px; max-width: 100px" alt="NONE" />
                    </a>
                </div>
            </div>
        </center>

    </div>
    <div class="col-lg-8">
        <div class="callout callout-success">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="text-success"><b>{{ $data_produk->nama_produk }}</b></h3>
                    <b class="text-primary">({{ $data_produk->is_new == 1 ? 'Baru' : 'Bekas' }})</b>
                </div>
                <div class="col-lg-4 text-right">
                    <b>{{ $data_produk->nama_kategori }}</b><br/>
                    <label class="{{ $data_produk->status == 1 ? 'text-success' : 'text-danger' }}">{{ $data_produk->status == 1 ? 'Aktif' : 'Non-Aktif' }}</label>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-lg-4">
                    <b>Harga Beli</b><br>
                    Rp. {{ number_format($data_produk->harga_beli) }}
                </div>
                <div class="col-lg-4">
                    <b>Harga Jual</b><br>
                    Rp. {{ number_format($data_produk->harga_jual) }}
                </div>
                <div class="col-lg-4">
                    <b>Promo Aktif?</b><br>
                    {!! $data_produk->is_promo == 1 ? 'Ya, dengan potongan <b>'.$data_produk->value_promo.'%<b/>' : 'Tidak' !!}
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-8">
                    <b>Deskripsi</b>
                    <p>{{ $data_produk->deskripsi }}</p>
                </div>
                <div class="col-lg-4">
                    <b>Berat Barang (Gram)</b><br>
                    {{ number_format($data_produk->berat_gram) }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-lg-3">
                    <b>Stok</b><br/>
                    <h4 class="text-primary"><i class="fa fa-box"></i> {{ $data_produk->stok }}</h4>
                </div>
                <div class="col-lg-3">
                    <b>Terjual</b><br/>
                    <h4 class="text-success"><i class="fa fa-shopping-cart"></i> 0</h4>
                </div>
                <div class="col-lg-3">
                    <b>Dilihat</b><br/>
                    <h4 class="text-warning"><i class="fa fa-eye"></i> {{ $data_produk->dilihat }}</h4>
                </div>
                <div class="col-lg-3">
                    <b>Wishlist</b><br/>
                    <h4 class="text-danger"><i class="fa fa-heart"></i> 0</h4>
                </div>
            </div>

        </div>
    </div>
</div>

<small>Diupdate pada <b>{{ date('d M Y, H:i:s', strtotime($data_produk->updated_at)) }}</b></small>